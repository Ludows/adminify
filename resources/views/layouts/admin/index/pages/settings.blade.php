@include('layouts.admin.headers.topPageListing')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-12">
            @php
                $name = request()->route()->getName();
                $name = str_replace('.index', '', $name);
            @endphp

            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>

    </div>

    @include('layouts.admin.footers.auth')
</div>
