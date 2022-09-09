
@include('adminify::layouts.admin.headers.topPageListing')
<div class="container-fluid mt--7">
    <div class="row">
        @hook('before_menu_builder')
        <div class="col-12">
            {!! menu_builder($menuBuilder) !!}
        </div>
        @hook('after_menu_builder')
    </div>
</div>


@push('js')
    {{-- {{ dd(app()) }} --}}
    {{-- {!! MenuBuilder::scripts() !!} --}}
@endpush
