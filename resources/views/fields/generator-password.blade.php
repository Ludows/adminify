<div id="{{ $options['sibling'] }}" {!! $options['sibling_attr'] !!}>
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        <div class="input-group mb-3">
            {!! Form::input('text', $name, $options['value'], $options['attr']) !!}        <div class="input-group-append">
            <div class="input-group-append">
                {!! Form::button($options['generate_password_options']['btn']['label'], $options['generate_password_options']['btn']['attr'] ) !!}
            </div>
        </div>
      </div>


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
        PasswordGeneratorInitFunction([{
            selector: "{{ $options['sibling'] }}",
            options: [],
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
            window.admin.generatorPasswordFields.push({
                selector: "{{ $options['sibling'] }}",
                options: [],
                multilang: {!! var_export(is_multilang(),true) !!},
                currentLang: '{!! $currentLang !!}'
            })
        </script>
    @endpush
@endif

