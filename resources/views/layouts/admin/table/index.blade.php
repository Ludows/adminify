<script>
    window.listingConfig = {
        limit : {{ config('site-settings.listings.limit') }},
        singular : '{{ Str::singular($name) }}',
        maxItems : {{ $count }},
        isEnd : {{ $count <=  config('site-settings.listings.limit') ? var_export(true, true) : var_export(false, true) }}
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
    @if(!empty($areas['top-left']) || !empty($areas['top-right']))
        <div class="card-header border-0">
            <div class="row align-items-center">

                    @if(!empty($areas['top-left']))
                        @foreach ($areas['top-left'] as $top_left_module)
                        {!!  $top_left_module->render() !!}
                        @endforeach
                    @endif

                    @if(!empty($areas['top-right']))
                        @foreach ($areas['top-right'] as $top_right_module)
                        {!!  $top_right_module->render() !!}
                        @endforeach
                    @endif

            </div>
        </div>
    @endif

    <div class="table-responsive">
        <table class="js-datatable table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    @foreach($thead as $th)
                        <th scope="col">{{ __('admin.table.th_cells.'.$th) }}</th>
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

    @if(!empty($areas['bottom-left']) || !empty($areas['bottom-right']))
        <div class="card-footer">
            <div class="row align-items-center">
                @if(!empty($areas['bottom-left']))
                    @foreach ($areas['bottom-left'] as $bottom_left_module)
                        {!!  $bottom_left_module->render() !!}
                    @endforeach
                @endif

                @if(!empty($areas['bottom-right']))
                    @foreach ($areas['bottom-right'] as $bottom_right_module)
                        {!!  $bottom_right_module->render() !!}
                    @endforeach
                @endif
            </div>
        </div>
    @endif

</div>




