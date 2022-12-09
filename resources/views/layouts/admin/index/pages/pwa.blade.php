@include('adminify::layouts.admin.headers.topPageListing')

<div class="container-fluid mt--7">
    <div class="row">
        @hook('before_content_page')
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @hook('before_form_page')
                    {!! form($form) !!}
                    @hook('after_form_page')
                </div>
            </div>
        </div>
        @hook('after_content_page')
    </div>

    @include('adminify::layouts.admin.footers.auth')
</div>
