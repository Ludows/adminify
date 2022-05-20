<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;

class ContentTypesHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed
        $model = $datas;
        $allowed_hooks = ['creating', 'created', 'updating', 'updated'];
        $only_for_deleting = ['deleting'];


        if(!empty($model) && in_array($hookName, $allowed_hooks)) {
            $isContentType = is_content_type_model($model);
            if($isContentType && $model->allowSitemap) {
                $this->syncronizeUrl($model);

                if($hookName == 'updating') {
                    $this->syncOnUpdating($model);
                }

                $this->syncToCache($model);
            }

            if($isContentType && $model->allowSitemap) {
                $this->loadGenerateSitemap($model);
            }
        }

        if(!empty($model) && in_array($hookName, $only_for_deleting)) {
            $isContentType = is_content_type_model($model);
            $this->syncToCache($model, true);
            if($isContentType && $model->allowSitemap) {
                $this->syncronizeUrl($model, true);
            }
            if($isContentType && $model->allowSitemap) {
                $this->loadGenerateSitemap($model);
            }
        }

    }
    public function syncronizeUrl($context, $delete = false) {
        return $delete == false ? $this->walkThroughtParents($context, $context->id, $context->id) : $context->deleteUrl([], true);
    }
    public function walkThroughtParents($context, $from = null,  $baseOrder = 1) {
        $parentable = $context->parent_id;
        //dump($parentable);
        $reflect = new \ReflectionClass($context);

        $isHomePage = is_homepage($context);
        $isBlogPage = is_blogpage($context);

        if(!empty($parentable) && $parentable != 0) {
            $context->syncUrl([
                'from_model_id' => $from,
                'model_id' => $context->id,
                'model_name' => $reflect->name,
                'order' => $baseOrder,
                'is_homepage' => $isHomePage,
                'is_blogpage' => $isBlogPage
            ]);
            //access to parent
            $parent = $context->getParent($parentable);

            $this->walkThroughtParents($parent, $from,  $parent->id);
        }
        else {
            // it's the root path of your url
            $context->syncUrl([
                'from_model_id' => $from,
                'model_name' => $reflect->name,
                'order' => 0,
                'is_homepage' => $isHomePage,
                'is_blogpage' => $isBlogPage
            ]);
        }
    }
    public function syncOnUpdating($context) {
        $isHomePage = is_homepage($context);
        $url = $context->originalurl;
        if($url != null) {
            $context->forgetToCache( $isHomePage ? 'homepage' : join('.', $url ));
        }
    }
    public function syncToCache($context, $delete = false) {
        $url = $context->url;
        if($url != null) {

            $isHomePage = is_homepage($context);

            $delete == false ? $context->encryptToCache( $isHomePage ? 'homepage' : join('.', $url) ) : $context->forgetToCache( $isHomePage ? 'homepage' : join('.', $url ));
        }
    }

    public function loadGenerateSitemap($context) {
        $s = app()->make('Ludows\Adminify\Libs\SitemapRender');

        $reflect = new \ReflectionClass($context);
        $cls = adminify_get_class(class_basename($reflect->name), ['app:adminify:models', 'app:models'], false);

        // dd($cls, $reflect);

        $s->setOptions([
            'models' => [$context->getTable() => $cls],
            'modelName' => $context->getTable(),
            'writeFile' => true,
        ]);
        $s->render();
    }
}
