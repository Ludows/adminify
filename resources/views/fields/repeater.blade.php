<div id="{{ $options['sibling'] }}">
    @if($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if($showLabel && $options['label'] !== false && $options['label_show'])
        {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if($showField)
        @foreach ( (array)$options['children'] as $child )
            {!! $child->render() !!}
        @endforeach

        {{--  <div class="collection-container" data-prototype="{{ form_row($form->tags->prototype()) }}">  --}}

        @include('vendor/laravel-form-builder/errors')
        @include('vendor/laravel-form-builder/help_block')
    @endif

    @if($options['wrapper'] !== false)
        </div>
    @endif

</div>
