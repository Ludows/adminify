@extends('adminify::layouts.admin.app')

@section('content')
    
    @include('adminify::layouts.admin.headers.topPageListing')

    <div>
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-12">
    
                    @if(isset($form))
                        {!! form($form) !!}
                    @endif
                    
                </div>
        
            </div>
        
            @include('adminify::layouts.admin.footers.auth')
        </div>
    </div>
    
@endsection

@push('js')
   
@endpush






