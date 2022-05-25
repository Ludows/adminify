Je suis un ovveride de template :)

@include('adminify::layouts.admin.headers.topPageListing', [
    'breadcrumb' => false
])

<div class="js-mediatheque">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="d-flex bg-white rounded-lg shadow align-items-center px-3 py-2 mb-3 flex-wrap">
                    <div class="mr-4">Titre</div>
                    <div>
                        <button class="btn btn-outline-primary js-open-dropzone">{!! __('admin.media.openDrop') !!}</button>
                    </div>

                    <div class="w-100 d-none mt-3">
                        <form action="{!! route('mediasv2.upload') !!}"
                            class="dropzone"
                            id="dropzoneUploadFiles"></form>
                    </div>
                </div>

                <div class="row bg-white rounded-lg justify-content-lg-between shadow align-items-center no-gutters px-3 py-2">
                    <div class="col-12 d-flex col-lg-7">
                        <div class="mr-3">
                            {{--  // select type documents  --}}
                            <select class="form-control">
                                @foreach ($typed_files as $typed_key_file => $typed_file_name)
                                    <option value="{!!  $typed_key_file !!}">{!! $typed_file_name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mr-3">
                            {{--  // select date documents  --}}
                            <select class="form-control">
                                @foreach ($dates as $date_key => $date_name)
                                    <option value="{!!  $date_key !!}">{!! $date_name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mr-3">
                            <button class="btn disabled d-none js-remove-image btn-danger">{!! __('admin.media.remove') !!}</button>
                            <button class="btn btn-outline-primary">{!! __('admin.media.selectInGroup') !!}</button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="">
                            <input type="text" class="form-control" placeholder="{!! __('admin.media.search') !!}" />
                        </div>
                    </div>
                </div>

                <div id="GallerySet" class="row no-gutters"></div>

            </div>

        </div>

        @include('adminify::layouts.admin.medialibrary.modalDetails')

        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

{{-- @push('js')
    <script src="{{ asset('adminify/back') }}/js/listings.js"></script>
@endpush --}}

@php
    add_asset('default',  asset('adminify/back') . '/js/mediatheque.js');
@endphp
