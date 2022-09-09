@extends('adminify::layouts.admin.app', [])

@if (!empty($adminCssLinks))
    @foreach ($adminCssLinks as $adminCssPath)
        @php
            add_asset('default',  $adminCssPath );
        @endphp
    @endforeach
@endif

@section('content')
    @hook('before_content')
    @if(view()->exists('adminify::layouts.admin.edit.pages.'.$name))
        @include('adminify::layouts.admin.edit.pages.'.$name)
    @else
        @include('adminify::layouts.admin.edit.pages.default')
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

