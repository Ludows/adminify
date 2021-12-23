<div class="adminify_editor">

    <script>
        window.toolbars = [];
        window.actions = {};
        window.editorConfig = @json($siteConfig['editor']);

    </script>
    {!! $blocks['topbar-editor-block']->render() !!}
    {!! $blocks['sidebar-block']->render() !!}
    {!! $blocks['sidebar-controls-block']->render() !!}
    <div class="sidebar left sidebar_domthree">
        @todo
    </div>
    {!! $blocks['templates-block']->render() !!}


    <div class="render_zone h-100">
        {!! $blocks['renderer-block']->render() !!}
    </div>

    </div>

    @push('js')
        <script type="text/javascript" src="{{ asset('adminify') }}/back/js/editor.js"></script>
        <script type="text/javascript" src="{{ asset('adminify') }}/back/js/editor/helpers.js"></script>
        <script type="text/javascript" src="{{ asset('adminify') }}/back/js/editor/global.js"></script>
    @endpush
