@extends('adminify::layouts.admin.app')

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


