<?php

namespace Ludows\Adminify\Traits;


trait HasAppendables
  {
    public function shouldAppendAs($name = '', $attrName = '') {
        $filables = $this->getFillable();

        if(in_array($name, $filables)) {
            $this->appends[] = $attrName;
        }
    }
    public function addAppends($array = []) {
        if(is_array($array)) {
            foreach ($array as $key => $value) {
                # code...
                $this->addAppend($value);
            }
        }
    }
    public function appendWhen($attrName = '', $fn) {
        $isClosure = is_closure($fn);
        if($isClosure) {
            $result = call_user_func_array(array($this, $fn), [
                $attrName
            ]);

            if($result) {
                $this->addAppend($attrName);
            }
        }
    }
    public function addAppend($name = '') {
        $this->appends[] = $name;
        return $this;
    }
  }
