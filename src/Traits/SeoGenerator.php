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

        $description = $isSeo ? $mixed->seoWith('description', false) : null;
        $keywords = $isSeo ? $mixed->seoWith('keywords', false) : null;
        $robots = $isSeo ? $mixed->seoWith('robots', false) : null;
        $langs = config('site-settings.supported_locales');


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

        if($robots != null && $isModel) {
            SEOMeta::setDescription($robots);
        }
        if($robots == null && !$isModel) {
            SEOMeta::setDescription($mixed['robots']);
        }

        // SEOMeta::setDescription($description);
        // SEOMeta::setKeywords($keywords);
        // SEOMeta::setRobots($robots);
        //SEOMeta::setPrev($url);
        //SEOMeta::setNext($url);


        if(isset($mixed->media_id) && $isModel && $mixed->media_id != 0) {
            //dd($mixed);
            $media = $mixed->media->path;
            OpenGraph::addImage($media);
            TwitterCard::setImage($media);
            JsonLd::setImage($media); // add image url
        }

        OpenGraph::setSiteName(env('APP_NAME')); //define site_name
        OpenGraph::addProperty('type', $this->types[strtolower($type)]);

        // TwitterCard::setType($type); // type of twitter card tag

        TwitterCard::setSite(env('APP_NAME')); // site of twitter card tag
        // TwitterCard::setDescription($type); // description of twitter card tag


        // JsonLd::setType($type); // type of twitter card tag

        JsonLd::setSite(env('APP_URL')); // site of twitter card tag
        //JsonLd::addValue($key, $value);
        // JsonLd::setDescription($type); // description of twitter card tag
        // ; // add image url
   }
  }
