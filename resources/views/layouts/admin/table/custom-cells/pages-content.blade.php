{{-- {{ dd($data) }} --}}
@if(gettype($model->{$attr}) == 'string' && strlen($model->{$attr}) > 0)
    <td>{{ __('admin.hasContent') }}</td>
@else
    <td> {{ __('admin.hasNoContent') }}</td>
@endif
