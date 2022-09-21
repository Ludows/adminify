@include('adminify::layouts.admin.headers.topPageListing', [
    'breadcrumb' => false
])

@hook('before_form_page')
{!! form_start($form) !!}
<div class="container-fluid editor  mt--7">
    @hook('before_content_page')
    <div class="row">


        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-12 col-lg-10">
                            {!! form_row($form->title, ['wrapper' => [
                                'class' => 'form-group mb-0'
                            ]]) !!}
                        </div>
                        <div class="col-12 col-lg-2">
                            @php
                                $routePreview = 'frontend.'. lowercase($request->type) .'.'. $request->model->slug;
                            @endphp
                            <a href="{{ route($routePreview) }}" class="btn btn-default" target="_blank"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- // editeur next --}}
            @hook('before_editor')
            {!! form_row($form->content) !!}
            {!! form_row($form->user_id) !!}
            @hook('after_editor')
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
            @hook('before_submit_box')
            <div class="card shadow-lg">
                <div class="card-body">
                    @hook('before_settings_page')
                    {!! isset($form->categories) ? form_row($form->categories) : '' !!}
                    {!! isset($form->tags) ? form_row($form->tags) : '' !!}
                    {!! form_row($form->status_id) !!}
                    {!! isset($form->media_id) ? form_row($form->media_id, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) : '' !!}
                    @hook('after_settings_page')
                </div>
                <div class="card-footer">
                    {!! form_row($form->submit, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) !!}
                </div>
            </div>
            @hook('after_submit_box')
        </div>
    </div>
    @hook('after_content_page')
</div>
{!! form_end($form, false) !!}
@hook('after_form_page')

