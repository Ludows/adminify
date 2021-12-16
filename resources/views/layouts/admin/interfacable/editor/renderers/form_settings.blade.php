{!! form_start($form) !!}
    @foreach($global_controls as $keyControl => $value)
        {!! form_row($form->{$keyControl}) !!}
    @endforeach

    @if (count($breakpoints_names) > 0)
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
            <li class="nav-item" role="presentation">
            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="pills-{!! $uuid !!}-{!! $breakpointKey !!}-tab" data-toggle="pill" href="#pills-{!! $uuid !!}-{!! $breakpointKey !!}" role="tab" aria-controls="pills-{!! $uuid !!}-{!! $breakpointKey !!}" aria-selected="false">
                {!! __('admin.editor.breakpoints.'.$breakpointKey) !!}
            </a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="pills-tabContent">
            @foreach ($editor['breakpoints'] as $breakpointKey => $breakpointValue)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{!! $uuid !!}-{!! $breakpointKey !!}" role="tabpanel" aria-labelledby="pills-{!! $uuid !!}-{!! $breakpointKey !!}-tab">
                        @foreach ($breakpoints_controls[$breakpointKey] as $breakpoints_controlsValue)
                            {!! form_row($breakpoints_controlsValue) !!}
                        @endforeach
                    </div>
            @endforeach
        </div>
    @endif

{!! form_end($form, false) !!}
