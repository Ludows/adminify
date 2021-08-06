@extends('adminify::layouts.admin.app')

@section('content')
    @if(isset($form))
        {!! form($form) !!}
    @endif
@endsection

@push('js')
   
@endpush
