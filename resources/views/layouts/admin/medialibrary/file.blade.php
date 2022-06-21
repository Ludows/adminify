@php
    $withRemove = isset($remove) ? $remove : false;
    $withConfigSelector = isset($config_selector) ? $config_selector : ''
@endphp
<a href="#" {!! $withConfigSelector ? 'data-selector="'. $config_selector .'"' : ''  !!}  data-media='@json($model)' data-id="{!! $model->id !!}" data-original="{!! $model->getFullPath() !!}" class="col  js-modal-details {!! $withConfigSelector ? 'has-config' : ''  !!}">
    <img alt="" class="img-fluid shadow rounded-lg" src="{!! image($model->getRelativePath(), $thumbs) !!}">
    @if($withRemove)
        <span class="js-remove-selection clear" data-id="{!! $model->id !!}">x</span>
    @endif
</a>
