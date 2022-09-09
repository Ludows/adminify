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
    @php
        $name = request()->route()->getName();
        $name = str_replace('.show', '', $name);
    @endphp
    @if(view()->exists('adminify::layouts.admin.show.pages.'.$name))
        @include('adminify::layouts.admin.show.pages.'.$name)
    @else
        @include('adminify::layouts.admin.show.pages.default')
    @endif
    @hook('after_content')
@endsection

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif
