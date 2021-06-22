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
   public function handleSeo($model) {
        $reflection = new ReflectionClass($model);
        $type = $reflection->getShortName();
        $multilang = request()->useMultilang;
        $getTextConfig = config('laravel-gettext.supported-locales');

        if($multilang) {
            // SEOMeta::addAlternateLanguages($getTextConfig);
        }
        SEOMeta::setTitleSeparator(' - ');

        $title = $model->seoWith('title', false);
        if($title != null) {
            SEOMeta::setTitle($title);
        }
        else {
            SEOMeta::setTitle($model->title);
        }


        $description = $model->seoWith('description', false);
        $keywords = $model->seoWith('keywords', false);
        $robots = $model->seoWith('robots', false);
        if($description) {
            SEOMeta::setDescription($description);
        }
        if($keywords) {
            SEOMeta::setKeywords($keywords);
        }
        if($robots) {
            SEOMeta::setRobots($robots);
        }
        // SEOMeta::setDescription($description);
        // SEOMeta::setKeywords($keywords);
        // SEOMeta::setRobots($robots);
        //SEOMeta::setPrev($url);
        //SEOMeta::setNext($url);



        if(isset($model->media_src)) {
            $media = $model->media->path;
            OpenGraph::addImage($media);
            TwitterCard::setImage($media);
            JsonLd::setImage($media); // add image url
        }
        OpenGraph::setTitle($model->title);
        if($description) {
            OpenGraph::setDescription($description);  // define description
        }
        OpenGraph::setSiteName(env('APP_NAME')); //define site_name
        OpenGraph::addProperty('type', $this->types[strtolower($type)]);

        // TwitterCard::setType($type); // type of twitter card tag
        TwitterCard::setTitle($model->title); // title of twitter card tag
        TwitterCard::setSite(env('APP_NAME')); // site of twitter card tag
        // TwitterCard::setDescription($type); // description of twitter card tag
        if($description) {
            TwitterCard::setDescription($description);  // define description
        }


        // JsonLd::setType($type); // type of twitter card tag
        JsonLd::setTitle($model->title); // title of twitter card tag
        JsonLd::setSite(env('APP_URL')); // site of twitter card tag
        //JsonLd::addValue($key, $value);
        // JsonLd::setDescription($type); // description of twitter card tag
        if($description) {
            JsonLd::setDescription($description);  // define description
        }
        // ; // add image url
   }
  }
