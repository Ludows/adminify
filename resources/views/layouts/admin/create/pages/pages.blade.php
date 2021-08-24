@include('adminify::layouts.admin.headers.topPageListing', [
    'breadcrumb' => false
])

{!! form_start($form) !!}
<div class="container-fluid editor  mt--7">
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
            {!! form_row($form->content) !!}
            {!! form_row($form->user_id) !!}
            {{-- {!! dd($form) !!} --}}
        </div>
        <div class="col-12 col-lg-3 sticky-top">
            <div class="card shadow-lg">
                <div class="card-body">
                    {!! form_row($form->categories_id) !!}
                    {!! form_row($form->parent_id) !!}
                    {!! form_row($form->status_id) !!}
                    {!! form_row($form->media_id, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) !!}
                </div>
                <div class="card-footer">
                    {!! form_row($form->submit, ['wrapper' => [
                        'class' => 'form-group mb-0'
                    ]]) !!}
                </div>
            </div>
        </div>


        {{-- <div class="col-12">
            @php
                $name = request()->route()->getName();
                $name = str_replace('.create', '', $name);
            @endphp

            <div class="card shadow">
                <div class="card-body">
                    @if(isset($form))
                        {!! form($form) !!}
                    @endif
                </div>
            </div>
        </div> --}}
    </div>
</div>
{!! form_end($form, false) !!}

