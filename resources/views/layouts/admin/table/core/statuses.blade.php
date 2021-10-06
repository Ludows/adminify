<div class="col">
    <select class="form-control js-select-status">
        <option value="1">{{ __('admin.table.modules.statuses.select_status') }}</option>
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ __('admin.table.modules.statuses.'.$status->name) }}</option>
        @endforeach
    </select>
</div>