@extends('admin.layouts.app')

@section('pagetitle')
    Create Menu
@endsection

@section('pagecss')
    <style>
        #errorMessage {
            list-style-type: none;
            padding: 0;
            margin-bottom: 0px;
        }

        #external_reset {
            display: none;
        }
        .dd-no-handle {
            margin-bottom: -1px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            background-color: #fff;
            border-top: 1px solid #ecedf1;
            border-bottom: 1px solid #ecedf1;
        }
    </style>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('menus.index')}}">Menu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create a Menu</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create a Menu</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <form id="menuForm" method="POST" action="{{ route('menus.store') }}">
                @csrf
                @method('POST')
                <div class="form-group mg-b-20">
                    <label class="d-block">Menu Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" required name="name" value="{{ old('name') }}" @htmlValidationMessage({{__('standard.empty_all_field')}})>
					@error('name')
                        <span class="text-danger">{{ $message }}</span>
					@enderror
                    <input type="hidden" required name="pages_json" id="menuPages">
                    <input type="hidden" required name="is_active" id="menuIsActive">
                    <input type="submit" id="submitForm" class="d-none">
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header pd-0" id="headingOne">
                        <h2>
                            <button class="btn btn-link btn-sm tx-bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Pages
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body nav-page">

                            <div class="row row-xs">
                                <div class="col-md-8">
                                    <div class="search-form mg-t-3">
                                        <input type="search" class="form-control" placeholder="Search" id="searchPage">
                                        <button class="btn" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success btn-sm btn-secondary btn-block btn-uppercase" type="button" id="addPageToMenu"><i data-feather="plus"></i> Add</button>
                                </div>
                            </div>

                            <div id="scroll3" class="nav-pagelist scrollbar-lg pos-relative" style="height: 400px;">
                                <ul>
                                    @foreach ($pages as $page)
                                        @if ($page->name == 'Footer' && $page->page_type == 'default')
                                        @else
                                            @include('admin.cms4.menu.page-item', ['page' => $page])
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header pd-0" id="headingOne">
                        <h2>
                            <button class="btn btn-link btn-sm tx-bold" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                                URL
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <form id="externalLinkForm">
                                <div class="form-group">
                                    <label class="d-block">Insert URL *</label>
                                    <input type="text" class="form-control" required id="external_url" pattern="https?://.+" @htmlValidationMessage({{__('standard.menu.invalid_url')}})>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Label *</label>
                                    <input type="text" class="form-control" required id="external_label" maxlength="150" @htmlValidationMessage({{__('standard.empty_all_field')}})>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="external_target"><label for="external_target">Open in New Tab</label>
                                </div>
                                <input type="reset" id="external_reset">
                                <button class="btn btn-primary btn-sm btn-secondary btn-uppercase"><i data-feather="plus"></i> Add to Menu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8" id="sortablemulti">
            <section class="card card-fluid">
                <header class="card-header border-bottom-0">
                    <h5><strong>Structure</strong></h5>
                    <p class="pd-b-0 mg-b-0">Drag each item into the order you prefer.</p>
                </header>
                <!-- .nestable -->
                <div id="nestable01" class="dd">
                    <!-- .dd-list -->
                    <ol class="dd-list">
                    </ol>
                    <!-- /.dd-list -->
                </div>
                <!-- /.nestable -->
            </section>
            @error('pages_json')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="mg-t-20"></div>
            <div class="form-group">
                <!-- <label class="d-block">Set as active?</label> -->
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input form-control @error('is_active') is-invalid @enderror" id="status">
                    <label class="custom-control-label" for="status" id="statusLabel">Inactive</label>
                </div>
            </div>
            <button id="saveMenu" class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Menu</button>
            <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
        </div>
    </div>
</div>
<div class="modal effect-scale" id="prompt-remove" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Remove menu item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this item? You can not undo this action.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="btnRemove">Yes, Remove</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompt-edit-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit menu label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="page_form">
                <div class="modal-body">
                    <input type="hidden" name="type" value="page" required />
                    <div class="form-group">
                        <label class="d-block">Label *</label>
                        <input type="text" class="form-control" name="label" id="page-label" required  maxlength="150">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary save_changes">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="prompt-edit-external-url" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit external link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="page_form">
                <div class="modal-body">
                    <input type="hidden" name="type" value="external" required />
                    <div class="form-group">
                        <label class="d-block">Label *</label>
                        <input type="text" class="form-control" name="label" id="external-label" maxlength="150" required @htmlValidationMessage({{__('standard.menu.empty_all_field')}})>
                    </div>
                    <div class="form-group">
                        <label class="d-block">URL *</label>
                        <input type="text" class="form-control" name="url" id="external-url" required pattern="https?://.+" @htmlValidationMessage({{__('standard.menu.invalid_url')}})>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="target" id="external-target"><label for="external-target">Open in New Tab</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary save_changes">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('pagejs')

    <script src="{{ asset('lib/sortablejs/sortable.min.js') }}"></script>
    <script src="{{ asset('lib/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ asset('lib/sortablejs/sortable-nestable-demo.js') }}"></script>

@endsection

@section('customjs')
    <script>
        const scroll1 = new PerfectScrollbar('#scroll3', {
            suppressScrollX: true
        });

        $('#btnSearch').on('click', function() {
            $('.page-title').each(function() {
                let pageTitle = $(this).html().toLowerCase();
                if (pageTitle.indexOf($('#searchPage').val().toLowerCase()) >= 0) {
                    $(this).parent().parent().parent().show();
                } else{
                    $(this).parent().parent().parent().hide();
                }
            });
        });

        $('#searchPage').on('keyup', function() {
            $('.page-title').each(function() {
                let pageTitle = $(this).html().toLowerCase();
                let searchTitle = $('#searchPage').val().toLowerCase().trim();
                if (pageTitle.indexOf(searchTitle) >= 0 || searchTitle == '') {
                    $(this).parent().parent().parent().show();
                } else{
                    $(this).parent().parent().parent().hide();
                }
            });
        });

        function randomId() {
            return Math.floor(Math.random() * 1000000000);
        }

        $('[data-toggle="tooltip"]').tooltip();

        $('#addPageToMenu').on('click', function() {
            $('#nestable01 .dd-empty').remove();
            $.each($('.page'), function() {
                if ($(this).is(':checked')) {
                    let pid = $(this).data('id');
                    let name = $(this).data('name');
                    let label = $(this).data('label');
                    let url = $(this).data('url');
                    let status = $(this).data('status');
                    let status_style = (status == "PRIVATE") ? " style='opacity: 0.4' " : "";
                    let htmlName = (label != '') ? label : name;
                    let elementId = randomId();
                    $("#nestable01 ol.dd-list:first").append(`<li class="dd-item" id="li`+elementId+`" data-page_id="`+pid+`" data-type="page" data-label="`+htmlName+`">
                            <div class="dd-handle bg-light">
                                <span class="drag-indicator"></span>
                                <div>
                                    <strong `+status_style+`>`+name+`</strong><span class="tx-italic tx-12 tx-gray-500 mg-l-5"  id="label`+elementId+`">`+label+`</span>
                                    <p class="mg-b-0 tx-gray-500 tx-11">
                                        `+url+`
                                    </p>
                                </div>
                                <div class="dd-nodrag btn-group ml-auto">
                                    <a href="#prompt-edit-menu" class="tx-bold tx-uppercase tx-10 tx-dark mg-r-10" data-toggle="modal" data-element-id="`+elementId+`">Edit</a>
                                    <a href="#prompt-remove" class="tx-bold tx-uppercase tx-10 tx-danger" data-toggle="modal"  data-element-id="`+elementId+`">Remove</a>
                                </div>
                            </div>
                        </li>`);

                    $(this).prop('checked', false);
                }
            });
        });

        let externalCount = 1;
        $('#externalLinkForm').on('submit', function(evt) {
            $('#nestable01 .dd-empty').remove();

            let url = $('#external_url').val();
            let label = $('#external_label').val();
            let target = $('#external_target').is(':checked') ? '_blank' : '';
            let targetChecked = (target == '_blank') ? 'checked' : '';
            let elementId = randomId();

            $("#nestable01 ol.dd-list:first").append(`<li class="dd-item" id="li`+elementId+`"  data-type="external" data-label="`+label+`"  data-uri="`+url+`" data-target="`+target+`">
                            <div class="dd-handle bg-light">
                                <span class="drag-indicator"></span>
                                <div>
                                    <strong id="label`+elementId+`">`+label+`</strong>
                                    <p class="mg-b-0 tx-gray-500 tx-11" id="url`+elementId+`">
                                        `+url+`
                                    </p>
                                </div>
                                <div class="dd-nodrag btn-group ml-auto">
                                    <a href="#prompt-edit-external-url" class="tx-bold tx-uppercase tx-10 tx-dark mg-r-10" data-toggle="modal" data-element-id="`+elementId+`">Edit</a>
                                    <a href="#prompt-remove" class="tx-bold tx-uppercase tx-10 tx-danger" data-toggle="modal">Remove</a>
                                </div>
                            </div>
                        </li>`);

            $('#external_reset').click();

            externalCount += 1;
            evt.preventDefault();
            return false;
        });

        $('#status').on('click', function() {
            if ($(this).is(':checked')) {
                $('#statusLabel').html('Active');
            } else {
                $('#statusLabel').html('Inactive');
            }
        });

        $('#saveMenu').on('click', function() {
            let is_active = ($('#status').is(':checked')) ? 1 : 0;
            let page_order = $('#nestable01').nestable('serialize');
            if (page_order.length) {
                $('#menuPages').val(window.JSON.stringify(page_order));
                $('#menuPagesJson').val(page_order);
            }
            $('#menuIsActive').val(is_active);
            $('#submitForm').click();
        });

        function getFormData(form) {
            return form.serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
        }

        let elementId;
        $('#prompt-edit-menu').on('show.bs.modal', function (e) {
            elementId = e.relatedTarget.getAttribute('data-element-id');
            $('#page-label').val($('#li'+elementId).data('label'));
        });

        $('#prompt-edit-external-url').on('show.bs.modal', function (e) {
            elementId = e.relatedTarget.getAttribute('data-element-id');
            $('#external-label').val($('#li'+elementId).data('label'));
            $('#external-url').val($('#li'+elementId).data('uri'));
            if ($('#li'+elementId).data('target') == '_blank') {
                $('#external-target').prop('checked', true);
            }
        });

        $(document).on('submit', '.page_form', function(evt) {
            evt.preventDefault();
            let formData = getFormData($(this));
            if (formData.type == "page") {
                $('#li'+elementId).data('label', formData.label);
                $('#label'+elementId).html(formData.label);
            } else if (formData.type == "external") {
                $('#li'+elementId).data('label', formData.label);
                $('#li'+elementId).data('uri', formData.url);
                $('#label'+elementId).html(formData.label);
                $('#url'+elementId).html(formData.url);

                if ($('#external-target').is(':checked')) {
                    $('#li'+elementId).data('target', '_blank');
                } else {
                    $('#li'+elementId).data('target', '');
                }
            }

            $('#prompt-edit-menu').modal('hide');
            $('#prompt-edit-external-url').modal('hide');
            return false;
        });

        $('#prompt-edit-menu').on('hide.bs.modal', function (e) {
            elementId = 0;
            $('#page-label').val('');
        });

        $('#prompt-edit-external-url').on('hide.bs.modal', function (e) {
            elementId = 0;
            $('#external-label').val('');
            $('#external-url').val('');
            $('#external-target').prop('checked', false);
        });

        let deleteId;
        $('#prompt-remove').on('show.bs.modal', function (e) {
            deleteId = e.relatedTarget.getAttribute('data-element-id');
        });

        $('#btnRemove').on('click', function (e) {
            $('#li'+deleteId).remove();
            $('#prompt-remove').modal('hide');
        });
    </script>

@endsection
