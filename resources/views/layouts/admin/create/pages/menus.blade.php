
@include('adminify::layouts.admin.headers.topPageListing')
<div class="container-fluid mt--7">
    @hook('before_menu_builder')
    <div class="row">
        <div class="col-12">
            {!! menu_builder($menuBuilder) !!}
        </div>
    </div>
    @hook('after_menu_builder')
</div>


@push('js')
    {{-- {{ dd(app()) }} --}}
    {{-- {!! MenuBuilder::scripts() !!} --}}
@endpush
