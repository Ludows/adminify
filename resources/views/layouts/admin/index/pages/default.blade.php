@include('adminify::layouts.admin.headers.topPageListing')

<div class="js-listings" data-page="1">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-12">

                @if(isset($table))
                        {!! $table->render() !!}
                @endif
                
            </div>
    
        </div>
    
        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

@push('js')
    <script src="{{ asset('argon') }}/js/listings.js"></script>
@endpush

