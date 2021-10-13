@include('adminify::layouts.admin.headers.topPageListing')

<div class="container mt--7">
    <div class="row">
        <div class="col-lg-8 col-12">
            {!! $blocks['form-block']->render() !!}
        </div>
        <div class="col-lg-4 col-12">
            {!! $blocks['fields-block']->render() !!}
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('adminify') }}/back/js/formbuilder.js"></script>  
@endpush