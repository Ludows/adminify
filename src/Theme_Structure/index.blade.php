@extends('theme::'. $theme .'.layouts.app')

@section('content')
    @hook('before_content')

    @if($isPreview)
        <div id="ve-components">
    @endif

    @if(!$isTemplate && !empty($exclude_titlebar) && !in_array($model->slug, explode(',', $exclude_titlebar)))
        {{--  @include('theme::'. $theme .'.layouts.partials.titlebar', [
            'title' => translate($model->slug.'.intro'),
            'showBreadcrumb' => true,
            'breadcrumb' => breadcrumb()::render($type, $model)
        ])  --}}
        @includeFirst(['theme::'. $theme .'.layouts.partials.titlebar'.$model->id, 'theme::'. $theme .'.layouts.partials.titlebar'.$type, 'theme::'. $theme .'.layouts.partials.titlebar'.$model->slug, 'theme::'. $theme .'.layouts.partials.titlebar'], [
            'title' => translate($model->slug.'.intro'),
            'showBreadcrumb' => empty($exclude_breadcrumb) ? true : !in_array($model->slug, explode(',', $exclude_breadcrumb)),
            'breadcrumb' => breadcrumb()::render($type, $model),
            'model' => $model,
        ])
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
        @includeFirst(['theme::'. $theme .'.single-'.$model->id, 'theme::'. $theme .'.single-'.$type , 'theme::'. $theme .'.single-'.$model->slug, 'theme::'. $theme .'.single'])
    @endif

    @if ($isPage && !$isTemplate && !$isHome)
        @includeFirst(['theme::'. $theme .'.page-'.$model->id, 'theme::'. $theme .'.page-'.$type, 'theme::'. $theme .'.page-'.$model->slug, 'theme::'. $theme .'.page'])
    @endif

    @if ($isContentModel && !$isTemplate && !$isHome)
        @includeFirst(['theme::'. $theme .'.content-'.$model->id, 'theme::'. $theme .'.content-'.$type, 'theme::'. $theme .'.content-'.$model->slug, 'theme::'. $theme .'.content'])
    @endif

    @if ($isSearch && !$isTemplate && !$isHome)
        @includeFirst(['theme::'. $theme .'.searchpage-'.$model->id, 'theme::'. $theme .'.searchpage-'.$type, 'theme::'. $theme .'.searchpage-'.$model->slug, 'theme::'. $theme .'.searchpage'])
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

    @hook('after_content')
@endsection

@push('js')

@endpush
