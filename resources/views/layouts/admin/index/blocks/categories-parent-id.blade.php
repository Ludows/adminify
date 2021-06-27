@if($data == 0)
    <td>{{ _i('admin.hasNoCategory') }}</td>
@else
    {{-- {{ dd($model->children) }} --}}
    <td>{{ $model->children->title }}</td>
@endif
