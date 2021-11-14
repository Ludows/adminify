<div class="editor-topbar shadow-lg p-2 bg-white sticky-top container-fluid">
    <div class="row justify-content-between align-items-center">
        <div class="col">
            <a href="#" class="btn btn-primary btn-sm js-sidebar">
                {{ __('admin.editor.sidebar.open') }}
            </a>

            <a href="#" class="btn btn-outline-default btn-sm js-template">
                {{ __('admin.editor.sidebar.addTemplate') }}
            </a>
        </div>
        <div class="col text-right">
            <a href="#" class="btn btn-outline-primary btn-sm js-preview">
                {{ __('admin.editor.preview') }}
            </a>
            <a href="#" class="btn btn-outline-default js-settings">
                {{ __('admin.editor.settings') }}
            </a>
            <a href="#" class="btn btn-default rounded-0  js-publish">
                {{ $isCreate ? __('admin.editor.publish') : __('admin.editor.update') }}
            </a>
        </div>
    </div>
</div>
