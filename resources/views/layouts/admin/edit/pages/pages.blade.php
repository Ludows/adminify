@include('adminify::layouts.admin.headers.topPageListing')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-12">
            @php
                $name = request()->route()->getName();
                $name = str_replace('.edit', '', $name);
            @endphp

            <div class="card shadow bg-transparent">
                {{-- <div class="card-header border-0">
                    {{ __('edit.'.$name) }}
                </div> --}}
                <div class="card-body p-0">
                    @if(isset($form))
                        {!! form($form) !!}
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
