{{-- {{ dd($data) }} --}}
@if(gettype($data) == 'string' && strlen($data) > 0)
    <td>{{ _i('admin.hasContent') }}</td>
@else
    <td> {{ _i('admin.hasNoContent') }}</td>
@endif
