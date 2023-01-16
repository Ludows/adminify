<?php

namespace Ludows\Adminify\Traits;
  use ReflectionClass;
  use Artesaos\SEOTools\Facades\SEOMeta;
  use Artesaos\SEOTools\Facades\OpenGraph;
  use Artesaos\SEOTools\Facades\TwitterCard;
  use Artesaos\SEOTools\Facades\JsonLd;
  trait SeoGenerator
  {
   public $types = [
      'post' => 'article',
      'page' => 'page',
      'category' => 'categorie',
   ];
   public function handleSeo($mixed) {

        $isModel = true;
        $multilang = request()->useMultilang;

        if(is_array($mixed)) {
            $isModel = false;
            $isSeo = false;
        }
        else {
            $isSeo = is_seo_model($mixed);
        }
        
        if($isModel) {
            $reflection = new ReflectionClass($mixed);
            $type = $reflection->getShortName();
        }
        else {
            $type = $mixed['type'];
        }


        $noSeo = setting('no_seo');

        $description = $isSeo ? $mixed->seoWith('description', false) : null;
        $keywords = $isSeo ? $mixed->seoWith('keywords', false) : null;
        $robots = $isSeo ? $mixed->seoWith('robots', false) : null;
        $langs = locales();
        $media = $isSeo ? $this->handleMedia($mixed) : null;


        if($multilang) {
            // SEOMeta::addAlternateLanguages($getTextConfig);
        }
        SEOMeta::setTitleSeparator(' - ');

        $title = $isSeo ? $mixed->seoWith('title', false) : null;
        if($title != null && $isModel) {
            SEOMeta::setTitle($title);
            OpenGraph::setTitle($title);
            TwitterCard::setTitle($title); // title of twitter card tag
            JsonLd::setTitle($title); // title of twitter card tag
        }
        else if($isModel) {
            SEOMeta::setTitle($mixed->title);
            OpenGraph::setTitle($mixed->title);
            TwitterCard::setTitle($mixed->title); // title of twitter card tag
            JsonLd::setTitle($mixed->title); // title of twitter card tag
        }
        else {
            SEOMeta::setTitle($mixed['title']);
            OpenGraph::setTitle($mixed['title']);
            TwitterCard::setTitle($mixed['title']);
            JsonLd::setTitle($mixed['title']); // title of twitter card tag
        }

        if($description != null && $isModel) {
            SEOMeta::setDescription($description);
            OpenGraph::setDescription($description);
            TwitterCard::setDescription($description);  // define description
            JsonLd::setDescription($description);  // define description
        }
        if($description == null && !$isModel) {
            SEOMeta::setDescription($mixed['description']);
            OpenGraph::setDescription($mixed['description']);
            TwitterCard::setDescription($mixed['description']);  // define description
            JsonLd::setDescription($mixed['description']);  // define description
        }

        if($keywords != null && $isModel) {
            SEOMeta::setDescription($keywords);
        }
        if($keywords == null && !$isModel) {
            SEOMeta::setDescription($mixed['keywords']);
        }

        if($noSeo == 1) {
            SEOMeta::setRobots('none');
        }
        else {
            if($robots != null && $isModel) {
                SEOMeta::setRobots($robots);
            }
            if($robots == null && !$isModel) {
                SEOMeta::setRobots($mixed['robots']);
            }
        }
        

        // SEOMeta::setDescription($description);
        // SEOMeta::setKeywords($keywords);
        // SEOMeta::setRobots($robots);
        //SEOMeta::setPrev($url);
        //SEOMeta::setNext($url);


        if(!empty($media)) {
            //dd($mixed);
            // $media = $mixed->media->path;
            OpenGraph::addImage($media);
            TwitterCard::setImage($media);
            JsonLd::setImage($media); // add image url
        }

        OpenGraph::setSiteName(env('APP_NAME')); //define site_name
        if(!empty($this->types[strtolower($type)])) {
            OpenGraph::addProperty('type', $this->types[strtolower($type)]);
        }

        // TwitterCard::setType($type); // type of twitter card tag

        TwitterCard::setSite(env('APP_NAME')); // site of twitter card tag
        // TwitterCard::setDescription($type); // description of twitter card tag


        // JsonLd::setType($type); // type of twitter card tag

        JsonLd::setSite(env('APP_URL')); // site of twitter card tag
        //JsonLd::addValue($key, $value);
        // JsonLd::setDescription($type); // description of twitter card tag
        // ; // add image url
   }
   public function handleMedia($model) {
        // test from media key on model 
        $media_id = $model->{$model->media_key};
        $media = null;
        if(empty($media_id)) {
            $media_id = $model->seoWith('image', false);
        }

        if(!empty($media_id)) {
            // media is found
            $media = media( (int) $media_id );
            $media = $media->path;
        }

        return $media;
   }
  }
