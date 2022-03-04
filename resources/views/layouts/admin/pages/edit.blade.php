@extends('adminify::layouts.admin.app', ['class' => $loadEditor ? 'is-editor-mode' : ''])

@if (!empty($adminCssLinks))
    @foreach ($adminCssLinks as $adminCssPath)
        @php
            add_asset('default',  $adminCssPath );
        @endphp
    @endforeach
@endif

@section('content')
    
    @if(view()->exists('adminify::layouts.admin.edit.pages.'.$name))
        @include('adminify::layouts.admin.edit.pages.'.$name)
    @else
        @include('adminify::layouts.admin.edit.pages.default')
    @endif
@endsection

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif

