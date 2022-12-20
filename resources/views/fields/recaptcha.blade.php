<div id="{{ $options['sibling'] }}" {!! $options['sibling_attr'] !!}>
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

        @if($showLabel && $options['label'] !== false && $options['label_show'])
            {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
        @endif

        @if($showField)
            <div class="row row-selection"></div>
            <div class="recaptcha" id="{{ $options['recaptcha_id'] }}"></div>
            {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}

            @include('vendor/laravel-form-builder/errors')
            @include('vendor/laravel-form-builder/help_block')
        @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif

    @push('js')
        <script>
        function verifyCallback(response) {
            $('#{{ $options['recaptcha_id'] }}').next().val(response);
        }
        function onloadCallback() {
            grecaptcha.render('{{ $options['recaptcha_id'] }}', @json($options['recaptcha_options']));
        }
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
        </script>
    @endpush
</div>
