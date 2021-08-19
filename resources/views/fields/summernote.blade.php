<div id="{{ $options['sibling'] }}">

    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        {{-- {{ dd($options['choices']) }} --}}
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
        <div class="summernote_editor">{!! $options['value'] !!}</div>



        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif
</div>

@push('js')
   <script type="text/javascript">
            window.admin.summernoteFields.push({
                selector: '{{ $options['sibling'] }}',
                options: @json($options['summernote_options']),
                multilang: {!! var_export($useMultilang,true) !!},
                currentLang: '{!! $currentLang !!}'
            })
    </script>
@endpush
