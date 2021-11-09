@extends('adminify::layouts.admin.app')

@if (!empty($adminCssLinks))
    @push('css')
        @foreach ($adminCssLinks as $adminCssPath)
            <link rel="stylesheet" href="{{ $adminCssPath }}">
        @endforeach
    @endpush
@endif

@section('content')
    
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
    
@endsection

@if (!empty($adminJsLinks))
    @push('js')
        @foreach ($adminJsLinks as $adminJsPath)
            <script type="text/javascript" src="{{ $adminJsPath }}"></script>
        @endforeach
    @endpush
@endif






