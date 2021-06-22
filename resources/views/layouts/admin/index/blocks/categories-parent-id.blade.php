@if($data == 0)
    <td>{{ __('categories.nocat') }}</td>
@else
    {{-- {{ dd($model->children) }} --}}
    <td>{{ $model->children->title }}</td>
@endif
