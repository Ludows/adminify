<?php

namespace Ludows\Adminify\Traits;
  use Illuminate\Support\Arr;


  trait MultilangTranslatableSwitch
  {
    public $translatable;
    public $neededTranslations = [];
    public function __construct() {
        $multilang = config('site-settings.multilang');
        $this->translatable = $multilang && isset($this->MultilangTranslatableSwitch) ? $this->MultilangTranslatableSwitch : [];
    }
    public function scopeLang($query, $lang = 'fr', $localField = '') {

        if($localField == '') {
            $localField = $this->MultilangTranslatableSwitch[0];
        }

        return $query->whereNotNull($localField.'->'.$lang)->get();
    }
    public function getMultilangTranslatableSwitch() {
        return $this->MultilangTranslatableSwitch;
    }
    public function getFieldsExceptTranslatables() {
        $fillableFields = $this->fillable;
        $MultilangTranslatableFields = $this->MultilangTranslatableSwitch;
        $array = [];
        foreach ($fillableFields as $fillableField) {
            # code...
            if(!in_array($fillableField, $MultilangTranslatableFields)) {
                $array[] = $fillableField;
            }

        }
        return $array;
    }
    public function flashForMissing() {
        $request = request();
        $lang = $request->lang;
        if(count($this->neededTranslations) > 0) {
            flash('Des traductions sont manquantes <br><br> <a href="'. route($this->getTable().'.index', ['missing_translations', 'lang' => $lang]) .'" class="btn shadow btn-secondary text-warning">Test</a>')->warning()->important();
        }
    }
    public function getNeededTranslations() {
        return $this->neededTranslations;
    }
    public function setNeededTranslations($lang) {
        $needed = $this->getNeededTranslations();
        if(!array_key_exists($lang, $needed)) {
            $this->neededTranslations[] = $lang;
        }
        return $this;
    }
    public function checkForTraduction() {
        $request = request();
        $lang = $request->lang;
        $multilang = $request->useMultilang;
        $supported_locales = config('site-settings.supported_locales');

        $langs = Arr::where($supported_locales, function ($value, $key) use ($lang) {
                return $value != $lang;
        });

        if($multilang) {
            $multilangFields = $this->getMultilangTranslatableSwitch();

            $first = $this->getTranslations($multilangFields[0]);

            foreach ($langs as $lang) {
                # code...
                if(!array_key_exists($lang, $first)) {
                    $this->setNeededTranslations($lang);
                    // $this->neededTranslations[] = $this;
                }
            }
            //flash('Message')->warning();
        }

    }
  }
