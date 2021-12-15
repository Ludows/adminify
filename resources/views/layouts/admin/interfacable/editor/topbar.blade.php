<div class="editor-topbar shadow-lg bg-white sticky-top container-fluid">
    <div class="row justify-content-between align-items-center">
        <div class="col">
            <a href="{{ route($name.'.index') }}" class="btn btn-return btn-default btn-lg rounded-0">
                {{ __('admin.editor.sidebar.goback') }}
            </a>
            <a href="#" data-handle=".sidebar_widgets" class="btn btn-primary btn-sm js-sidebar">
                {{ __('admin.editor.sidebar.open') }}
            </a>

            <a href="#" class="btn btn-outline-default btn-sm js-template">
                {{ __('admin.editor.sidebar.addTemplate') }}
            </a>

            <a href="#" data-handle=".sidebar_domthree" class="btn btn-outline-default btn-sm js-sidebar">
                {{ __('admin.editor.sidebar.domThree') }}
            </a>
        </div>
        <div class="col text-right">
            <a href="#" data-handle=".sidebar_js" class="btn btn-outline-primary btn-sm js-sidebar">
                {{ __('admin.editor.addCustomJs') }}
            </a>
            <a href="#" data-handle=".sidebar_controls" class="btn btn-outline-default js-sidebar">
                {{ __('admin.editor.settings') }}
            </a>
            <a href="#" class="btn btn-default rounded-0  js-publish">
                {{ $isCreate ? __('admin.editor.publish') : __('admin.editor.update') }}
            </a>
        </div>
    </div>
</div>
