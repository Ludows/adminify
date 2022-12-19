@php
    $uuid = isset($uuid) ? $uuid : uuid(15);
    $update = isset($update) ? $update : false;
    $respond = isset($respond) ? $respond : false;
    $display = '';
    if($update || $respond) {
        $display = 'd-none';
    }
@endphp
<form class="{{ $update ? 'update-comment-form' : ($respond ? 'respond-comment-form' : 'create-comment-form') }} {{ $display }} component-{{ $uuid }}">
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    <input type="hidden" name="model_id" value="{{ $model->id }}">
    <input type="hidden" name="model_class" value="{{ get_class($model) }}">
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="is_moderated" value="{{ $update ? 1 : $user->hasAnyRole(['administrator', 'editor']) }}">

    <div class="form-row">
        <div class="col-12">
            <div class="form-group">
                <label for="comment_{{ $uuid }}">{!! __('adminify.comment_form_label') !!}</label>
                <textarea required="required" class="form-control" id="comment_{{ $uuid }}" name="comment" rows="3"></textarea>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{!! __('adminify.comment_form_submit') !!}</button>
</form>