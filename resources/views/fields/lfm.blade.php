<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        @if(!$options['lfm_options']['disable_selection_preview'])
            <div class="row row-selection"></div>
        @endif
        {!! Form::button($options['lfm_options']['btn']['label'], $options['lfm_options']['btn']['attr'] ) !!}

        {{--  {!! Form::input('hidden', 'mime_type', null, $options['attr']) !!}  --}}
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif


</div>

@if ($options['isAjax'])
    <script type="text/javascript">
        lfmInitFunction([{
            selector: "{{ $options['sibling'] }}",
            options: @json($options['lfm_options']),
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        }])
    </script>
@else
    @push('js')
        <script type="text/javascript">
            window.admin.lfmFields.push({
                selector: "{{ $options['sibling'] }}",
                options: @json($options['lfm_options']),
                multilang: {!! var_export(is_multilang(),true) !!},
                currentLang: '{!! $currentLang !!}'
            })
        </script>
    @endpush
@endif
