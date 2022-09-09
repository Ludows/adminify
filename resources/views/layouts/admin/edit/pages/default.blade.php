@include('adminify::layouts.admin.headers.topPageListing')

<div class="container-fluid mt--7">
    <div class="row">
        @hook('before_content_page')
        <div class="col-12">
            @php
                $name = request()->route()->getName();
                $name = str_replace('.edit', '', $name);
            @endphp

            <div class="card shadow">
                <div class="card-header border-0">
                    {{ __('admin.edit.'.$name) }}
                </div>
                <div class="card-body">
                    @hook('before_form_page')
                    @if(isset($form))
                        {!! form($form) !!}
                    @endif
                    @hook('after_form_page')
                </div>
            </div>
        </div>
        @hook('after_content_page')
    </div>

    @include('adminify::layouts.admin.footers.auth')
</div>
