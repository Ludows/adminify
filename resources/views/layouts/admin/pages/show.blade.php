@extends('adminify::layouts.admin.app')

@section('content')
    @php
        $name = request()->route()->getName();
        $name = str_replace('.show', '', $name);
    @endphp
    @if(view()->exists('adminify::layouts.admin.show.pages.'.$name))
        @include('adminify::layouts.admin.show.pages.'.$name)
    @else
        @include('adminify::layouts.admin.show.pages.default')
    @endif
@endsection

@push('js')

@endpush
