<div class="dropdown-item">
    <form method="POST" action="{{ $url }}">
        @csrf
        <button type="submit" class="btn btn-lg js-send-trash btn-outline-danger">
            {{ __('admin.send_trash') }}
        </button>
    </form>
</div>