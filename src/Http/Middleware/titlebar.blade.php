@php
    $showBreadcrumb = isset($showBreadcrumb) ? $showBreadcrumb : true;
@endphp
<section class="section-header bg-primary text-white pb-10 pb-sm-8 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                {!! $title ?? '' !!}
            </div>
            @if($showBreadcrumb && isset($breadcrumb))
                <div class="col-12">
                    {!! $breadcrumb !!}
                </div>
            @endif
        </div>
    </div>
</section>
