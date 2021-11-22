{!! form_start($form) !!}

{!! form_row($form->widget_type) !!}
{!! form_row($form->widget_uuid) !!}

{!! form_row($form->tag) !!}
{!! form_row($form->font_family) !!}
{!! form_row($form->color) !!}
{!! form_row($form->cssClasses) !!}
{!! form_row($form->textTransform) !!}

 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="pills-{!! $uuid !!}-home-tab" data-toggle="pill" href="#pills-{!! $uuid !!}-home" role="tab" aria-controls="pills-{!! $uuid !!}-home" aria-selected="true">Home</a>
    </li>
    @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="pills-{!! $uuid !!}-{!! $breakpointKey !!}-tab" data-toggle="pill" href="#pills-{!! $uuid !!}-{!! $breakpointKey !!}" role="tab" aria-controls="pills-{!! $uuid !!}-{!! $breakpointKey !!}" aria-selected="false">
          {!! __('admin.editor.breakpoints.'.$breakpointKey) !!}
      </a>
    </li>
    @endforeach
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-{!! $uuid !!}-home" role="tabpanel" aria-labelledby="pills-{!! $uuid !!}-home-tab">
        {!! form_row($form->fontsize) !!}
        {!! form_row($form->alignment) !!}
        {!! form_row($form->fontsize_unit) !!}
        {!! form_row($form->line_height) !!}
        {!! form_row($form->line_height_unit) !!}
    </div>

    @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
        <div class="tab-pane fade" id="pills-{!! $uuid !!}-{!! $breakpointKey !!}" role="tabpanel" aria-labelledby="pills-{!! $uuid !!}-{!! $breakpointKey !!}-tab">
            {!! form_row($form->{'fontsize_'.$breakpointKey}) !!}
            {!! form_row($form->{'alignment_'.$breakpointKey}) !!}
            {!! form_row($form->{'fontsize_unit_'.$breakpointKey}) !!}
            {!! form_row($form->{'line_height_'.$breakpointKey}) !!}
            {!! form_row($form->{'line_height_unit_'.$breakpointKey}) !!}
        </div>
    @endforeach
  </div>

{!! form_end($form, false) !!}
