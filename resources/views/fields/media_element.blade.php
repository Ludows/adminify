@php
    $export_config = json_encode($options['media_element_options']);
@endphp

<div id="{{ $options['sibling'] }}" {!! $options['sibling_attr'] !!}>
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        <style>
            .js-modal-details {
                position:relative;
            }
            .js-modal-details .clear {
                position: absolute;
                left:25px;
                top:5%;
                color: black;
                opacity: .8;
                transition: .2s all ease;
                background-color: white;
                width: 25px;
                height: 25px;
                border-radius: 100%;
                display:flex;
                align-items: center;
                justify-content: center;
            }
            .js-modal-details img {
                opacity: .8;
            }
            .js-modal-details:hover img {
                opacity: 1;
            }
            .js-modal-details:hover .clear {
                opacity: 1;
            }
        </style>
        <div class="row row-selection">
            @if($options['hasBootedMedia'] && $options['medias']->count() > 0 )

                @foreach ($options['medias'] as $model)
                    @include('adminify::layouts.admin.medialibrary.file', [
                        'model' => $model,
                        'thumbs' => app('Ludows\Adminify\Libs\MediaService')->getConfig()['thumbs'],
                        'remove' => true,
                        'config_selector' => $options['sibling']
                    ])
                @endforeach
            @endif
        </div>
        {!! Form::button($options['media_element_options']['btn']['label'], $options['media_element_options']['btn']['attr'] ) !!}

        {{--  {!! Form::input('hidden', 'mime_type', null, $options['attr']) !!}  --}}
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}
        @push('modales')
            @if (!view()->shared('modale_media_element'))
                @include('adminify::layouts.admin.medialibrary.modalPicker', [
                    'typed_files' => app('Ludows\Adminify\Libs\MediaService')->getListingTypedFiles(),
                    'dates' => app('Ludows\Adminify\Libs\MediaService')->getListingDates(),
                    'isSelectionMode' => true,
                    'multiple' => $options['media_element_options']['multiple']
                ])
                @php
                    view()->share('modale_media_element', true);
                @endphp
            @endif

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
                @if(!$options['is_child_proto'])
                    document.addEventListener("DOMContentLoaded", function(event) {
                @endif
                    window.admin.modalPicker.push({
                        fieldName: "[name='{!! $name !!}']",
                        selector: "{{ $options['sibling'] }}",
                        options: {!! $export_config !!},
                        multilang: {!! var_export(is_multilang(),true) !!},
                        currentLang: '{!! $currentLang !!}'
                    });
                @if(!$options['is_child_proto'])
                    });
                @endif
            </script>
        @else
            @push('js')
            <script>
                window.admin.modalPicker.push({
                    fieldName: "[name='{!! $name !!}']",
                    selector: "{{ $options['sibling'] }}",
                    options: {!! $export_config !!},
                    multilang: {!! var_export(is_multilang(),true) !!},
                    currentLang: '{!! $currentLang !!}'
                });
            </script>
            @endpush
        @endif

