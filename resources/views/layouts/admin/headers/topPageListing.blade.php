@php
    $show_breadcrumb = $isset($breadcrumb) ? $breadcrumb : true;
@endphp
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                </div>
                @if($show_breadcrumb)
                    <div class="col-12">
                        {{ Breadcrumbs::render(request()->route()->getName()) }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
