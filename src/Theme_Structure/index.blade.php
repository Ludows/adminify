@extends('theme::'. $theme .'.layouts.app')

@section('content')
    @if ($isHome)
        @include('theme::'. $theme .'.homepage')
    @endif

    @if ($isBlogPage)
        @include('theme::'. $theme .'.blogpage')
    @endif

    @if ($isSingle)
        @includeFirst(['theme::'. $theme .'.single-'.$model->id, 'theme::'. $theme .'.single'])
    @endif

    @if ($isPage)
        @includeFirst(['theme::'. $theme .'.page-'.$model->id, 'theme::'. $theme .'.page'])
    @endif

    @if ($isSearch)
        @include('theme::'. $theme .'.searchpage')
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
