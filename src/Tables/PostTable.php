<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Post as PostModel;
use Ludows\Adminify\Dropdowns\Post as PostDropdownsManager;

use App\Models\Statuses;


class PostTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'categories_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.posts-categories-id';
                break;
            case 'media_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.posts-media-id';
                break;
            case 'user_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.user-id';
                break;
            case 'status_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.status-id';
                break;
            case 'content':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.posts-content';
                break;
            case 'parent_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.posts-parent-id';
                break;
        }

        return $ret;
    }
    public function handle() {

        $config = config('site-settings.listings');
        $request = $this->getRequest();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $posts = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $posts = PostModel::limit( $config['limit'] )->status(Statuses::TRASHED_ID, '!=')->lang($request->lang)->get();
                // dd($categories);
            }
            else {
                $posts = PostModel::limit( $config['limit'] )->status(Statuses::TRASHED_ID, '!=')->get();
            }
        }
            $model = new PostModel();
            $fillables = $model->getFillable();

            $a = new PostDropdownsManager($posts, []);

            // if(isset($posts) && count($posts) > 0) {
            //     $posts[0]->flashForMissing();
            // }

            $default_merge_columns = ['categories_id','actions'];

            if($request->useMultilang && is_translatable_model($model)) {
                array_unshift($default_merge_columns, 'need_translations');
            }

            $this->columns( array_merge($fillables, $default_merge_columns) );

            $this->module('statuses', 'top-left', 'adminify::layouts.admin.table.core.statuses', [
                'statuses' => Statuses::all()->all()
            ]);


        foreach ($posts as $post) {
            # code...
            // pass current model
            $table = $this->model($post);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }

            if($request->useMultilang && is_translatable_model($model)) {
                $table->column('need_translations', 'adminify::layouts.admin.table.custom-cells.translated', [
                    'routes' => get_missing_translations_routes('savetraductions.edit', 'savetraduction', $this->getModel()),
                    'missing' => get_missing_langs($this->getModel()),
                ]);
            }

            $table->column('categories_id', 'adminify::layouts.admin.table.custom-cells.posts-categories-id', []);

            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $post->id
            ]);
        }


    }
}
