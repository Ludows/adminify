@extends('adminify::layouts.admin.app', ['class' => $loadEditor ? 'is-editor-mode' : ''])

@if (!empty($adminCssLinks))
    @push('css')
        @foreach ($adminCssLinks as $adminCssPath)
            <link rel="stylesheet" href="{{ $adminCssPath }}">
        @endforeach
    @endpush
@endif

@section('content')
    {{-- // check auto enable editor. --}}
    {{-- // all values in mutilang middleware are appended in views and request for more flexibility. --}}

    @if($loadEditor)

        {{-- get the editor interface. --}}
        {!! interfaces('editor')->render() !!}

    @else
        @if(view()->exists('adminify::layouts.admin.create.pages.'.$name))
            @include('adminify::layouts.admin.create.pages.'.$name)
        @else
            @include('adminify::layouts.admin.create.pages.default')
        @endif
    @endif
@endsection

@if (!empty($adminJsLinks))
    @push('js')
        @foreach ($adminJsLinks as $adminJsPath)
            <script type="text/javascript" src="{{ $adminJsPath }}"></script>
        @endforeach
    @endpush
@endif


