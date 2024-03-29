@php
    $getCssClassPreview = isset($cssClassPreview) ? $cssClassPreview : 'col-lg-5';
    $getCssClassFormPreview = isset($cssClassFormPreview) ? $cssClassFormPreview : 'col-lg-7';
    $getUseSingleDeytroyImage = isset($useSingleDeytroyImage) ? $useSingleDeytroyImage : false;
@endphp

<div class="row">
    <div class="{!! $getCssClassPreview !!}">
        <img id="imageOriginal" class="img-fluid js-preview mb-3 rounded shadow-lg d-none" alt="" src="">
        <video src="" class="d-none js-preview mb-3" id="videoOriginal"></video>
        <audio controls src="" class="d-none mb-3 js-preview" id="audioOriginal"></audio>
        <iframe src="" class="d-none mb-3 js-preview" id="iframeOriginal"></iframe>
    </div>
    <div class="{!! $getCssClassFormPreview !!}">
        <form method="POST" action="#">
            @csrf
            <div class="form-group">
                <textarea name="description" class="form-control js-metadatas-media" placeholder="{!! __('admin.media.description') !!}"></textarea>
            </div>
            <div class="form-group">
                <input name="alt" type="text" class="form-control js-metadatas-media" placeholder="{!! __('admin.media.alt') !!}"/>
            </div>
        </form>

        @if ($getUseSingleDeytroyImage)
            <button type="button" class="btn btn-danger js-single-destroy-media">{!! __('admin.media.delete_image') !!}</button>
        @endif
    </div>
</div>
