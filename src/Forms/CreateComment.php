<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

use App\Adminify\Models\Comment;
// use App\Adminify\Models\Post;

class CreateComment extends BaseForm
{
    public function buildForm()
    {
        $u = user();
        $r = $u->hasRole(['editor', 'administrator', 'subscriber']);
        $m = $this->getModel();
        $req = $this->getRequest();

        $this->addUserId('user_id', [
            'label_show' => false
        ]);

        $boundedModel = $req->isEdit ? new $m->model_class : null;
        $queryComments = null;

        if($req->isEdit) {
            $queryComments = Comment::where('id', '!=', $m->id)->get();
        }
        else {
            $queryComments = Comment::all();
        }

        $queryComments = $queryComments->pluck('comment', 'id')->toArray();
        $no_parents = [
            0 => __('adminify.no_parent')
        ];

        $queryComments = $no_parents + $queryComments;
        
        $this->addSelect2('model_class', [
            'label' => __('admin.form.model_class'),
            'choices' => get_content_types(),
            'selected' => !empty($boundedModel) ? class_basename( $m->model_class ) : '',
            'attr' => [
                'disabled' => $req->isEdit
            ],
            'select2options' => [
                'placeholder' => __('admin.form.select_model_class'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->addSelect2('model_id', [
            'empty_value' => '',
            'withCreate' => false,
            'attr' => [
                'disabled' => $req->isEdit
            ],
            'label' => __('admin.form.post_id'),
            'choices' => !empty($boundedModel) ? $boundedModel->all()->pluck($boundedModel->searchable_label, 'id')->toArray() : [],
            'selected' => !empty($boundedModel) ? $boundedModel->find((int) $m->model_id)->id : '',
            'select2options' => [
                'placeholder' => __('admin.select_post'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->addSelect2('parent_id', [
            'empty_value' => '',
            'attr' => [
                'disabled' => $req->isEdit
            ],
            'withCreate' => false,
            'label' => __('admin.form.parent_comment_id'),
            'choices' => $queryComments,
            'selected' => !empty($boundedModel) ? $m->parent_id : '',
            'select2options' => [
                'placeholder' => __('admin.form.select_parent_comment_id'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->addJodit('comment', [
            'label' => __('admin.form.comment'),
        ]);

        $this->add('is_moderated', Field::CHECKBOX, [
            'value' => $req->isEdit ? $m->is_moderated : $r,
            'checked' => $req->isEdit ? $m->is_moderated : $r,
            'label' => __('admin.form.is_moderated'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ]);

        $this->addSubmit();
    }
}
