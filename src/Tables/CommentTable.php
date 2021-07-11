<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Comment as CommentModel;
use Ludows\Adminify\Dropdowns\Comment as CommentDropdownsManager;

class CommentTable extends TableManager {
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
            $comments = $datas;
        }
        else {
            if($request->useMultilang) {
                $comments = CommentModel::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
            }
            else {
                $comments = CommentModel::limit( $config['limit'] )->get();
            }
        }

            
            $model = new CommentModel();
            $fillables = $model->getFillable();

            $a = new CommentModel($comments, []);
        // set columns
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($comments as $comment) {
            # code...
            // pass current model
            $table = $this->model($comment);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $comment->id
            ]);
        }


    }
}
