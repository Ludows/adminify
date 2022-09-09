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

    <div class="container-fluid mt--7">

        {!! $interfacable->render() !!}

        @include('adminify::layouts.admin.footers.auth')
    </div>
    @hook('after_content')
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif
