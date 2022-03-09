@extends('adminify::layouts.front.app')

@section('content')
    @if ($isHome)
        @include('adminify::layouts.front.pages.homepage')
    @endif

    @if ($isBlogPage)
        @include('adminify::layouts.front.pages.blogpage')
    @endif

    @if ($isSingle)
        @includeFirst(['adminify::layouts.front.pages.single-'.$model->id, 'adminify::layouts.front.pages.single'])
    @endif

    @if ($isPage)
        @includeFirst(['adminify::layouts.front.pages.page-'.$model->id, 'adminify::layouts.front.pages.page'])
    @endif

    @if ($isSearch)
        @include('adminify::layouts.front.pages.searchpage')
    @endif

    @if($enabled_features['post'] && $isSingle)
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
        <comments ref="comments" :multilang="{{ var_export(is_multilang(), true) }}" :show_title="{{ $showTitle ? 'true' : 'false' }}" lang='{{ $lang }}' :post_id="{{ $model->id }}" :allow_form="{{ $allowForm ? 'true' : 'false' }}" :user="{{ $user ?? '{}' }}" :comments='@json($model->commentsThree)'></comments>
    @endif
@endsection

@push('js')

@endpush
