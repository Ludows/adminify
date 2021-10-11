<div class="card">
    <div class="card-header">
        {{ __('adminify.formbuilder.fields') }}
    </div>
    <div class="card-body" style="height: 400px;overflow:auto;">
        <div class="row js-dropzone">
            @foreach ($fields as $fieldKey => $fieldName)
                <div class="col-12 mb-3 col-lg-6">
                    <button class="btn btn-default btn-sm btn-block">
                        {{ $fieldName }}
                    </button>
                </div>
            @endforeach
        </div>
        
    </div>
</div>