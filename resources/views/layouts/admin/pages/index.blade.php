@extends('adminify::layouts.admin.app')

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

@push('js')

@endpush
