@include('adminify::layouts.admin.headers.topPageListing')

<div class="container-fluid editor mt--7">
    <div class="row no-gutters">
        <div class="col-12">
            @php
                $name = request()->route()->getName();
                $name = str_replace('.create', '', $name);
            @endphp

            <div class="card shadow">
                {{-- <div class="card-header border-0">
                    {{ __('add.'.$name) }}
                </div> --}}
                <div class="card-body">
                    @if(isset($form))
                        {!! form($form) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
