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
                            <div class="col-8">
                                <h3 class="mb-0">{{ _i($name.'.title') }}</h3>
                            </div>
                            @if(\Route::has($name.'.create'))
                                <div class="col-4 text-right">
                                    <a href="{{ route($name.'.create', ['lang' => $useMultilang ? $currentLang : '']) }}" class="btn btn-sm btn-primary"> {{ _i($name.'.add') }}</a>
                                </div>
                            @endif
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
                                @foreach($datas as $data)
                                    <tr>
                                        @foreach($thead as $th)
                                            @php
                                                $slugBlade = Str::slug($th);
                                            @endphp
                                            @if(view()->exists('adminify::layouts.admin.index.blocks.'.$name.'-'.$slugBlade))
                                                @include('adminify::layouts.admin.index.blocks.'.$name.'-'.$slugBlade, ['data' => $data[$th] ,'model' => $data ])
                                            @elseif(view()->exists('layouts.admin.index.blocks'.$slugBlade))
                                                @include('adminify::layouts.admin.index.blocks.'.$slugBlade, ['data' => $data[$th] ,'model' => $data])
                                            @else
                                                <td>{{ $data[$th] }}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            @isset($actions)
                                                @include('adminify::layouts.admin.index.blocks.dropdown-actions', ['action' => $actions[$loop->index]])
                                            @endisset
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
        </div>
        <div class="row">
            <div class="col-12">
                @include('adminify::layouts.admin.index.blocks.paginate')
            </div>
        </div>
    
        @include('adminify::layouts.admin.footers.auth')
    </div>
</div>

