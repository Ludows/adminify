@extends('adminify::layouts.admin.app')

@if (!empty($adminCssLinks))
    @push('css')
        @foreach ($adminCssLinks as $adminCssPath)
            <link rel="stylesheet" href="{{ $adminCssPath }}">
        @endforeach
    @endpush
@endif

@section('content')
    @php
        $name = request()->route()->getName();
        $name = str_replace('.create', '', $name);
    @endphp
    @if(view()->exists('adminify::layouts.admin.create.pages.'.$name))
        @include('adminify::layouts.admin.create.pages.'.$name)
    @else
        @include('adminify::layouts.admin.create.pages.default')
    @endif
@endsection

@if (!empty($adminJsLinks))
    @push('js')
        @foreach ($adminJsLinks as $adminJsPath)
            <script type="text/javascript" src="{{ $adminJsPath }}"></script>
        @endforeach
    @endpush
@endif


