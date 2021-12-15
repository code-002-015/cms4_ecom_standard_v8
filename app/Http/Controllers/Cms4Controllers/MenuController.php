<?php

namespace App\Http\Controllers\Cms4Controllers;

use Facades\App\Helpers\ListingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MenusHasPages;
use App\Models\Permission;
use App\Models\Menu;
use App\Models\Page;


class MenuController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        Permission::module_init($this, 'menu');
    }

    public function index()
    {
        $searchFields = ['name'];
        $filterFields = ['updated_at', 'name', 'is_active'];

        $menus = ListingHelper::sort_by('is_active')
            ->filter_fields($filterFields)
            ->simple_search(Menu::class, $searchFields);

        $filter = ListingHelper::filter_fields($filterFields)->get_filter($searchFields);

        $searchType = 'simple_search';

        return view('admin.cms4.menu.index', compact('menus','filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::where('parent_page_id', 0)->get();

        return view('admin.cms4.menu.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Menu::has_invalid_data() || MenusHasPages::has_invalid_data()) {
            $errors = Menu::get_error_messages()
                ->merge(MenusHasPages::get_error_messages());

            return back()->withErrors($errors)->withInput();
        }

        if ($this->is_set_to_active()) {
            $this->inactive_active_menu_except(0);
        }

        $request->request->add(['user_id' => auth()->id()]);

        $menu = Menu::create(request()->all());

        $menuLinks = json_decode(request('pages_json'), true);

        foreach ($menuLinks as $index => $link) {
            $this->store_and_update_menu_links($menu->id, $link, $index, 0);
        }

        return redirect()->route('menus.index')->with('success', __('standard.menu.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $pages = Page::where('parent_page_id', 0)->get();

        return view('admin.cms4.menu.edit', compact('pages', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if (Menu::has_invalid_data() || MenusHasPages::has_invalid_data()) {
            $errors = Menu::get_error_messages()
                ->merge(MenusHasPages::get_error_messages());

            return back()->withErrors($errors)->withInput();
        }

        if ($this->is_set_to_active()) {
            $this->inactive_active_menu_except($menu->id);
        }

        $request->request->add(['user_id' => auth()->id()]);

        $menu->update(request()->all());

        $this->remove_links_from_menu(request('remove_links'));

        foreach ($menu->navigation()->where('parent_id', '!=', 0)->get() as $menuItem)
        {
            if (!$menuItem->parent_page) {
                $menuItem->forceDelete();
            }
        }

        $menuLinks = json_decode(request('pages_json'), true);

        foreach ($menuLinks as $index => $link) {
            $this->store_and_update_menu_links($menu->id, $link, $index, 0);
        }

        return back()->with('success', __('standard.menu.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Menu $menu
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->update(['user_id' => auth()->id()]);

        if ($menu->delete()) {
            return redirect()->route('menus.index')->with('success', __('standard.menu.delete_success'));
        } else {
            return redirect()->route('menus.index')->with('error', __('standard.menu.delete_failed'));
        }
    }

    public function destroy_many()
    {
        $menuIds = explode(',', request('ids'));
        if (sizeof($menuIds) > 0 ) {
            $menus = Menu::whereIn('id', $menuIds);
            foreach ($menus as $menu) {
                $menu->update(['user_id' => auth()->id()]);
            }

            $delete = Menu::whereIn('id', $menuIds)->delete();

            if ($delete) {
                return redirect()->route('menus.index')->with('success', __('standard.menu.delete_success'));
            }
        }

        return redirect()->route('menus.index')->with('error', __('standard.menu.delete_failed'));
    }

    public function restore($menu)
    {
        $restorePage = Menu::whereId($menu)->restore();

        return back()->with('success', __('standard.menu.restore_success'));
    }

    public function store_and_update_menu_links($menuId, $link, $index, $parentId)
    {
        if ($this->is_page_type($link)) {
            $this->update_page_label($link['page_id'], $link['label']);
        }

        if ($this->is_external_type($link)) {
            $link['page_id'] = 0;
        }

        $link['page_order'] = $index + 1;
        $link['parent_id'] = $parentId;
        $link['user_id'] = auth()->id();

        if ($this->is_existing_menu_link($link)) {
            MenusHasPages::find($link['id'])->update($link);
            $parentPageId = $link['id'];
        } else {
            $link['menu_id'] = $menuId;
            $parentPage = MenusHasPages::create($link);
            $parentPageId = $parentPage->id;
        }

        if ($this->has_sub_links($link)) {
            foreach ($link['children'] as $subIndex => $subPage) {
                $this->store_and_update_menu_links($menuId, $subPage, $subIndex, $parentPageId);
            }
        }
    }

    public function remove_links_from_menu($links)
    {
        MenusHasPages::find($links ?? [])->each(function ($link, $key) {
            $link->forceDelete();
        });
    }

    public function quick_update(Request $request, Menu $menu)
    {
        if (Menu::has_invalid_data()) {
            return back()->withErrors(Menu::get_error_messages())->withInput();
        }

        if ($this->is_set_to_active()) {
            $this->inactive_active_menu_except($menu->id);
        }

        $updateData = [
            'name' => request('name'),
            'is_active' => request('is_active'),
            'user_id' => auth()->id()
        ];

        if ($menu->is_active) {
            unset($updateData['is_active']);
        }

        $menu->update($updateData);

        if($menu){
            return redirect()->route('menus.index')->with('success', __('standard.menu.update_success'));
        }

        return redirect()->route('menus.index');
    }

    public function is_existing_menu_link($link)
    {
        return (isset($link['id']));
    }

    public function has_sub_links($link)
    {
        return isset($link['children']);
    }

    public function update_page_label($id, $label)
    {
        $page = Page::find($id);
        $page->label = $label;
        $page->save();
    }

    public function is_page_type($page)
    {
        return $page['type'] == 'page' && isset($page['label']);
    }

    public function is_external_type($page)
    {
        return $page['type'] == 'external';
    }

    public function is_set_to_active()
    {
        return request('is_active') == 1;
    }

    public function inactive_active_menu_except($menuId)
    {
        Menu::where('is_active', 1)->where('id', '!=', $menuId)->update(['is_active' => 0]);
    }
}
