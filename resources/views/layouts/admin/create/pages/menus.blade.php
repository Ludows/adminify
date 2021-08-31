
@include('adminify::layouts.admin.headers.topPageListing')
<div class="container-fluid mt--7">
    @yield('before_content')
    <div class="row">
        <div class="col-12">
            {!! menu_builder($menuBuilder) !!}
        </div>
    </div>
    @yield('after_content')
</div>


@push('js')
    {{-- {{ dd(app()) }} --}}
    {{-- {!! MenuBuilder::scripts() !!} --}}
@endpush
