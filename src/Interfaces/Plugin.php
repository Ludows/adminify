<?php
/**
 * Plugin interface. All plugin must implement this interface
 *
 * @author Ludoows
 */
namespace Ludows\Adminify\Interfaces;

interface Plugin {
   function registerPlugin();
   function boot();
}
?>