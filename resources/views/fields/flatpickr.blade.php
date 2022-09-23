
<div id="{{ $options['sibling'] }}">

    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif


    @if($showField)

        {!! Form::text($name, $options['value'], $options['attr']) !!}

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
        FlatpickrInitFunction([{
            fieldName: "[name='{!! $name !!}']",
            selector: '#{{ $options['sibling'] }}',
            options: @json($options['flatpickr_options']),
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
                window.admin.flatpickrFields.push({
                    fieldName: "[name='{!! $name !!}']",
                    selector: '#{{ $options['sibling'] }}',
                    options: @json($options['flatpickr_options']),
                    multilang: {!! var_export(is_multilang(),true) !!},
                    currentLang: '{!! $currentLang !!}'
                })
        </script>
    @endpush
@endif
