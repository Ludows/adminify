@php
    $export_config = json_encode($options['media_element_options']);
@endphp

<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        <div class="row row-selection"></div>
        {!! Form::button($options['media_element_options']['btn']['label'], $options['media_element_options']['btn']['attr'] ) !!}

        {{--  {!! Form::input('hidden', 'mime_type', null, $options['attr']) !!}  --}}
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}
        @push('modales')
            @include('adminify::layouts.admin.medialibrary.modalPicker', [
                'typed_files' => app('Ludows\Adminify\Libs\MediaService')->getListingTypedFiles(),
                'dates' => app('Ludows\Adminify\Libs\MediaService')->getListingDates(),
                'isSelectionMode' => true,
                'multiple' => $options['media_element_options']['multiple']
            ])
        @endpush


        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif


</div>

@if ($options['isAjax'])
    <script>
        window.admin.modalPicker.push({
            fieldName: "{!! $name !!}",
            selector: "{{ $options['sibling'] }}",
            options: {!! $export_config !!},
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        });
    </script>
@else
    @push('js')
    <script>
        window.admin.modalPicker.push({
            fieldName: "{!! $name !!}",
            selector: "{{ $options['sibling'] }}",
            options: {!! $export_config !!},
            multilang: {!! var_export(is_multilang(),true) !!},
            currentLang: '{!! $currentLang !!}'
        });
    </script>
    @endpush
@endif
