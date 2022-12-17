@php
    $revisions = $model->revisions ?? collect([]);
@endphp
@if($revisions->count() > 0)
    <div id="Revisions_blck" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('adminify.revsisions.title') }}</h5>
                        <div id="rev_wrapper">
                            @foreach ($revisions as $revision)
                                <div id="block-rev-{{ $revision->id }}" class="row no-gutters align-items-end border-bottom border-light py-3">
                                    <div class="col-12 col-lg-6">
                                        {{ __('adminify.revsisions.label') }} {!! $loop->index + 1 !!}
                                    </div>
                                    <div class="col-12 col-lg-6 text-right">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-default mr-3" data-toggle="modal" data-target="#modal-revisions-{{ $revision->id }}">{{ __('adminify.revsisions.show') }}</button>
                                            <button type="button" data-revision-id="{{ $revision->id }}" data-selector="#block-rev-{{ $revision->id }}" data-model="{{ $revision->data }}" class="btn js-restore-revision btn-default">{{ __('adminify.revsisions.restore') }}</button>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $format_current = format_revision($revision->data);
                                @endphp

                                @push('modales')
                                    @include('adminify::components.modal', [
                                        'title' => __('adminify.revsisions.modal_title'),
                                        'id' => 'modal-revisions-'.$revision->id,
                                        'slot' => $format_current,
                                        'modalBodyClass' => 'pt-0'
                                    ])
                                @endpush
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script>
            jQuery(function() {
                jQuery(document).on('click', '.js-restore-revision', function(e) {
                    e.preventDefault();
                    let modl = JSON.parse($(this).attr('data-model'));
                    let sel = $(this).attr('data-selector');
                    let revId = $(this).attr('data-revision-id');
                    console.log(modl)

                    let question = new Swal({
                        title : "{{ __('adminify.revsisions.restore_title') }}",
                    }).then((resp) => {
                        console.log('resp', resp);

                        if(resp.isConfirmed) {
                            $.ajax({
                                'type': 'PUT',
                                'url' : Route( '{{ lowercase( plural($request->type) ) }}.update' , {
                                    '{{ lowercase( singular($request->type) ) }}' : {{ $request->model->id }},
                                }),
                                'data' : modl,
                                'headers': {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data) {

                                    $(sel).remove();

                                    let wrap = $('#rev_wrapper');

                                    if(wrap.children().length == 0) {
                                        $('#Revisions_blck').remove();
                                    }

                                    window.location.reload();
                                }
                            })
                        }

                    })


                })
            })
        </script>

    @endpush

@endif

