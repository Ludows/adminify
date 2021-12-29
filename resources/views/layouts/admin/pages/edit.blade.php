@extends('adminify::layouts.admin.app')

@if (!empty($adminCssLinks))
    @push('css')
        @foreach ($adminCssLinks as $adminCssPath)
            <link rel="stylesheet" href="{{ $adminCssPath }}">
        @endforeach
    @endpush
@endif

@section('content')
    @if($loadEditor)
        {{-- get the editor interface. --}}
        {!! interfaces('editor')->render() !!}
    @else
        @if(view()->exists('adminify::layouts.admin.edit.pages.'.$name))
            @include('adminify::layouts.admin.edit.pages.'.$name)
        @else
            @include('adminify::layouts.admin.edit.pages.default')
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

