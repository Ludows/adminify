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
                                                @isset($dropdownManager)
                                                    @include('adminify::layouts.admin.index.blocks.dropdown-actions', ['dropdownManager' => $dropdownManager, 'index' => $data->id ])
                                                @endisset
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            {{ __('admin.noDatas') }}
                                        </td>
                                    </tr>     
                                @endif