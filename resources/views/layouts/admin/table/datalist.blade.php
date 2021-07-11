@php
    $baseIterationColumns = 0;
    //dd($datas, $count, $thead);
@endphp
@if($count > 0)
    @for($i = 0; $i < $count; $i++)

        <tr>
            @foreach ($thead as $t)
                @php
                    $slugBlade = Str::slug($t);
                @endphp
                @include($datas[$slugBlade][$baseIterationColumns]->view, $datas[$slugBlade][$baseIterationColumns]->vars)
            @endforeach

            @php
                $baseIterationColumns = ($baseIterationColumns + 1);
            @endphp
        </tr>

    @endfor
@else
        <tr>
            <td>
                {{ __('admin.noDatas') }}
            </td>
        </tr>
@endif
