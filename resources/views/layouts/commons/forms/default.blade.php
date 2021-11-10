    @if ($showConfirmation && !empty($confirmation) && $confirmation->type == 'samepage')
        {!! $confirmation->content !!}      
    @endif

    @if($showForm)
        {!! form($form) !!}
    @endif
