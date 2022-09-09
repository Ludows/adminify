@include('adminify::layouts.admin.headers.topPageListing')

<div class="js-listings" data-page="1">
    <div class="container-fluid mt--7">
        <div class="row">
            @hook('before_content_page')
            <div class="col-12">
                @hook('before_table')
                @if(isset($table))
                    {!! $table->render() !!}
                @endif
                @hook('after_table')
            </div>
            @hook('after_content_page')
        </div>
    
        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

{{-- @push('js')
    <script src="{{ asset('adminify/back') }}/js/listings.js"></script>
@endpush --}}

@php
    add_asset('default',  asset('adminify/back') . '/js/listings.js');
@endphp
