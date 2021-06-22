<td>
    @foreach($model->categories as $category)
        {{ $category->title }}
        @if(count($model->categories) > 1 && !$loop->last)
            ,
        @endif
    @endforeach
</td>
