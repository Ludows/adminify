<?php

namespace Ludows\Adminify\Libs;

use Closure;
use Inertia\Inertia;
use Exception;

class TableManager
{
    public function __construct()
    {
        $this->view = view();
        $this->datas = [];
        $this->config = config('site-settings.tables');
        $this->request = request();
        $this->model = null;
        $this->results = [];
        $this->columns = [];
        $this->items = [];
        $this->rows = [];
        $this->areas = [
            'top-left' => [],
            'top-right' => [],
            'bottom-left' => [],
            'bottom-right' => []
        ];
        $this->showTitle = true;
        $this->showSearch = true;
        $this->showBtnCreate = true;
        $this->dropdownManager = null;
        $this->_inc_rows = 0;
    }
    public function setColumns($value = []) {
        $this->columns = $value;
        return $this;
    }

    public function setResults($value = []) {
        $this->results = $value;
        return $this;
    }

    public function getDefaultsColumns() {
        return [
            'actions'
        ];
    }

    public function manageColumns() {
        $request = $this->getRequest();
        $model = $this->getModel();
        $fillables = $model->getFillable();

        foreach ($fillables as $key => $fillableValue) {
            # code...
            $fillables[$key] = slug($fillableValue);
        }

        $default_merge_columns = $this->getDefaultsColumns();

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need-translations');
        }

        foreach ($default_merge_columns as $key => $default_merge_column) {
            # code...
            $default_merge_columns[$key] = slug($default_merge_column);
        }

        return array_merge($fillables, $default_merge_columns);
    }

    public function getResults() {
        return $this->results;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getConfig() {
        return $this->config;
    }

    public function getModel() {
        return $this->model;
    }

    public function getModelClass() {
        return '';
    }
    public function getDropdownManagerClass() {
        return '';
    }
    public function hasModel() {
        return !empty($this->model);
    }
    public function setModel($model) {
        $this->model = $model;
        return $this;
    }

    public function module($name, $position, $extraVars) {

        $positions_availables = array_keys($this->areas);

        if(!in_array($position, $positions_availables)) {
            throw new Exception('Positions avalaibles in Table API renderer are : '.join(', ', $positions_availables));
        }

        if(empty($position)) {
            $position = 'top-left';
        }

        if(empty($extraVars)) {
            $extraVars = [];
        }

        $this->setToArea($name, $position, $extraVars);

        return $this;
    }

    public function getDefaultsCells() {
        return [

        ];
    }
    public function templateVarsList() {
        // dd($this->getRequest());
        $r = $this->getRequest();
        $m = $this->getModel();
        $dropdown = !empty($this->getDropdownManagerClass()) ? $this->dropdownManager->getDropdown('dropdown_'.$m->id) : null;

        // dd($this->dropdownManager);
        return [
            'actions' => [
                'dropdown' => !empty($dropdown) ? $dropdown->getItems() : null,
            ],
            'need-translations' => [
                'routes' => get_missing_translations_routes($m),
                'missing' => get_missing_langs($m),
            ]
        ];
    }

    public function getVarsTemplateByName($name) {

        $listing = $this->templateVarsList();

        return !empty($listing[$name]) ? $listing[$name] : [];
    }

    public function setToArea($name = '', $position = 'top-left', $vars = []) {

        $positions_availables = array_keys($this->areas);

        if(!in_array($position, $positions_availables)) {
            throw new Exception('Positions avalaibles in Table API renderer are : '.join(', ', $positions_availables));
        }

        $this->areas[$position][$name] = $vars;

        return $this;

    }

    public function model($model) {
        return $this->setModel($model);
    }

    public function columns($a = []) {
        $this->columns = $a;
        return $this;
    }

    public function datas($name, $value) {
        $this->datas[$name] = $value;
        return $this;
    }

    public function options($array) {
        if(is_array($array)) {
            $array_keys = array_keys($array);
            if(count($array_keys) > 0) {
                foreach ($array_keys as $keyable) {
                    # code...
                    $this->{$keyable} = $array[$keyable];
                }
            }
        }
        return $this;
    }
    public function row($cb = null) {
        $this->rows[$this->_inc_rows] = [];
        if(is_closure($cb)) {
            $cb($this->_inc_rows);
            $this->_inc_rows++;
        }
    } 

    public function column($name, $extraVars = []) {

        $realAttributeName = str_replace('-', '_', $name);
        $m = $this->getModel();
        $isFillableAttr = in_array($realAttributeName, $m->getFillable());
        $formatedColName = slug($name);
        $value = null;

        $default_vars = [
            'is_fillable_attr' => $isFillableAttr,  
            'real_attr' => $realAttributeName, 
            'attr' => $name
        ];

        if(method_exists($this, 'columnValueResolver')) {
            $value = call_user_func_array(array($this, 'columnValueResolver'), $default_vars);
        }

        $default_vars['value'] = $value;

        $this->rows[ $this->_inc_rows ][$formatedColName] = array_merge($extraVars, $default_vars);
        return $this;
    }
    public function getRequest() {
        return $this->request;
    }
    public function getDatas() {
        return $this->datas;
    }
    public function hasDatas() {
        return !empty($this->datas);
    }
    public function getView() {
        return 'adminify::layouts.admin.table.index';
    }

    public function getDefaultCellView() {
        return 'adminify::layouts.admin.table.cell';
    }

    public function getViewList() {
        return 'adminify::layouts.admin.table.datalist';
    }

    public function addVarsToRender() {
        return [];
    }

    public function getAreas() {
        return $this->areas;
    }

    public function handle() {
        $results = $this->getResults();
        $request = $this->getRequest();

        $table = $this;
        $cols = $this->getColumns();

        

        foreach ($results as $result) {
            # code...
            // pass current model
            $this->model($result);
            $this->row(function($row_index) use ($table, $cols) {
                foreach ($cols as $col) {
                    # code...
                    $slugify_col = slug($col);
                    $table->column($col, $this->getVarsTemplateByName($slugify_col));
                }
            });
        }

    }

    public function query() {
        $request = $this->getRequest();
        $datas = $this->getDatas();
        $modelClass = $this->getModelClass();
        $config = $this->getConfig();

        $results = null;

        if(isset($datas['results'])) {
            $results = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $results = $modelClass::lang($request->lang)->paginate($config['limit'], ['*']);
            }
            else {
                $results = $modelClass::paginate($config['limit'], ['*']);
            }
        }

        $results->withPath($request->url());


        $this->setResults($results);

        return $this;
    }

    public function onBeforeQuery() {
    }

    public function onAfterQuery() {
    }

    public function process($isRenderable = true) {

        $dropdownManagerClass = $this->getDropdownManagerClass();
        $modelClass = $this->getModelClass();
        $m = new $modelClass;
        $this->setModel($m);

        $this->onBeforeQuery();
        // perform the query
        $this->query();
        $this->onAfterQuery();

        //bind the dropdown manager
        $models = $this->getResults();
        if(!empty($models)) {
            $this->dropdownManager = new $dropdownManagerClass($models , []);
        }
        // else {
        //     thow new Exception('dropdownManager require all models to work')
        // }

        // create your columns
        $columns = $this->manageColumns();


        $this->columns( $columns );

        if($this->showTitle) {
            $this->module('title', 'top-left', []);
        }

        if(is_trashable_model($m)) {
            $this->module('statuses', 'top-left', [
                'statuses' => model('Statuses')->all(),
            ]);
        }

        if($this->showSearch) {
            $this->module('search', 'top-right', [
                'showSearchBar' => true,
                'showCreate' => $this->showBtnCreate
            ]);
        }


        $this->handle();

        $tpl = $this->getView();
        $cols = $this->getColumns();
        $areas = $this->getAreas();

        // dd('$cols', $cols,  $this->_columns);


        $defaults = [
            'rows' => $this->rows,
            'thead' => $cols,
            'name' => titled( lowercase( class_basename($modelClass) ) ),
            'table' => class_basename($this),
            'areas' => $areas,
            'paginator' => $models,
        ];

        $addtoVars = $this->addVarsToRender();

        $vars = array_merge($defaults, empty($addtoVars) ? [] : $addtoVars);

        if($isRenderable) {
            $returnState = $this->view->make($tpl, $vars);
        }
        else {
            $returnState = $vars;
        }
        
        return $returnState;

    }

    public function render() {
        return $this->process(true);
    }
    // public function list() {
    public function toArray() {
        return $this->process(false);
    }
    public function toJson() {
        return json_encode($this->process(false));
    }
}
