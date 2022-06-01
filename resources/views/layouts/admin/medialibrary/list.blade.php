<div class="row">
    @foreach($files as $key => $model)
    <a href="#" data-media='@json($model)' data-id="{!! $model->id !!}" data-original="{!! $model->getFullPath() !!}" class="col  js-modal-details">
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! image($model->getRelativePath(), $thumbs) !!}">
    </a>
@endforeach
</div>
<div class="row">
    <div class="col-12">
        {!! $files->onEachSide(5)->links() !!}
    </div>
</div>

