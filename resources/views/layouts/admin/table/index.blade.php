<script>
    window.listingConfig = {
        limit : {{ config('site-settings.listings.limit') }},
        singular : '{{ Str::singular($name) }}',
        maxItems : {{ $count }},
        isEnd : {{ $count <  config('site-settings.listings.limit') ? true : false }}
    }
</script>

@if(isset($css) && count($css) > 0)
    @push('css')
        @foreach ($css as $cssPath)
            <link type="text/css" href="{{ $cssPath }}" rel="stylesheet">
        @endforeach
    @endpush
@endif

@if(isset($js) && count($js) > 0)
    @push('js')
        @foreach ($js as $jsPath)
            <script src="{{ $jsPath }}"></script>
        @endforeach
    @endpush
@endif

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
                            <a href="{{ route($name.'.create', ['lang' => $useMultilang ? $currentLang : '']) }}" class="btn btn-sm btn-primary"> {{ __('admin.'.$name.'.create') }}</a>
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
                        <th scope="col">{{ __('admin.'.$name.'.'.$th) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @include('adminify::layouts.admin.table.datalist', ['datas' => $datas])
            </tbody>
        </table>
        <div class="mt-3 px-3">
            @include('adminify::layouts.admin.table.paginate')
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            TESTS
        </div>
    </div>
    
</div>




