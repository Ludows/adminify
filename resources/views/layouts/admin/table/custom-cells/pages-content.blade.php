{{-- {{ dd($data) }} --}}
@if(gettype($data) == 'string' && strlen($data) > 0)
    <td>{{ __('admin.hasContent') }}</td>
@else
    <td> {{ __('admin.hasNoContent') }}</td>
@endif
