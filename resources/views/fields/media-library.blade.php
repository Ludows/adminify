<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        <div class="selection_wrapper row"></div>
        {!! Form::button($options['media_library_options']['btn']['label'], $options['media_library_options']['btn']['attr'] ) !!}
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif


</div>

@if($options['modal'])
    @push('modales')
        @include($options['modal'])
    @endpush
@endif

@push('js')

   <script type="text/javascript">
            window.admin.mediaLibraryFields.push({
                selector: '#{{ $options['sibling'] }}',
                allow_multiple_selection : {!! $options['media_library_options']['multiple'] !!},
                multilang: {{ $useMultilang }},
                currentLang: '{!! $currentLang !!}'
            })
    </script>
@endpush


