<div class="row">
    @foreach($files as $key => $model)
        @include('adminify::layouts.admin.medialibrary.file', [
            'model' => $model,
            'thumbs' => $thumbs,
        ])
    @endforeach
</div>
<div class="row">
    <div class="col-12">
        {!! $files->onEachSide(5)->links() !!}
    </div>
</div>

