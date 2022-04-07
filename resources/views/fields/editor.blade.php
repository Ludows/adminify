<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        {{--  {!! Form::input('hidden', 'mime_type', null, $options['attr']) !!}  --}}
        {{--  {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}  --}}

        <button class="btn btn-primary js-toggle-visual">Toggle Visual Editor</button>

        <visual-editor hidden name="{!! $name !!}" preview="{!! $options['visual_editor_options']['preview'] !!}" value="{!! !empty($options['value']) ? $options['value'] : [] !!}"></visual-editor>

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif


</div>

@if ($options['isAjax'])
    <script type="text/javascript">
        VisualEditorInitFunction([{
            selector: "{{ $options['sibling'] }}",
            options: @json($options['visual_editor_options']),
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        }])
    </script>
@else
    @push('js')
        <script type="text/javascript">
            window.admin.VisualEditorFields.push({
                selector: "{{ $options['sibling'] }}",
                options: @json($options['visual_editor_options']),
                multilang: {!! var_export(is_multilang(),true) !!},
                currentLang: '{!! $currentLang !!}'
            })
        </script>
    @endpush
@endif
