@include('adminify::layouts.admin.headers.topPageListing', [
    'breadcrumb' => false
])

{!! form_start($form) !!}
<div class="container-fluid editor  mt--7">
    @yield('before_content')
    <div class="row">


        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    {!! form_row($form->title, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) !!}
                </div>
            </div>
            {{-- // editeur next --}}
            @yield('before_editor')
            {!! form_row($form->content) !!}
            {!! form_row($form->user_id) !!}
            @yield('after_editor')
            {{-- {!! dd($form) !!} --}}

            @if(!empty($form->_metaboxes))
                @php
                    $spl_metaboxes = explode(',', $form->_metaboxes->getValue());
                @endphp
                {!! form_row($form->_metaboxes) !!}
                @foreach ($spl_metaboxes as $metabox_formitem)
                    {!! form_row($form->{'_'.$metabox_formitem}) !!}
                @endforeach

            @endif
        </div>
        <div class="col-12 col-lg-3 sticky-top">
            @yield('start_sidebar')
            <div class="card shadow-lg">
                <div class="card-body">
                    @yield('before_settings_page')
                    {!! isset($form->categories_id) ? form_row($form->categories_id) : '' !!}
                    {!! isset($form->tags_id) ? form_row($form->tags_id) : '' !!}
                    {!! form_row($form->status_id) !!}
                    {!! isset($form->media_id) ? form_row($form->media_id, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) : '' !!}
                    {!! form_row($form->no_comments) !!}
                    @yield('after_settings_page')
                </div>
                <div class="card-footer">
                    {!! form_row($form->submit, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) !!}
                </div>
            </div>
            @yield('end_sidebar')
        </div>
    </div>
    @yield('after_content')
</div>
{!! form_end($form, false) !!}

