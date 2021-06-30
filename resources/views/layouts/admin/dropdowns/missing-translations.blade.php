@foreach($actions as $action)
    {!! view($action['template'], $action['vars'])->render() !!}
@endforeach
