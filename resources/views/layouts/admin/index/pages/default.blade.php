@include('adminify::layouts.admin.headers.topPageListing')

<div class="js-listings" data-page="1">
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
                            <div class="col-12 col-lg-8">
                                <h3 class="mb-0">{{ __('admin.'.$name.'.title') }}</h3>
                            </div>
                            
                                <div class="col-12 col-lg-4 d-flex justify-content-between align-items-center text-right">
                                    <input id="" class="form-control js-search-entity" placeholder="Search" type="text">
                                    @if(\Route::has($name.'.create'))
                                        <div class="ml-lg-3 mt-3 mt-lg-0">
                                            <a href="{{ route($name.'.create', ['lang' => $useMultilang ? $currentLang : '']) }}" class="btn btn-sm btn-primary"> {{ __('admin'.$name.'.store') }}</a>
                                        </div>
                                    @endif
                                </div>
                            
                        </div>
                    </div>
    
                    @if(isset($table))
                        {!! $table !!}
                    @endif
                </div>
            </div>
    
        </div>
    
        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

@push('js')
    <script src="{{ asset('argon') }}/js/listings.js"></script>
@endpush

