@php
    $withRemove = isset($remove) ? $remove : false;
    $withConfigSelector = isset($config_selector) ? $config_selector : '';
    $mime = $model->mime_type;
@endphp
<a href="#" {!! $withConfigSelector ? 'data-selector="'. $config_selector .'"' : ''  !!}  data-media='@json($model)' data-id="{!! $model->id !!}" data-original="{!! $model->getFullPath() !!}" class="col-12 mb-3 mb-lg-0 col-lg-3 position-relative js-modal-details {!! !startsWith($mime, 'image/') ? 'is-custom-media' : '' !!} {!! $withConfigSelector ? 'has-config' : ''  !!}">

    @if(startsWith($mime, 'audio/'))
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! asset('adminify/img/casque-de-musique.png') !!}">
    @elseif(startsWith($mime, 'video/'))
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! asset('adminify/img/jouer.png') !!}">
    @elseif(startsWith($mime, 'image/'))
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! image($model->getRelativePath(), $thumbs) !!}">
    @else
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! asset('adminify/img/papier.png') !!}">
    @endif

    <div class="">
        {!! $model->src !!}
    </div>

    @if($withRemove)
        <span class="js-remove-selection clear" data-id="{!! $model->id !!}">x</span>
    @endif
</a>
