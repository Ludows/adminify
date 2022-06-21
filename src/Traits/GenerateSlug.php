<?php

namespace Ludows\Adminify\Traits;

use Exception;

trait GenerateSlug
  {
   protected $source = 'title';
   protected $appendSlugTo = 'slug';
   protected $useSlugGeneration = true;
   public function shouldUseSlug() {

    if(method_exists($this, 'defineSlugStrategy')) {
        return $this->defineSlugStrategy();
    }

    return $this->useSlugGeneration;
   }
   public function shouldGenerateSlug() {
       $useSlug = $this->shouldUseSlug();
       $schemaBuilder = $this->getConnection()->getSchemaBuilder();
       $table = $this->getTable();
       if(!$schemaBuilder->hasColumn($table, $this->appendSlugTo) && $useSlug) {
            throw new Exception($this->appendSlugTo.' required column for slug generation does not exist in table. ' .$table);
       }
       if(!$schemaBuilder->hasColumn($table, $this->source) && $useSlug) {
        throw new Exception($this->source.' source column for slug generation does not exist in table. '.$table);
       }

       if($useSlug) {
            if($schemaBuilder->hasColumn($table, $this->source) && $schemaBuilder->hasColumn($table, $this->appendSlugTo)) {
                $this->{$this->appendSlugTo} = slug( $this->{$this->source} );
            }
            else {

            }
       }

   }

  }
