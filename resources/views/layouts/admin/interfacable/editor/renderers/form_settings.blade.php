{!! form_start($form) !!}

@foreach($global_controls as $keyControl => $value)
    {!! form_row($form->{$keyControl}) !!}
@endforeach

 <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="pills-{!! $uuid !!}-{!! $breakpointKey !!}-tab" data-toggle="pill" href="#pills-{!! $uuid !!}-{!! $breakpointKey !!}" role="tab" aria-controls="pills-{!! $uuid !!}-{!! $breakpointKey !!}" aria-selected="false">
          {!! __('admin.editor.breakpoints.'.$breakpointKey) !!}
      </a>
    </li>
    @endforeach
  </ul>
  <div class="tab-content" id="pills-tabContent">
    @foreach ($breakpoints_controls as $breakpoints_controlsKey => $breakpoints_controlsValue)
            <div class="tab-pane fade {{ $loop->first ? 'show' : '' }}" id="pills-{!! $uuid !!}-{!! $breakpoints_controlsKey !!}" role="tabpanel" aria-labelledby="pills-{!! $uuid !!}-{!! $breakpoints_controlsKey !!}-tab">
                @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
                    {!! form_row($form->{$breakpoints_controlsKey}) !!}
                @endforeach
            </div>
        
    @endforeach
  </div>

{!! form_end($form, false) !!}
