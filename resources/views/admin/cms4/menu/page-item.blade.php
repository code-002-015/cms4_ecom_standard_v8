<li>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input page" id="link{{ $page->id }}" data-id="{{ $page->id }}" data-label="{{ $page->label }}" data-name="{{ $page->name }}" data-url="{{ url('/page/'.$page->slug) }}" data-status="{{ $page->status }}">
        <label class="custom-control-label" for="link{{ $page->id }}"><span  @if ($page->status == "PRIVATE") style="opacity: 0.4;" @endif class="page-title">{{ ($page->label != '') ? $page->label : $page->name }}</span></label>
    </div>
<li>
@if ($page->sub_pages)
    <ul>
        @foreach ($page->sub_pages as $sub_page)
            @include('admin.cms4.menu.page-item', ['page' => $sub_page])
        @endforeach
    </ul>
@endif
