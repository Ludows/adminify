<div class="adminify_editor">
    @php
        $aready = !empty(old('_settings_blocks')) ? old('_settings_blocks') : '';
    @endphp

    <script>
        window.toolbars = @json( json_decode( old('_toolbars') ) ?? []);
        window.actions = {};
        window.alreadyBlocks = @json($aready);
        window.editorConfig = @json($siteConfig['editor']);

    </script>
    {!! $blocks['topbar-editor-block']->render() !!}
    {!! $blocks['sidebar-block']->render() !!}
    {!! $blocks['sidebar-controls-block']->render() !!}
    <div class="sidebar left sidebar_domthree">
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
