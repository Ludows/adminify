<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;

class ContentTypesHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed
        $model = $datas;

        if($model != null) {
            if(is_urlable_model($model) && $model->allowSitemap) {
                $this->syncronizeUrl($model);
                $this->syncToCache($model);
            }
    
            if(is_sitemapable_model($model) && $model->allowSitemap) {
                $this->loadGenerateSitemap($model);
            }
        }

    }
    public function syncronizeUrl($context) {
        return $this->walkThroughtParents($context, $context->id, $context->id);
    }
    public function walkThroughtParents($context, $from = null,  $baseOrder = 1) {
        $parentable = $context->parent_id;
        //dump($parentable);
        $reflect = new \ReflectionClass($context);
        $checkHomePage = setting('homepage');
        $checkBlogPage = setting('blogpage');

        $isHomePage = $checkHomePage != null && $context->id == (int) $checkHomePage;
        $isBlogPage = $checkBlogPage != null && $context->id == (int) $checkBlogPage;

        if(isset($parentable) && $parentable != 0) {
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
    public function syncToCache($context) {
        $url = $context->url;
        if($url != null) {

            $isHomePage = is_homepage($context);

            $context->encryptToCache( $isHomePage ? 'homepage' : join('.', $url) );
        }
    }
    
    public function loadGenerateSitemap($context) {
        $s = app()->make('Ludows\Adminify\Libs\SitemapRender');
        $s->setOptions([
            'models' => [$context->getTable() => 'register.'.$context->getTable()],
            'modelName' => $context->getTable(),
            'writeFile' => true,
        ]);
        $s->render();
    }
}