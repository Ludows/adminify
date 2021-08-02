<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    <a href="#" class="btn btn-primary">
        {{ __('admin.selectTemplate') }}
    </a>

    <a href="#" class="btn btn-primary js-save-template">
        {{ __('admin.saveAs') }}
    </a>

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

@push('js')
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    <script>
        window.admin.larabergFields.push({
            selector: "{{ $options['sibling'] }}",
            options: [],
            multilang: {!! $useMultilang !!},
            currentLang: '{!! $currentLang !!}'
        })
    </script>
@endpush
