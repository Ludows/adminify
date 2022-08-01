<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

// use App\Adminify\Models\Comment;
// use App\Adminify\Models\Post;

class CreateComment extends BaseForm
{
    public function buildForm()
    {
        $u = user();
        $r = $u->hasRole(['editor', 'administrator', 'subscriber']);

        $this->addUserId('user_id', [
            'label_show' => false
        ]);

        $this->add('model_class', 'hidden', [
            'label_show' => false
        ]);

        $this->addPosts('post_id', [
            'empty_value' => '',
            'withCreate' => false,
            'label' => __('admin.form.post_id'),
            'select2options' => [
                'placeholder' => __('admin.select_post'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->addPosts('parent_id', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'label' => __('admin.form.parent_comment_id'),
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
            'value' => $r,
            'checked' => $r,
            'label' => __('admin.form.is_moderated'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ]);

        $this->addSubmit();
    }
}
