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

    <div class="container-fluid mt--7">

        {!! $interfacable->render() !!}

        @include('adminify::layouts.admin.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush

@if (!empty($adminJsLinks))
    @push('js')
        @foreach ($adminJsLinks as $adminJsPath)
            <script type="text/javascript" src="{{ $adminJsPath }}"></script>
        @endforeach
    @endpush
@endif
