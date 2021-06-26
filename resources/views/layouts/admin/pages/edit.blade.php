@extends('adminify::layouts.admin.app')

@section('content')
@php
    $name = request()->route()->getName();
    $name = str_replace('.edit', '', $name);
@endphp
@if(view()->exists('adminify::layouts.admin.edit.pages.'.$name))
    @include('adminify::layouts.admin.edit.pages.'.$name)
@else
    @include('adminify::layouts.admin.edit.pages.default')
@endif
@endsection

@push('js')

@endpush

