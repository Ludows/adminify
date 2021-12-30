<div class="adminify_editor">
    @php

        // we check if a file settings is provided
        $f = '';
        $c = [];
        if($isEdit) {
            $f = look_file( public_path() . '/' . $request->singleParam . '-' . $request->routeParameters[ $request->singleParam ]->id .'.json');
            if(!empty($f)) {
                $f = json_decode($f['content']);
                $c = json_decode($f->toolbars);
                $f = $f->settingsBlocks;
            }
        }

        $aready = !empty(old('_settings_blocks')) ? old('_settings_blocks') : $f;
    @endphp

    <script>
        window.toolbars = @json( json_decode( old('_toolbars') ) ?? $c);
        window.actions = {};
        window.alreadyBlocks = @json($aready);
        window.editorConfig = @json($siteConfig['editor']);

    </script>
    {!! $blocks['topbar-editor-block']->render() !!}
    {!! $blocks['sidebar-block']->render() !!}
    {!! $blocks['sidebar-controls-block']->render() !!}
    <div class="sidebar left sidebar_domthree">
    </div>

    <div class="render_zone h-100">
        {!! $blocks['renderer-block']->render() !!}
    </div>

    </div>

    @php
        add_asset('default',  asset('adminify/back') . '/js/editor.js');
        add_asset('default',  asset('adminify/back') . '/js/editor/helpers.js');
        add_asset('default',  asset('adminify/back') . '/js/editor/global.js');
    @endphp

