@php
    $useFigure = isset($useFigure) ? $useFigure : true;
    $useLazyload = isset($useLazyload) ? $useLazyload : false;
    $useThumb = isset($useThumb) && is_array($useThumb) ? $useThumb : false;
    $useDescription = isset($useDescription) ? $useDescription : false;
    $media = isset($media) ? $media : false;
    $imgClass = isset($imgClass) ? $imgClass : 'img-fluid';

    $img_src_attr = 'src';
    if($useLazyload) {
        $img_src_attr = 'data-src';

        $imgClass .= ' js-lazy';
    }
@endphp

@if ($useFigure)
    <figure class="media-figure">
@endif

@if ($media)
    <img class="{{ $imgClass }}" alt="{{ $media->alt }}" src="{{ $useThumb ? image( $media->getRelativePath(), $useThumb) : $media->getRelativePath() }}">
@endif

@if (!empty($media) && $useDescription)
    <figcaption>
        {!! $media->description !!}
    </figcaption>
@endif

@if ($useFigure)
    </figure>
@endif