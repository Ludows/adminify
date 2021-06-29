@include('adminify::layouts.admin.headers.topPageListing')

<div class="js-listings" data-page="1">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-12">
                @php
                    $name = request()->route()->getName();
                    $name = str_replace('.index', '', $name);
                @endphp

                <script>
                    window.listingConfig = {
                        limit : {{ config('site-settings.listings.limit') }},
                        singular : '{{ Str::singular($name) }}',
                        maxItems : {{ count($datas) }},
                        isEnd : {{ count($datas) <  config('site-settings.listings.limit') ? true : false }}
                    }
                </script>
    
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-8">
                                <h3 class="mb-0">{{ _i($name.'.title') }}</h3>
                            </div>
                            
                                <div class="col-12 col-lg-4 d-flex justify-content-between align-items-center text-right">
                                    <input id="" class="form-control js-search-entity" placeholder="Search" type="text">
                                    @if(\Route::has($name.'.create'))
                                        <div class="ml-lg-3 mt-3 mt-lg-0">
                                            <a href="{{ route($name.'.create', ['lang' => $useMultilang ? $currentLang : '']) }}" class="btn btn-sm btn-primary"> {{ _i($name.'.add') }}</a>
                                        </div>
                                    @endif
                                </div>
                            
                        </div>
                    </div>
    
                    <div class="table-responsive">
                        <table class="js-datatable table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    @foreach($thead as $th)
                                        <th scope="col">{{ _i($name.'.'.$th) }}</th>
                                    @endforeach
                                    <th scope="col">{{ _i('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('adminify::layouts.admin.index.blocks.datalist', ['datas' => $datas])
                            </tbody>
                        </table>
                        <div class="mt-3 px-3">
                            @include('adminify::layouts.admin.index.blocks.paginate')
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    
        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

@push('js')
    <script src="{{ asset('argon') }}/js/listings.js"></script>
@endpush

