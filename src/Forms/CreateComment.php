<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

use App\Adminify\Models\Comment;
use App\Adminify\Models\Post;

class CreateComment extends Form
{
    public function buildForm()
    {
        $c = $this->getComments();
        $p = $this->getPosts();
        $u = user();
        $r = $u->hasRole(['editor', 'administrator', 'subscriber']);
        
        $this->add('user_id', 'hidden', [
            'label_show' => false
        ]);
        $this->add('model_class', 'hidden', [
            'label_show' => false
        ]);
        $this->add('post_id', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'choices' => $p['posts'],
            'selected' => $p['selected'],
            'label' => __('admin.form.post_id'),
            'select2options' => [
                'placeholder' => __('admin.select_post'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);
        $this->add('parent_id', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'choices' => $c['comments'],
            'selected' => $c['selected'],
            'label' => __('admin.form.parent_comment_id'),
            'select2options' => [
                'placeholder' => __('admin.form.select_parent_comment_id'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);
        $this->add('comment', 'tiptap', [
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
        
        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
    public function getComments() {
        $comments = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $comments = Comment::get()->pluck('comment' ,'id');
        $selecteds = '';

        if(isset($hasModel->parent_id) && $hasModel->parent_id != 0) {
            // on a une selection
            $selecteds = $hasModel->parent_id;
        }

        return [ 'comments' => $comments->all(), 'selected' => $selecteds];
    }
    public function getPosts() {
        $posts = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $posts = Post::get()->pluck('title' ,'id');
        $selecteds = '';

        if(isset($hasModel->post_id) && $hasModel->post_id != null) {
            // on a une selection
            $selecteds = $hasModel->post_id;
        }

        return [ 'posts' => $posts->all(), 'selected' => $selecteds];
    }
}
