@extends('adminify::layouts.admin.app')

@if (!empty($adminCssLinks))
    @foreach ($adminCssLinks as $adminCssPath)
        @php
            add_asset('default',  $adminCssPath );
        @endphp
    @endforeach
@endif

@section('content')
    @php
        $name = request()->route()->getName();
        $name = str_replace('.index', '', $name);
    @endphp
    @if(view()->exists('adminify::layouts.admin.index.pages.'.$name))
        @include('adminify::layouts.admin.index.pages.'.$name)
    @else
        @include('adminify::layouts.admin.index.pages.default')
    @endif
    
@endsection

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif
