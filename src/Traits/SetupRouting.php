<?php

  namespace Ludows\Adminify\Traits;
  use Illuminate\Http\Request;
  use Illuminate\Foundation\Http\FormRequest; 

  trait SetupRouting
  {
     //

     public function theModel() {
        return null;
     }
     public function theRepository() {
        return null;
     }
     public function theTable() {
        return null;
     }
     public function createForm() {
        return null;
     }
     public function updateForm() {
        return null;
     }
     public function createFormRequest() {
        return null;
     }
     public function updateFormRequest() {
        return null;
     }

    public function index() {
        $class = get_class($this);
        return app()->call($class.'@'.'showIndexPage', [], 'defaultShowIndexPage');
    }
    public function create() {
        $class = get_class($this);
        return app()->call($class.'@'.'showCreatePage', [], 'defaultShowCreatePage');
    }
    public function store() {
        $class = get_class($this);
        return app()->call($class.'@'.'handleStore', [], 'defaultHandleStore');
    }
    public function show(Request $request) {
        $class = get_class($this);
        return app()->call($class.'@'.'showPage', [], 'defaultShowPage');
    }
    public function edit() {
        $class = get_class($this);
        return app()->call($class.'@'.'showEditPage', [], 'defaultShowEditPage');
    }
    public function update() {
        $class = get_class($this);
        return app()->call($class.'@'.'handleUpdate', [], 'defaultHandleUpdate');
    }
    public function destroy() {
        $class = get_class($this);
         return app()->call($class.'@'.'handleDestroy', [], 'defaultHandleDestroy');
    }

     public function defaultShowIndexPage() {
          $table = $this->table( $this->theTable() );

          $views = $this->getPossiblesViews('Index');

          // dd($table->toArray());

          return $this->renderView($views, [
               'model' => (object) [],
               'table' => $table->toArray()
          ]);
     }

      /**
            * Store a newly created resource in storage.
            *
            * @return Response
            */
            public function defaultHandleStore(Request $request)
            {
                $createFormRequest = $this->createFormRequest();

                $errors = $this->performValidate($request, new $createFormRequest);

                if(!empty($errors)) {
                    return $errors;
                }

                $baseClass = lowercase( class_basename($Ressource) );
                $plural = plural($baseClass);

                // we pass context and request
                $form = $this->makeForm( $this->createForm() );
                
    
                $category = $this->theRepository()->addModel($this->theModel())->create($form);
    
                return $this->toJson([
                    'message' => __('admin.typed_data.success'),
                    'entity' => $category,
                    'route' => 'admin.'. $plural .'.index'
                ]);
            }
    
            /**
                * Display the specified resource.
                *
                * @param  int  $id
                * @return Response
                */
            public function defaultShowPage($id)
            {}
    
            /**
                * Show the form for editing the specified resource.
                *
                * @param  int  $id
                * @return Response
                */
            public function defaultShowEditPage($resource_id)
            {
                $model = $this->theModel();
                $Ressource = $model->findOrFail($resource_id);
                
                if(method_exists($Ressource, 'checkForTraduction')) {
                    $Ressource->checkForTraduction();
                }

                $baseClass = lowercase( class_basename($Ressource) );
                $singular = singular($baseClass);
                $plural = plural($baseClass);
                // $category->flashForMissing();
    
                $form = $this->makeForm($this->updateForm(), [
                    'method' => 'PUT',
                    'url' => route('admin.'. $plural .'.update', [$singular => $resource_id]),
                    'model' => $Ressource
                ]);
    
                $views = $this->getPossiblesViews('Edit');
    
                return $this->renderView($views, [
                    'model' => $Ressource,
                    'form' => $form->toArray()
                ]);
    
            }

            public function performValidate(Request $request, FormRequest $formRequest) {
                $validator = Validator::make($request->all(), ($formRequest)->validation()->rules()); 
                $return = null;
                
                if($validator->fails()) {
                    if($request->ajax()) {
                        $return = response()->json($validator->messages(), 422);
                    }
                    $return = redirect()->back()->withErrors($validator)->withInput();
                }

                return $return;
            }
    
            /**
                * Update the specified resource in storage.
                *
                * @param  int  $id
                * @return Response
                */
            public function defaultHandleUpdate($resource_id, Request $request)
            {
                //
                $model = $this->theModel();
                $Ressource = $model->findOrFail($resource_id);

                $updateFormRequest = $this->updateFormRequest();

                $errors = $this->performValidate($request, new $updateFormRequest);

                if(!empty($errors)) {
                    return $errors;
                }

                $baseClass = lowercase( class_basename($Ressource) );
                $singular = singular($baseClass);
                $plural = plural($baseClass);
    
                $form = $this->makeForm($this->updateForm(), [
                    'method' => 'PUT',
                    'url' => route('admin.'. $plural .'.update', [$singular => $resource_id]),
                    'model' => $Ressource
                ]);
    
                $this->theRepository()->addModel($Ressource)->update($form, $Ressource);
    
                return $this->toJson([
                    'message' => __('admin.typed_data.success'),
                    'entity' => $Ressource,
                    'route' => 'admin.'. $plural .'.index'
                ]);
                // flash(__('admin.typed_data.updated'))->success();
                // return redirect()->route('categories.index');
            }
    
            /**
                * Remove the specified resource from storage.
                *
                * @param  int  $id
                * @return Response
                */
            public function defaultHandleDestroy($resource_id)
            {
                $model = $this->theModel();
                $Ressource = $model->findOrFail($resource_id);

                $baseClass = lowercase( class_basename($Ressource) );
                $plural = plural($baseClass);
                //
                $this->theRepository()->addModel($Ressource)->delete($Ressource);
    
                //redirect
                return $this->toJson([
                    'message' => __('admin.typed_data.deleted'),
                    'entity' => $Ressource,
                    'route' => 'admin.'. $plural .'.index'
                ]);
            }
  }