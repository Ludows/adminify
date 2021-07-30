<div class="row mt-5 row-cols-1 row-cols-md-2 row-cols-lg-3">
    @foreach($blocks as $block)
        <div class="col mb-4">
            {!! $block->render() !!}
        </div>
    @endforeach
</div>