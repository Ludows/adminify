<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Post as PostModel;
use Ludows\Adminify\Dropdowns\Post as PostDropdownsManager;

class PostTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'avatar':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.users-avatar';
                break;
            case 'email':
            case 'name':
                # code...
                $ret = 'adminify::layouts.admin.table.cell';
                break;
            case 'password':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.users-password';
                break;
        }

        return $ret;
    }
    public function handle() {

        $config = config('site-settings.listings');
        $request = $this->getRequest();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $posts = $datas;
        }
        else {
            if($request->useMultilang) {
                $posts = PostModel::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
            }
            else {
                $posts = PostModel::limit( $config['limit'] )->get();
            }
        }
            $model = new PostModel();
            $fillables = $model->getFillable();

            $a = new PostDropdownsManager($posts, []);

            if(isset($posts) && count($posts) > 0) {
                $posts[0]->flashForMissing();
            }

        // set columns
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($posts as $post) {
            # code...
            // pass current model
            $table = $this->model($post);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $post->id
            ]);
        }


    }
}
