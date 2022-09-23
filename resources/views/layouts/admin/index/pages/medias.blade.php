@php
    $withPageElements = isset($pageElements) ? $pageElements : true;
    $callableModal = isset($modelPath) ? $modelPath : 'adminify::layouts.admin.medialibrary.modalDetails';
    $withModal = isset($withModal) ? $withModal : true;
    $selectionMode = isset($isSelectionMode) ? $isSelectionMode : false;
    $multipleMode = isset($multiple) && $selectionMode ? $multiple : false;
@endphp

@if($withPageElements)
    @include('adminify::layouts.admin.headers.topPageListing', [
        'breadcrumb' => false
    ])
@endif


<div class="js-mediatheque {!! $selectionMode ? 'is-selection' : '' !!} {!! $multipleMode ? 'is-multiple' : 'is-single' !!}">
    <div class="container-fluid {!! $withPageElements ? 'mt--7' : '' !!}">
        <div class="row ">
            @hook('before_content_page')
            <div class="col-12">
                <div class="d-flex bg-white rounded-lg shadow align-items-center px-3 py-2 mb-3 flex-wrap">
                    <div class="mr-4">Titre</div>
                    <div>
                        <button class="btn btn-outline-primary js-open-dropzone">{!! __('admin.media.openDrop') !!}</button>
                    </div>

                    <div class="w-100 d-none mt-3">
                        <form action="{!! route('medias.upload') !!}"
                            class="dropzone"
                            id="dropzoneUploadFiles"></form>
                    </div>
                </div>

                <div class="row bg-white rounded-lg justify-content-lg-between shadow align-items-center no-gutters px-3 py-2">
                    <div id="parentGroupFilters" class="col-12 d-flex col-lg-7">
                        @hook('start_media_filters')
                        <div class="mr-3 filter-zone">
                            {{--  // select type documents  --}}
                            <select class="form-control js-documents">
                                @foreach ($typed_files as $typed_key_file => $typed_file_name)
                                    <option value="{!!  $typed_key_file !!}">{!! $typed_file_name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mr-3 filter-zone">
                            {{--  // select date documents  --}}
                            <select class="form-control js-date">
                                @foreach ($dates as $date_key => $date_name)
                                    <option value="{!!  $date_key !!}">{!! $date_name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mr-3">
                            <button data-ids="" class="btn disabled d-none js-remove-image-group btn-danger">{!! __('admin.media.remove') !!}</button>
                            <button class="btn {!! $selectionMode ? 'd-none' : '' !!} btn-outline-primary js-toggle-selectgroup">{!! __('admin.media.selectInGroup') !!}</button>
                        </div>
                        @hook('end_media_filters')
                    </div>
                    <div class="col-12 col-lg-5">
                        @hook('start_media_search')
                        <div class="">
                            <input type="text" class="form-control js-search-media" placeholder="{!! __('admin.media.search') !!}" />
                        </div>
                        @hook('end_media_search')
                    </div>
                </div>

                @hook('before_media_galery')
                <div id="GallerySet"></div>
                @hook('after_media_galery')

            </div>
            @hook('after_content_page')
        </div>

        @if($withModal)
            @include($callableModal)
        @endif

        @if($selectionMode)
            <input type="hidden" id="media_selecteds_id" value=""/>
            <input type="hidden" id="config_picker_handle" value=""/>
        @endif

        @if($withPageElements)
            @include('adminify::layouts.admin.footers.auth')
        @endif

    </div>
</div>

{{-- @push('js')
    <script src="{{ asset('adminify/back') }}/js/listings.js"></script>
@endpush --}}

@php
    add_asset('default',  asset('adminify/back') . '/js/mediatheque.js');
@endphp
