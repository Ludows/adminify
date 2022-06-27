<div class="card">
    <div class="card-header">
        {{ __('adminify.formbuilder.fields') }}
    </div>
    <div class="card-body" style="height: 400px;overflow:auto;">
        <div id="Fields_zone" class="row js-dropzone">
            @foreach ($fields as $fieldKey => $fieldName)
                <div class="col-12 mb-3 col-lg-6">
                    <button data-name="{{ $fieldName }}" class="btn btn-default js-btn-field btn-sm btn-block">
                        {{ __('admin.formbuilder.fieldlist.'.$fieldName) }}
                    </button>
                </div>
            @endforeach
        </div>

    </div>
</div>
