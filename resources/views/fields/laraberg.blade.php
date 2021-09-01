<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if ($options['withBtnForTemplates'])
        <div class="d-flex mb-3">
            <a href="#" data-type="select-tpl" class="btn btn-primary js-call-modal-laraberg mr-3">
                {{ __('admin.form.select_template') }}
            </a>
    
            <a href="#" data-type="save-tpl" class="btn btn-primary js-call-modal-laraberg">
                {{ __('admin.form.save_as') }}
            </a>
        </div>
       
    @endif
    

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        {!! Form::textarea($name, $options['value'], $options['attr']) !!}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif


</div>

@push('css')
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
@endpush

@if($options['withBtnForTemplates'])
    @push('modales')
        @include('adminify::layouts.admin.modales.modal-ajax', [
            "id" => 'modal-'.$options['sibling']
        ])
    @endpush
@endif

@push('js')
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script>
        var modalAjaxLaraberg = '#modal-{{ $options['sibling'] }}';
    </script>
    <script>
        window.admin.larabergFields.push({
            selector: "{{ $options['sibling'] }}",
            options: @json($options['laraberg_defaults']),
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        })
    </script>
@endpush
