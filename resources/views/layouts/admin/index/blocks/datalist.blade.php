@if(count($datas) > 0)
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
                                @else
                                    <tr>
                                        <td>
                                            {{ _i('admin.noDatas') }}
                                        </td>
                                    </tr>     
                                @endif