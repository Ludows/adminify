@if(gettype($data) == 'integer')
    <td><img class="img-fluid" alt="{{ $model->avatar()->first()->src  }}" src="{{ asset('myuploads/medias/') }}/{{ $model->avatar()->first()->src }}" ></td>
@else
    <td> {{ _i('admin.hasNoAvatar') }} </td>
@endif
