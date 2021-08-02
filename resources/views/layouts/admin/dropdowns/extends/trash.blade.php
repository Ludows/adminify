<div class="dropdown-item">
    <form method="POST" action="{{ $url }}">
        @csrf
        <button type="submit" class="btn btn-lg js-send-trash btn-outline-danger">
            {{ __('admin.sendTrash') }}
        </button>
    </form>
</div>