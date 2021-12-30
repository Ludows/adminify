<div class="sidebar left sidebar_templates">
    @if(empty($query))
      <div class="alert alert-info" role="alert">
        {!! __('admin.editor.noTpl') !!}
      </div>
    @endif
    @if ($query->count() > 0)
        <div class="row template_zone">
            @foreach ($query as $tpl)
                <div data-template="{{ $tpl->id }}" class="col-6">
                    <div class="card shadow js-handle">
                        <div class="card-body text-center">
                        <i class="ni ni-collection"></i>
                        <p class="card-text small text-muted">
                            {{ $tpl->title }}
                        </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
