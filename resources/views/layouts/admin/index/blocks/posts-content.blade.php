<td>
    @if(isset($data))
        {{ __('posts.hasContent') }}
    @else
        {{ __('posts.hasNoContent') }}
    @endif
</td>
