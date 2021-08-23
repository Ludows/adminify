<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Menu;
use App\Models\Media;
use App\Models\MenuItem; // Don't forget to update the model's namespace

use  Ludows\Adminify\Repositories\BaseRepository;

class MenuRepository extends BaseRepository
{
    protected function createEntity($entity, $formValues) {
        return $this->getProcessDb($formValues, $this->model ?? $entity, ['model:creating', 'model:created'], 'create');
    }
    protected function Walker($scope, $exist, $model, $parent_id, $isChild) {
        $request = request();
        $config = config('site-settings');
        $multilang = $request->useMultilang;

        if(is_null($scope)) {
            return false;
        }

        foreach ($scope as $menuitem) {
            # code...
            $menuItem = new MenuItem();
            // dump($menuitem['type']);
            if($menuitem == null) {
                // quick fix en attendant de regarder la generation du menu three
                return false;
            }

            $class_model_str = $config['menu-builder']['models'][$menuitem['type']];
            $class_model_str = get_site_key($class_model_str);

                $check_model_item = null;

                if(isset($menuitem['menu-item-id']) && $menuitem['menu-item-id'] != null) {
                    //on sait que c'est l'id du menu items
                    $check_model_item = new MenuItem();
                    $check_model_item = $check_model_item::find($menuitem['menu-item-id']);
                }

                $menuItem->model = $class_model_str;
                $check_model = new $class_model_str;

                if(isset($menuitem['id'])) {
                    // on sait que c'est une data qui provient de la base.
                    // seul le bloc custom n'a pas d'Id a sa création.
                    $menuItem->model_id = $menuitem['id'];
                    $check_model = $check_model::find($menuitem['id']);
                }
                else {

                    // Nous sasvons ici que la valeur n'est pas dans la bdd alors nous la créons.
                    $related_model = new $class_model_str;
                    $entity = $this->createEntity($related_model, $menuitem);
                    $menuItem->model_id = $entity->id;
                    $check_model = $entity;
                }

                if(isset($menuitem['type']) && strlen($menuitem['type']) > 0) {
                    $menuItem->type = $menuitem['type'];
                }

                if(isset($menuitem['overwrite_title']) && strlen($menuitem['overwrite_title']) > 0) {
                    if($multilang) {
                        $menuItem->overwrite_title = null;
                        $menuItem->setTranslation('overwrite_title', $request->lang , $menuitem['overwrite_title']);
                    }
                    else {
                        $menuItem->overwrite_title = $menuitem['overwrite_title'];
                    }
                }
                else {
                    $menuItem->overwrite_title = null;
                }

                if(isset($menuitem['media_id']) && strlen($menuitem['media_id']) > 0) {
                    $json = json_decode($menuitem['media_id']);

                    $m = Media::where('src', $json[0]->name)->first();

                    if($m != null) {
                        $menuItem->media_id = $m->id;
                    }
                    
                }

                if(isset($menuitem['class']) && strlen($menuitem['class']) > 0) {
                    $menuItem->class = $menuitem['class'];
                }

                if(isset($menuitem['open_new_tab']) && (int) $menuitem['open_new_tab'] == 1) {
                    $menuItem->open_new_tab = true;
                }
                else {
                    $menuItem->open_new_tab = false;
                }




                if($check_model_item != null) {
                    // dd($check_model_item->getFillable());
                    if($isChild) {
                        $check_model_item->parent_id = $parent_id;
                    }

                    $arr = [];
                    $fillables = $check_model_item->getFillable();
                    $attributes = $menuItem->getAttributes();
                    foreach ($fillables as $fillable) {
                        # code...
                        if(isset($attributes[$fillable])) {
                            $arr[$fillable] = $attributes[$fillable];
                        }
                    }
                    // dd($menuItem);
                    // on sait ici que c'est plus un update à gérer.
                    $check_model_item->fill( $arr );
                    $check_model_item->save();
                }
                else {
                    if($isChild) {
                        $menuItem->parent_id = $parent_id;
                    }

                    $menuItem->save();
                }

                if($isChild) {
                    $menuItem->id != null ? $menuItem->parent_id = $parent_id : $check_model_item->parent_id = $parent_id;
                }

                if(isset($menuitem['childs']) && count($menuitem['childs']) > 0) {
                    $this->Walker($menuitem['childs'], $exist, $model, $menuItem->id != null ? $menuItem->id : $check_model_item->id, true);
                }





                if($check_model_item != null) {
                    $check_model_item->menu()->attach($check_model_item->id, ['menu_id' => $model->id]);
                }
                else {
                    $menuItem->menu()->attach($menuItem->id, ['menu_id' => $model->id]);
                }

        }
    }
    public function create($mixed) {
        return $this->getProcessDb($mixed, $this->model ?? null, ['menu:creating', 'menu:created'], 'create');
    }
    public function update($menuthree, $model) {
        
        $this->hookManager->run('updating:menu', $this->model ?? $model);
        $existingItems = count($model->items->all()) > 0 ? true : false;

        if($existingItems) {
            $model->items()->detach();
        }

        $this->Walker($menuthree, $existingItems , $model, 0, false);
        
        $this->hookManager->run('updated:menu', $this->model ?? $model);
        return $model;

    }
    public function delete($model) {
        $this->hookManager->run('deleting:menu', $this->model ?? $model);
        $items = $model->items->all();
        if(count($items) > 0) {

            foreach ($items as $item) {
                # code...
                if($item->type == 'custom') {
                    $item->related->delete();
                }
            }

            $model->items()->detach();

        }
        $model->delete();
        $this->hookManager->run('deleted:menu', $this->model ?? $model);
        return $model;
    }
}
