@php
    $randomId = rand(1, 1000000000);
@endphp
@if ($link->is_page_type())
    <li class="dd-item" id="li{{ $randomId }}" data-id="{{ $link->id }}" data-page_id="{{ $link->page_id }}" data-type="page" data-label="{{ $link->page->label }}">
        <div class="dd-handle bg-light">
            <span class="drag-indicator"></span>
            <div class="pr-2">
                <div class="d-flex align-items-start align-items-md-end align-items-lg-end flex-column flex-md-row flex-lg-row">
                <strong class="mg-r-5" @if($link->page->status == "PRIVATE") style="opacity: 0.4;" @endif>{{ $link->page->name }}</strong>
                <span class="tx-italic tx-12 tx-gray-500"  id="label{{ $randomId }}">{{ $link->page->label }}</span>
                </div>
                <p class="mg-b-0 tx-gray-500 tx-11 text-break">
                    {{ $link->page->get_url() }}
                </p>
            </div>
            <div class="dd-nodrag btn-group ml-auto">
                <a href="#prompt-edit-menu" class="tx-bold tx-uppercase tx-10 tx-dark mg-r-10" data-toggle="modal" data-element-id="{{ $randomId }}">Edit</a>
                <a href="#prompt-remove" class="tx-bold tx-uppercase tx-10 tx-danger" data-toggle="modal" data-element-id="{{ $randomId }}" data-id="{{ $link->id }}">Remove</a>
            </div>
        </div>
        @if ($link->sub_pages_by_order()->count())
            <ol class="dd-list">
                @foreach ($link->sub_pages_by_order() as $subLink)
                    @include('admin.cms4.menu.menu-item', ['link' => $subLink])
                @endforeach
            </ol>
        @endif
    </li>
@elseif ($link->is_external_type())
    <li class="dd-item" id="li{{ $randomId }}" data-id="{{ $link->id }}" data-page_id="{{ $link->id }}" data-uri="{{ $link->uri }}" data-label="{{ $link->label }}" data-type="external" data-target="{{ $link->target }}">
        <div class="dd-handle bg-light">
            <span class="drag-indicator"></span>
            <div>
                <strong id="label{{ $randomId }}">{{ $link->label }}</strong>
                <p class="mg-b-0 tx-gray-500 tx-11 text-break" id="url{{ $randomId }}">
                    {{$link->uri}}
                </p>
            </div>
            <div class="dd-nodrag btn-group ml-auto">
                <a href="#prompt-edit-external-url" class="tx-bold tx-uppercase tx-10 tx-dark mg-r-10" data-toggle="modal" data-element-id="{{ $randomId }}">Edit</a>
                <a href="#prompt-remove" class="tx-bold tx-uppercase tx-10 tx-danger" data-toggle="modal" data-element-id="{{ $randomId }}" data-id="{{ $link->id }}">Remove</a>
            </div>
        </div>
        @if ($link->sub_pages_by_order()->count())
            <ol class="dd-list">
                @foreach ($link->sub_pages_by_order() as $subLink)
                    @include('admin.cms4.menu.menu-item', ['link' => $subLink])
                @endforeach
            </ol>
        @endif
    </li>
@endif
