{{-- {{ dd($data) }} --}}
@if(gettype($model->{$attr}) == 'integer' && $model->{$attr} != 0)
    <td><img class="img-fluid" alt="{{ $model->media->src  }}" src="{{ $model->media->path ?? '' }}" ></td>
@else
    <td> {{ __('admin.hasNoImage') }} </td>
@endif
