@if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
@endif

<div id="{{ $options['sibling'] }}">
    <div class="editor"></div>
    {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}
    @include('vendor/laravel-form-builder/errors')
    @include('vendor/laravel-form-builder/help_block')
</div>

@if($options['wrapper'] !== false)
        </div>
@endif

@push('js')
   <script type="text/javascript">
        window.admin.quillEditorFields.push({
            selector : '#{{ $options['sibling'] }}',
            options : @json($options['quill_options']),
            multilang: {!! $useMultilang !!},
            currentLang: '{!! $currentLang !!}'
        })
    </script>
@endpush
