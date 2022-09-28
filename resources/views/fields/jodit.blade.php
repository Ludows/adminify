<div id="{{ $options['sibling'] }}" {!! $options['sibling_attr'] !!}>

    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        {{-- {{ dd($options['choices']) }} --}}
        {!! Form::textarea($name, $options['value'], $options['attr']) !!}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif
</div>


@if ($options['isAjax'])
    <script type="text/javascript">
        @if(!$options['is_child_proto'])
                    document.addEventListener("DOMContentLoaded", function(event) {
        @endif
            JoditInitFunction([{
                fieldName: "[name='{!! $name !!}']",
                selector: '#{{ $options['sibling'] }}',
                options: @json($options['jodit_options']),
                multilang: {!! var_export(is_multilang(),true) !!},
                currentLang: '{!! $currentLang !!}'
            }])
        @if(!$options['is_child_proto'])
            });
        @endif
    </script>
@else
    @push('js')
        <script type="text/javascript">
                window.admin.joditFields.push({
                    fieldName: "[name='{!! $name !!}']",
                    selector: '#{{ $options['sibling'] }}',
                    options: @json($options['jodit_options']),
                    multilang: {!! var_export(is_multilang(),true) !!},
                    currentLang: '{!! $currentLang !!}'
                })
        </script>
    @endpush
@endif
