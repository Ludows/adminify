<?php

namespace Ludows\Adminify\Hooks;

use Ludows\Adminify\Libs\HookInterface;

class OnUpdatingHook extends HookInterface {
    public function handle($hookName,$datas = null) {
        //data is the model passed
        $model = $datas;

        $isContentType = is_content_type_model($model);
        if($isContentType && property_exists($model, 'allowSitemap')) {
            $this->syncOnUpdating($model);
        }

    }
    public function syncOnUpdating($context) {
        $isHomePage = is_homepage($context);
        $url = $context->originalurl;
        if($url != null) {
            $context->forgetToCache( $isHomePage ? 'homepage' : join('.', $url ));
        }
    }
}
