<ul class="nav nav-aside">
    <li class="nav-item">
        <a href="{{route('home')}}" target="_blank" class="nav-link">
            <i data-feather="external-link"></i>
            <span>View Website</span>
        </a>
    </li>
    <li class="nav-label mg-t-25">CMS</li>
    <li class="nav-item @if (url()->current() == route('dashboard')) active @endif">
        <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="home"></i><span>Dashboard</span></a>
    </li>
    
    @if (auth()->user()->has_access_to_pages_module())
        <li class="nav-item with-sub @if (request()->routeIs('pages*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="layers"></i> <span>Pages</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'pages.edit' || \Route::current()->getName() == 'pages.index' || \Route::current()->getName() == 'pages.index.advance-search') class="active" @endif><a href="{{ route('pages.index') }}">Manage Pages</a></li>
                @if(auth()->user()->has_access_to_route('pages.create'))
                <li @if (\Route::current()->getName() == 'pages.create') class="active" @endif><a href="{{ route('pages.create') }}">Create a Page</a></li>
                @endif

            </ul>
        </li>
    @endif

    @if (auth()->user()->has_access_to_albums_module())
        <li class="nav-item with-sub @if (request()->routeIs('albums*')) active show @endif">
            <a href="#" class="nav-link"><i data-feather="image"></i> <span>Banners</span></a>
            <ul>
                <li @if (url()->current() == route('albums.edit', 1)) class="active" @endif><a href="{{ route('albums.edit', 1) }}">Manage Home Banner</a></li>
                <li @if (\Route::current()->getName() == 'albums.index' || (\Route::current()->getName() == 'albums.edit' && url()->current() != route('albums.edit', 1))) class="active" @endif><a href="{{ route('albums.index') }}">Manage Subpage Banners</a></li>
                @if(auth()->user()->has_access_to_route('albums.create'))
                    <li @if (\Route::current()->getName() == 'albums.create') class="active" @endif><a href="{{ route('albums.create') }}">Create an Album</a></li>
                @endif
            </ul>
        </li>
    @endif

    @if (auth()->user()->has_access_to_file_manager_module())
        <li class="nav-item @if (\Route::current()->getName() == 'file-manager.index') active @endif">
            <a href="{{ route('file-manager.index') }}" class="nav-link"><i data-feather="folder"></i> <span>Files</span></a>
        </li>
    @endif

    @if (auth()->user()->has_access_to_menu_module())
        <li class="nav-item with-sub @if (request()->routeIs('menus*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="menu"></i> <span>Menu</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'menus.edit' || \Route::current()->getName() == 'menus.index') class="active" @endif><a href="{{ route('menus.index') }}">Manage Menu</a></li>
                <li @if (\Route::current()->getName() == 'menus.create') class="active" @endif><a href="{{ route('menus.create') }}">Create a Menu</a></li>
            </ul>
        </li>
    @endif
    @if (auth()->user()->has_access_to_news_module() || auth()->user()->has_access_to_news_categories_module())
        <li class="nav-item with-sub @if (request()->routeIs('news*') || request()->routeIs('news-categories*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="edit"></i> <span>News</span></a>
            <ul>
                @if (auth()->user()->has_access_to_news_module())
                    <li @if (\Route::current()->getName() == 'news.index' || \Route::current()->getName() == 'news.edit'  || \Route::current()->getName() == 'news.index.advance-search') class="active" @endif><a href="{{ route('news.index') }}">Manage News</a></li>
                    <li @if (\Route::current()->getName() == 'news.create') class="active" @endif><a href="{{ route('news.create') }}">Create a News</a></li>
                @endif
                @if (auth()->user()->has_access_to_news_categories_module())
                    <li @if (\Route::current()->getName() == 'news-categories.index' || \Route::current()->getName() == 'news-categories.edit') class="active" @endif><a href="{{ route('news-categories.index') }}">Manage Categories</a></li>
                    <li @if (\Route::current()->getName() == 'news-categories.create') class="active" @endif><a href="{{ route('news-categories.create') }}">Create a Category</a></li>
                @endif
            </ul>
        </li>
    @endif

    <li class="nav-item with-sub @if (request()->routeIs('account*') || request()->routeIs('website-settings*') || request()->routeIs('audit*')) active show @endif">
        <a href="" class="nav-link"><i data-feather="settings"></i> <span>Settings</span></a>
        <ul>
            <li @if (\Route::current()->getName() == 'account.edit') class="active" @endif><a href="{{ route('account.edit') }}">Account Settings</a></li>

            @if (auth()->user()->has_access_to_website_settings_module())
                <li @if (\Route::current()->getName() == 'website-settings.edit') class="active" @endif><a href="{{ route('website-settings.edit') }}">Website Settings</a></li>
            @endif

            @if (auth()->user()->has_access_to_audit_logs_module())
                <li @if (\Route::current()->getName() == 'audit-logs.index') class="active" @endif><a href="{{ route('audit-logs.index') }}">Audit Trail</a></li>
            @endif
        </ul>
    </li>
    @if (auth()->user()->is_an_admin())
        <li class="nav-item with-sub @if (request()->routeIs('users*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="users"></i> <span>Users</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'users.index' || \Route::current()->getName() == 'users.edit') class="active" @endif><a href="{{ route('users.index') }}">Manage Users</a></li>
                <li @if (\Route::current()->getName() == 'users.create') class="active" @endif><a href="{{ route('users.create') }}">Create a User</a></li>
            </ul>
        </li>
    @endif
    @if (auth()->user()->is_an_admin())
        <li class="nav-item with-sub @if (request()->routeIs('role*') || request()->routeIs('access*') || request()->routeIs('permission*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="user"></i> <span>Account Management</span></a>
            <ul>
                <li @if (request()->routeIs('role*')) class="active" @endif><a href="{{ route('role.index') }}">Roles</a></li>
                <li @if (request()->routeIs('access*')) class="active" @endif><a href="{{ route('access.index') }}">Access Rights</a></li>
                @if (env('APP_DEBUG') == "false")
                    <li @if (request()->routeIs('permission*')) class="active" @endif><a href="{{ route('permission.index') }}">Permissions</a></li>
                @endif
            </ul>
        </li>
    @endif

    <li class="nav-label mg-t-25">E-Commerce</li>
        
    <li class="nav-item @if (url()->current() == route('ecom-dashboard')) active @endif">
        <a href="{{ route('ecom-dashboard') }}" class="nav-link"><i data-feather="home"></i><span>Dashboard</span></a>
    </li>

    @if(auth()->user()->has_access_to_module('products') || auth()->user()->has_access_to_module('product_category'))
        <li class="nav-item with-sub @if (request()->routeIs('products*') || request()->routeIs('product-categories*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="box"></i> <span>Products</span></a>
            <ul>
                @if (auth()->user()->has_access_to_module('products'))
                    <li @if (\Route::current()->getName() == 'products.index' || \Route::current()->getName() == 'products.edit') class="active" @endif><a href="{{ route('products.index') }}">Manage Products</a></li>
                    @if(auth()->user()->has_access_to_route('products.create'))
                        <li @if (\Route::current()->getName() == 'products.create') class="active" @endif><a href="{{ route('products.create') }}">Create a Product</a></li>
                    @endif
                @endif
                @if (auth()->user()->has_access_to_module('product_category'))
                    <li @if (\Route::current()->getName() == 'product-categories.index' || \Route::current()->getName() == 'product-categories.edit') class="active" @endif><a href="{{ route('product-categories.index') }}">Manage Categories</a></li>
                    @if(auth()->user()->has_access_to_route('product-categories.create'))
                        <li @if (\Route::current()->getName() == 'product-categories.create') class="active" @endif><a href="{{ route('product-categories.create') }}">Create a Category</a></li>
                    @endif
                @endif

                <li @if (\Route::current()->getName() == 'product-favorite.list') class="active" @endif><a href="{{ route('product-favorite.list') }}">Favorites</a></li>

                <li @if (\Route::current()->getName() == 'product-wishlist.list') class="active" @endif><a href="{{ route('product-wishlist.list') }}">Wishlist</a></li>
            </ul>
        </li>
    @endif

    @if(auth()->user()->has_access_to_module('inventory'))
        <li class="nav-item with-sub @if (request()->routeIs('inventory*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="users"></i> <span>Inventory</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'inventory.index') class="active" @endif><a href="{{ route('inventory.index') }}">Manage Inventory</a></li>
            </ul>
        </li>
    @endif

    @if(auth()->user()->has_access_to_module('promos'))
        <li class="nav-item with-sub @if (request()->routeIs('promos*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="users"></i> <span>Promos</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'promos.index'|| \Route::current()->getName() == 'promos.edit') class="active" @endif><a href="{{ route('promos.index') }}">Manage Promos</a></li>
                <li @if (\Route::current()->getName() == 'promos.create') class="active" @endif><a href="{{ route('promos.create') }}">Create a Promo</a></li>
            </ul>
        </li>
    @endif

    @if (auth()->user()->has_access_to_module('delivery_flat_rate'))
        <li class="nav-item with-sub @if (request()->routeIs('locations*')) active show @endif">
            <a href="" class="nav-link"><i data-feather="box"></i> <span>Delivery Flat Rates</span></a>
            <ul>
                <li @if (\Route::current()->getName() == 'locations.index' || \Route::current()->getName() == 'locations.edit') class="active" @endif><a href="{{ route('locations.index') }}">Manage Flat Rates</a></li>
                @if (auth()->user()->has_access_to_route('locations.create'))
                    <li @if (\Route::current()->getName() == 'locations.create') class="active" @endif><a href="{{ route('locations.create') }}">Create New Flat Rate</a></li>
                @endif
            </ul>
        </li>
    @endif


    <li class="nav-label mg-t-25">Template Builder</li>
    <li class="nav-item with-sub @if (request()->routeIs('templates*') || request()->routeIs('template-categories*')) active show @endif">
        <a href="" class="nav-link"><i data-feather="edit"></i> <span>Templates</span></a>
        <ul>
            <li><a href="{{ route('templates.index') }}">Manage Templates</a></li>
            <li><a href="{{ route('templates.create') }}">Create a Template</a></li>
            <li><a href="{{ route('template-categories.index') }}">Manage Categories</a></li>
            <li><a href="{{ route('template-categories.create') }}">Create a Category</a></li>
        </ul>
    </li>
</ul>
