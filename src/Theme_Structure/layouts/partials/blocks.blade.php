@if(!empty($blocks))
    @foreach ($blocks as $block)
        @include('blocs::'.$block['_name'], $block)
    @endforeach
@endif

