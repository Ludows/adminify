@extends('adminify::layouts.front.app')

@section('content')
    @php
        //dd(menu('blade'));
        //dd(get_translation('test.key'));
        $name = Str::slug(request()->route()->getName(), '-');
        $type = strtolower($type);
        $v = view();
    @endphp
    @if($v->exists('adminify::layouts.front.pages.'.$type.'-'.$name))
        @include('adminify::layouts.front.pages.'.$type.'-'.$name)
    @elseif($v->exists('adminify::layouts.front.pages.'.$type.'-default'))
        @include('adminify::layouts.front.pages.'.$type.'-default')
    @else
        @include('adminify::layouts.front.pages.default')
    @endif
    @if($enabled_features['post'] && $type == "post")
        @php
            $allowForm = true;
            $showTitle = true;
            if($user == null) {
                $allowForm = false;
            } 
            if(setting('no_comments') == 1 && $allowForm) {
                $allowForm = false;
                $showTitle = false;
            } 
            if($allowForm && $model->no_comments) {
                $allowForm = false;
                $showTitle = false;
            }
        @endphp
        <comments ref="comments" :show_title="{{ $showTitle ? 'true' : 'false' }}" lang='{{ $lang }}' :post_id="{{ $model->id }}" :allow_form="{{ $allowForm ? 'true' : 'false' }}" :user="{{ $user ?? '{}' }}" :comments='@json($model->commentsThree)'></comments>
    @endif
@endsection

@push('js')

@endpush
