<style>
    .select2-container .select2-selection--single {
        height: auto;
    }
</style>
<div id="{{ $options['sibling'] }}">

    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        @php    
            $emptyVal = $options['empty_value'] ? ['0' => $options['empty_value']] : null;
            if(isset($options['select2options']['multiple']) && $options['select2options']['multiple'] == false) {
                $emptyVal = ['' => $options['empty_value']];
            }
            
        @endphp
        @if($options['withCreate'])
            <button class="js-handle-form-create btn btn-default">+</button>
        @endif
        {{-- {{ dd($options['choices']) }} --}}
        {!! Form::select($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) !!}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')

    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif
</div>

@if($options['withCreate'] && $options['modal'])
    @push('modales')
        @include($options['modal'], $options['modal_attributes'])
    @endpush
@endif


@if ($options['isAjax'])
    <script type="text/javascript">
        @if(!$options['is_child_proto'])
            document.addEventListener("DOMContentLoaded", function(event) {
        @endif
        Select2InitFunction([{
            selector: '#{{ $options['sibling'] }}',
            modal_attributes: @json($options['modal_attributes']),
            withCreate: @json($options['withCreate']),
            options: @json($options['select2options']),
            dynamic_modal : @json($options['dynamic_modal']),
            form :  @json($options['form']),
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
                window.admin.select2Fields.push({
                    selector: '#{{ $options['sibling'] }}',
                    modal_attributes: @json($options['modal_attributes']),
                    withCreate: @json($options['withCreate']),
                    options: @json($options['select2options']),
                    dynamic_modal : @json($options['dynamic_modal']),
                    form :  @json($options['form']),
                    multilang: {!! var_export(is_multilang(),true) !!},
                    currentLang: '{!! $currentLang !!}'
                })
        </script>
    @endpush
@endif
