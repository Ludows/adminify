@if (!$isCreate)
    <div class="card">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">
                <a href="{{ route('forms.edit', ['form' => $model->id]) }}" class="btn btn-primary">
                    {{ __('adminify.formbuilder.modify') }}
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('forms.traces', ['id' => $model->id]) }}" class="btn btn-primary">
                    {{ __('adminify.formbuilder.traces') }}
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('forms.confirmation', ['id' => $model->id]) }}" class="btn btn-primary">
                    {{ __('adminify.formbuilder.confirmation') }}
                </a>
            </li>
        </ul>
    </div>
@endif
