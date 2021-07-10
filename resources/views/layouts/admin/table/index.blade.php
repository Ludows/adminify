<div class="table-responsive">
    <table class="js-datatable table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                @foreach($thead as $th)
                    <th scope="col">{{ __('admin.'.$name.'.'.$th) }}</th>
                @endforeach
                <th scope="col">{{ __('admin.actions') }}</th>
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