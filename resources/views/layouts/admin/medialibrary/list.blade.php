@foreach($files as $key => $value)
    <a href="#" data-original="{!! $value['url'] !!}" class="col  js-modal-details">
        <img alt="" class="img-fluid shadow rounded-lg" src="{!! image($value['file'], $thumbs) !!}">
    </a>
@endforeach
