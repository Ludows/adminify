@if(gettype($model->{$attr}) == 'integer')
    <td><img class="img-fluid" alt="{{ $model->avatar()->first()->src  }}" src="{{ asset('myuploads/medias/') }}/{{ $model->avatar()->first()->src }}" ></td>
@else
    <td> {{ __('admin.hasNoAvatar') }} </td>
@endif