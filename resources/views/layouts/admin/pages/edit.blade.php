@extends('layouts.admin.app')

@section('content')
@php
    $name = request()->route()->getName();
    $name = str_replace('.edit', '', $name);
@endphp
@if(view()->exists('layouts.admin.edit.pages.'.$name))
    @include('layouts.admin.edit.pages.'.$name)
@else
    @include('layouts.admin.edit.pages.default')
@endif
@endsection

@push('js')

@endpush

