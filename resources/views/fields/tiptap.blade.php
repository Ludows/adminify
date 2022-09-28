<div id="{{ $options['sibling'] }}" {!! $options['sibling_attr'] !!}>

    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
        <div class="tiptap_editor" data-content="{!! $options['value'] !!}"></div>
        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif
</div>

@push('js')

@endpush

@if ($options['isAjax'])
    <script>
        @if (!$options['is_child_proto'])
            document.addEventListener("DOMContentLoaded", function(event) { 
        @endif
        tiptapInitFunction([{
            selector: '{{ $options['sibling'] }}',
            options: @json($options['tiptap_options']),
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        }])
        @if (!$options['is_child_proto'])
            });
        @endif
    </script>
@else
    @push('js')
            <script type="text/javascript">
                    window.admin.tiptapFields.push({
                        selector: '{{ $options['sibling'] }}',
                        options: @json($options['tiptap_options']),
                        multilang: {!! var_export(is_multilang(),true) !!},
                        currentLang: '{!! $currentLang !!}'
                    })
            </script>
    @endpush
@endif
