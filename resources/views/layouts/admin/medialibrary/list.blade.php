@foreach($files as $key => $model)
    <a href="#" data-id="{!! $model->id !!}" data-original="{!! $model->getFullPath() !!}" class="col  js-modal-details">
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! image($model->getRelativePath(), $thumbs) !!}">
    </a>
@endforeach

{!! $files->onEachSide(5)->links() !!}
