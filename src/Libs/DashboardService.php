<?php 

namespace Ludows\Adminify\Libs;

class DashboardService {

    private ?array $blocks;
    public function __construct($blocks = []) {
        $this->blocks = $blocks;
    }
    public function getDefaultsBlocks() {
        return [
            'categories' => ['type' => 'card', 'feature' => 'category', 'model' => 'Category', 'singleParam' => 'category'],
            'pages' => ['type' => 'card', 'feature' => 'page', 'model' => 'Page', 'singleParam' => 'page'],
            'posts' => ['type' => 'card', 'feature' => 'post', 'model' => 'Post', 'singleParam' => 'post'],
            'tags' => ['type' => 'card', 'feature' => 'tag', 'model' => 'Tag', 'singleParam' => 'tag'],
            'menus' => ['type' => 'card', 'feature' => 'menu', 'model' => 'Menu', 'singleParam' => 'menu'],
            'traductions' => ['type' => 'card', 'feature' => 'key_translation', 'model' => 'Translations', 'singleParam' => 'traduction'],
            'templates' => ['type' => 'card', 'feature' => 'templates_content', 'model' => 'Templates', 'singleParam' => 'template'],
        ];
    }
    public function getDefaultsBlocDef() {
        return [
            'type' => 'card', 'feature' => null, 'model' => null, 'singleParam' => null,
        ];
    }
    public function registerBlock($name = '', $description = []) {
        $this->blocks[$name] = array_merge($this->getDefaultsBlocDef(), $description);
        return $this;
    }
    public function unregisterBlock($name = '') {
        if(!empty($this->blocks[$name])) {
            unset( $this->blocks[$name] );
        }
        return $this;
    }
    public function getBlocks() {
        return $this->blocks;
    }
    public function query($blocks = []) {
       $dashboard_config = get_site_key('dashboard');
       $multilang = is_multilang();
       $queries = [];
       

       foreach ($blocks as $key => $datas) {
        # code...
            if(!empty($datas['model'])) {
                $model = model( $datas['model'] );

                if($dashboard_config['limit'] > 0) {
                    $model = $model->limit($dashboard_config['limit']);
                }
                if($multilang) {
                    $model = $model->lang( lang() );
                }
                if($dashboard_config['latest']) {
                    $model = $model->latest();
                }
                $queries[$key] = $model->get();

            }
            else {
                $queries[$key] = null;
            }
           
       }
       return $queries;
    } 
    public function load() {
        
        $enabled_features = get_site_key('enables_features');
        $defaults = $this->getDefaultsBlocks();
        $definedBlocks = $this->getBlocks();

        $allBlocks = array_merge($defaults, $definedBlocks);
        $query = $this->query($allBlocks);


        foreach ( $allBlocks as $key => $datas ) {

            $modelName = $datas['model'];

            if(is_collection($query[$key])) {
                $datas['model'] = $query[$key];
            }

            if(!empty($datas['model'])) {
                $datas['labelShow'] = model( $modelName )->searchable_label;
            }

            if(!empty($datas['feature'])) {
                // on active le switch des features
                $featureTest = $datas['feature'];
                if(!empty($enabled_features[$featureTest]) && $enabled_features[$featureTest]) {
                    $this->registerBlock($key, $datas);
                }
            }
            else {
                $this->registerBlock($key, $datas);
            }

        }



        return $this;
    }
}
