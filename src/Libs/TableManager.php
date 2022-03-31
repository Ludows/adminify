<?php

namespace Ludows\Adminify\Libs;

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
        $this->_columns = [];
        $this->js = [];
        $this->css = [];
        $this->areas = [
            'top-left' => [],
            'top-right' => [],
            'bottom-left' => [],
            'bottom-right' => []
        ];
        $this->showTitle = true;
        $this->showSearch = true;
        $this->showBtnCreate = true;
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

        $default_merge_columns = $this->getDefaultsColumns();

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
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

    public function module($name, $position, $viewName, $extraVars) {

        $positions_availables = array_keys($this->areas);

        if(!in_array($position, $positions_availables)) {
            throw new Exception('Positions avalaibles in Table API renderer are : '.join(', ', $positions_availables));
        }

        if(empty($viewName)) {
            throw new Exception('You must specify view path for your module :)');
        }

        if(empty($position)) {
            $position = 'top-left';
        }

        if(empty($extraVars)) {
            $extraVars = [];
        }

        $this->setToArea($name, $position, view($viewName, $extraVars));

        return $this;
    }

    public function getTemplateByName($name) {
        $default_view = $this->getDefaultCellView();

        $viewExist = $this->view->exists('adminify::layouts.admin.table.custom-cells.'.$name);

        if($viewExist) {
            $default_view = 'adminify::layouts.admin.table.custom-cells.'.$name;
        }
        return $default_view;
    }

    public function templateVarsList() {
        return [];
    }

    public function getVarsTemplateByName($name) {

        $listing = $this->templateVarsList();

        return !empty($listing[$name]) ? $listing[$name] : [];
    }

    public function setToArea($name, $position, $view) {

        $positions_availables = array_keys($this->areas);

        if(!in_array($position, $positions_availables)) {
            throw new Exception('Positions avalaibles in Table API renderer are : '.join(', ', $positions_availables));
        }

        $this->areas[$position][$name] = $view;

        return $this;

    }

    public function model($model) {
        return $this->setModel($model);
    }

    public function columns($a = []) {
        $this->columns = $a;

        foreach ($a as $col) {
            # code...
            $this->_columns[$col] = [];
        }

        return $this;
    }

    public function datas($name, $value) {
        $this->datas[$name] = $value;
        return $this;
    }

    public function js($jsPath) {
        $this->js[] = $jsPath;
        return $this;
    }

    public function css($cssPath) {
        $this->css[] = $cssPath;
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

    public function column($name, $viewName, $extraVars = []) {

        $v = $viewName;
        if(empty($viewName)) {
            $v = $this->getDefaultCellView();
        }

        $formatedColName = slug($name);

        if(array_key_exists($formatedColName, $this->_columns)) {
            throw new Exception($formatedColName.' already exist..');
        }

        $this->_columns[ $formatedColName ][] = (object) [
            'view' => $v,
            'vars' => array_merge($extraVars, ['model' => $this->getModel(), 'attr' => $name]),
        ];
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

    public function getJs() {
        return $this->js;
    }

    public function getCss() {
        return $this->css;
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
        $dropdownManagerClass = $this->getDropdownManagerClass();
        $table = $this;
        $cols = $this->getColumns();

        $a = new $dropdownManagerClass($results, []);

        foreach ($results as $result) {
            # code...
            // pass current model
            $this->model($result);
            foreach ($cols as $col) {
                # code...
                $table->column($col, $this->getTemplateByName($col),  $this->getVarsTemplateByName($col));
            }
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
                $results = $modelClass::limit( $config['limit'] )->lang($request->lang)->get();
            }
            else {
                $results = $modelClass::limit( $config['limit'] )->get();
            }
        }

        $this->setResults($results);

        return $this;
    }

    public function render() {

        $modelClass = $this->getModelClass();
        $m = new $modelClass;
        $this->setModel($m);

        // perform the query
        $this->query();

        // create your columns
        $columns = $this->manageColumns();

        $this->columns( $columns );

        if($this->showTitle) {
            $this->module('title', 'top-left', 'adminify::layouts.admin.table.core.title', []);
        }

        if(is_trashable_model($m)) {
            $this->module('statuses', 'top-left', 'adminify::layouts.admin.table.core.statuses', [
                'statuses' => model('Statuses')->all(),
            ]);
        }

        if($this->showSearch) {
            $this->module('search', 'top-right', 'adminify::layouts.admin.table.core.search', [
                'showSearchBar' => true,
                'showCreate' => $this->showBtnCreate
            ]);
        }



        $this->handle();

        $tpl = $this->getView();
        $cols = $this->getColumns();
        $areas = $this->getAreas();
        $count = null;

        // dd('$cols', $cols,  $this->_columns);


        if(!empty($modelClass)) {
            $classModel = new $modelClass;
            $count = $classModel->count();
        }


        $defaults = [
            'datas' => $this->_columns,
            'thead' => $cols,
            'total' => $count,
            'count' => count($this->_columns[$cols[0]]),
            'css' => $this->getCss(),
            'js' => $this->getJs(),
            'name' => titled( lowercase( class_basename($classModel) ) ),
            'table' => titled( lowercase( class_basename($this) ) ),
            'areas' => $areas
        ];



        $addtoVars = $this->addVarsToRender();

        // dd(array_merge($defaults, empty($addtoVars) ? [] : $addtoVars));

        $compiled = $this->view->make($tpl, array_merge($defaults, empty($addtoVars) ? [] : $addtoVars));
        return $compiled;
    }
    public function list() {

        $modelClass = $this->getModelClass();
        $m = new $modelClass;
        $this->setModel($m);
        // perform the query
        $this->query();

        // create your columns
        $columns = $this->manageColumns();

        $this->columns( $columns );

        $this->handle();

        $cols = $this->getColumns();
        $addtoVars = $this->addVarsToRender();

        $name = $this->getRequest()->route()->getName();
        $name = str_replace('.index', '', $name);

        $defaults = [
            'datas' => $this->_columns,
            'thead' => $cols,
            'count' => count($this->_columns[$cols[0]]),
            'name' => titled( lowercase( class_basename($modelClass) ) )
        ];

        $compiled = $this->view->make( $this->getViewList() , array_merge($defaults, empty($addtoVars) ? [] : $addtoVars) );
        return $compiled;
    }
}
