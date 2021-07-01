@if($data == 0)
    <td>{{ __('admin.hasNoCategory') }}</td>
@else
    {{-- {{ dd($model->children) }} --}}
    <td>{{ $model->children->title }}</td>
@endif
