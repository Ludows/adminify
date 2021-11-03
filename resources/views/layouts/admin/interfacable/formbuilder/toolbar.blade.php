<div class="card">
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item">
            <a href="{{ route('forms.create') }}" class="btn btn-primary">
                {{ __('adminify.formbuilder.create') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('forms.entries', ['id' => 1]) }}" class="btn btn-primary">
                {{ __('adminify.formbuilder.entries') }}
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('forms.confirmation', ['id' => 1]) }}" class="btn btn-primary">
                {{ __('adminify.formbuilder.confirmation') }}
            </a>
        </li>
    </ul>
</div>
