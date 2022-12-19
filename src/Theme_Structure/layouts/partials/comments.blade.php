@php
  $uuid = uuid(15); 
@endphp

@if ($root_level)
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($showTitle)
                        <div class="card-header">
                            
                        </div>
                    @endif
                    
                    <div class="card-body">
@endif
                    <div class="comment_list comment-list-{{ $uuid }}">
                        @foreach ($comments as $comment)
                            <div id="comment_{{ $uuid }}_{{ $comment->id }}">{!! $comment->comment !!}</div>
                            @includeWhen($allow_form, 'theme::'. $theme .'.layouts.partials.comment_form', [
                                'model' => $comment,
                                'lang' => $lang,
                                'parent_id' => $comment->parent_id,
                                'user' => $user,
                                'update' => true,
                                'uuid' => $uuid
                            ])

                            @if($user->id === $comment->user_id)
                                <div  class="update-btns updates-btn-{{ $uuid }}">
                                    <a href="#" data-component=".respond-comment-form.component-{{ $uuid }}" class="btn js-respond-form btn-default">{!! __('adminify.comment_form_respond') !!}</a>
                                    <a href="#" data-component=".update-comment-form.component-{{ $uuid }}" class="btn js-modify-form btn-warning">{!! __('adminify.comment_form_modify') !!}</a>
                                    <a href="#" class="btn js-delete-form btn-danger">{!! __('adminify.comment_form_delete') !!}</a>
                                </div>
                            @endif

                            @includeWhen($allow_form, 'theme::'. $theme .'.layouts.partials.comment_form', [
                                'model' => $comment,
                                'lang' => $lang,
                                'parent_id' => $comment->parent_id,
                                'user' => $user,
                                'respond' => true,
                                'uuid' => $uuid
                            ])

                            @includeWhen($allow_form, 'theme::'. $theme .'.layouts.partials.comments', [
                                'model_class' => get_class($model),
                                'multilang' => is_multilang(),
                                'show_title' => false,
                                'lang' => lang(),
                                'post_id' => $comment->id,
                                'allow_form' => $allowForm,
                                'user' => $user,
                                'comments' => $comment->childs ?? [],
                                'root_level' => false,
                            ])
                        @endforeach
                    </div>


                    @includeWhen($allow_form && $root_level, 'theme::'. $theme .'.layouts.partials.comment_form', [
                        'model' => $model,
                        'parent_id' => 0,
                        'user' => $user
                    ])
@if ($root_level)

                </div>
            </div>
        </div>
    </div>
</div>
@endif 
