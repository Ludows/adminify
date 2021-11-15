<div class="adminify_editor">

{!! $blocks['topbar-editor-block']->render() !!}
{!! $blocks['sidebar-block']->render() !!}
{!! $blocks['sidebar-controls-block']->render() !!}

<div class="render_zone">
    {!! $blocks['renderer-block']->render() !!}
</div>

</div>

@push('js')
    <script type="text/javascript" src="{{ asset('adminify') }}/back/js/editor.js"></script>
@endpush