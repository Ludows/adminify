<div class="col">
    <select class="form-control js-select-status">
        <option value="-1">{{ __('admin.select.status') }}</option>
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ __('admin.statuses.'.$status->name) }}</option>
        @endforeach
    </select>
</div>