@extends('adminify::layouts.admin.app')

@if (!empty($adminCssLinks))
    @foreach ($adminCssLinks as $adminCssPath)
        @php
            add_asset('default',  $adminCssPath );
        @endphp
    @endforeach
@endif

@section('content')
    @hook('before_content')
    @include('adminify::layouts.admin.headers.topPageListing')

    <div>
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            @if(isset($form))
                                {!! form($form) !!}
                            @endif
                        </div>
                    </div>
    
                    
                    
                </div>
        
            </div>
        
            @include('adminify::layouts.admin.footers.auth')
        </div>
    </div>
    @hook('after_content')
@endsection

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif






