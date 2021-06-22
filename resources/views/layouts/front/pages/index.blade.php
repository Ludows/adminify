@extends('layouts.front.app')

@section('content')
    @php
        //dd(menu('blade'));
        //dd(get_translation('test.key'));
        $name = Str::slug(request()->route()->getName(), '-');
    @endphp
    @if(view()->exists('layouts.front.pages.'.$name))
        @include('adminify::layouts.front.pages.'.$name)
    @else
        @include('adminify::layouts.front.pages.default')
    @endif
    @if($type == "Post")
        <a href="/test-insert-post-second">test-insert-post-second</a>
        <comments ref="comments" lang='{{ $lang }}' :post_id="{{ $model->id }}" :allow_form="{{ $user != null ? 'true' : 'false' }}" :user="{{ $user ?? '{}' }}" :comments='@json($model->commentsThree)'></comments>
    @endif
@endsection

@push('js')

@endpush
