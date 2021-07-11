<script>
    window.listingConfig = {
        limit : {{ config('site-settings.listings.limit') }},
        singular : '{{ Str::singular($name) }}',
        maxItems : {{ $count }},
        isEnd : {{ $count <  config('site-settings.listings.limit') ? true : false }}
    }
</script>

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
