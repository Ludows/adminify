@extends('layouts.admin.app')

@section('content')
    @php
        $name = request()->route()->getName();
        $name = str_replace('.create', '', $name);
    @endphp
    @if(view()->exists('layouts.admin.create.pages.'.$name))
        @include('layouts.admin.create.pages.'.$name)
    @else
        @include('layouts.admin.create.pages.default')
    @endif
@endsection


