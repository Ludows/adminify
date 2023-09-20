    @if ($showConfirmation)
        {!! $form->getConfirmationContent() !!}      
    @endif

    @if($showForm)
        {!! form($form) !!}
    @endif
