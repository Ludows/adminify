<div class="col">
    <select class="form-control js-select-status">
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ __('admin.statuses.'.$status->name) }}</option>
        @endforeach
    </select>
</div>