@include('adminify::layouts.admin.headers.topPageListing')

{!! form_start($form) !!}
<div class="container-fluid editor mt--7">
    <div class="row no-gutters">
        
        
        <div class="col-12 col-lg-8">
            <div class="card mb-0 border-0 shadow-none">
                <div class="card-body">
                    {!! form_widget($form->title) !!}
                </div>
            </div>
            // editeur next
            {!! form_widget($form->content) !!}
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    {!! form_widget($form->categories_id) !!}
                    {!! form_widget($form->tags_id) !!}
                    {!! form_widget($form->status_id) !!}
                    {!! form_widget($form->media_id) !!}
                    {!! form_widget($form->no_comments) !!}
                </div>
                <div class="card-footer">
                    {!! form_widget($form->submit) !!}
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

