@extends('theme::'. $theme .'.layouts.app')

@section('content')
    @if($isPreview)
        <div id="ve-components">
    @endif

    @if ($isTemplate)
        @include('theme::'. $theme .'.blank_template')
    @endif

    @if ($isHome && !$isTemplate)
        @include('theme::'. $theme .'.homepage')
    @endif

    @if ($isBlogPage && !$isTemplate)
        @include('theme::'. $theme .'.blogpage')
    @endif

    @if ($isSingle && !$isTemplate)
        @includeFirst(['theme::'. $theme .'.single-'.$model->id, 'theme::'. $theme .'.single'])
    @endif

    @if ($isPage && !$isTemplate)
        @includeFirst(['theme::'. $theme .'.page-'.$model->id, 'theme::'. $theme .'.page-'.$type, 'theme::'. $theme .'.page'])
    @endif

    @if ($isSearch && !$isTemplate)
        @includeFirst(['theme::'. $theme .'.searchpage-'.$model->id, 'theme::'. $theme .'.searchpage-'.$type, 'theme::'. $theme .'.searchpage'])
    @endif

    @if($isPreview)
        </div>
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
        <comments ref="comments" model_class="{{ get_class($model) }}" :multilang="{{ var_export(is_multilang(), true) }}" :show_title="{{ $showTitle ? 'true' : 'false' }}" lang='{{ $lang }}' :post_id="{{ $model->id }}" :allow_form="{{ $allowForm ? 'true' : 'false' }}" :user="{{ $user ?? '{}' }}" :comments='@json($model->commentsThree)'></comments>
    @endif
@endsection

@push('js')

@endpush
