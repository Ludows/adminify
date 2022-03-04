@extends('adminify::layouts.admin.app', ['class' => $loadEditor ? 'is-editor-mode' : ''])

@if (!empty($adminCssLinks))
    @foreach ($adminCssLinks as $adminCssPath)
        @php
            add_asset('default',  $adminCssPath );
        @endphp
    @endforeach
@endif

@section('content')
    {{-- // check auto enable editor. --}}
    {{-- // all values in mutilang middleware are appended in views and request for more flexibility. --}}
    @if(view()->exists('adminify::layouts.admin.create.pages.'.$name))
        @include('adminify::layouts.admin.create.pages.'.$name)
    @else
        @include('adminify::layouts.admin.create.pages.default')
    @endif
@endsection

@if (!empty($adminJsLinks))
        
    @foreach ($adminJsLinks as $adminJsPath)
        @php
            add_asset('default',  $adminJsPath );
        @endphp
    @endforeach
    
@endif


