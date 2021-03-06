<?php

/*
|---------------------------------------------------------------------------
| Here are SOME of the available configuration options with suitable values.
| Uncomment and customize those you want to override or remove them to
| use their default values. For a FULL list of options please visit
| https://github.com/Stolz/Assets/blob/master/API.md#assets
|---------------------------------------------------------------------------
*/
$siteSettings = include(config_path('site-settings.php'));


return [

    // Configuration for the default group. Feel free to add more groups.
	// Each group can have different settings.
	'default' => [

		/**
		 * Regex to match against a filename/url to determine if it is an asset.
		 *
		 * @var string
		 */
		'asset_regex' => '/.\.(css|js)$/i',

		/**
		 * Regex to match against a filename/url to determine if it is a CSS asset.
		 *
		 * @var string
		 */
		'css_regex' => '/.\.css$/i',

		/**
		 * Regex to match against a filename/url to determine if it is a JavaScript asset.
		 *
		 * @var string
		 */
		'js_regex' => '/.\.js$/i',

		/**
		 * Regex to match against a filename/url to determine if it should not be minified by pipeline.
		 *
		 * @var string
		 */
		'no_minification_regex' => '/.[-.]min\.(css|js)$/i',

		/**
		 * Absolute path to the public directory of your App (WEBROOT).
		 * Required if you enable the pipeline.
		 * No trailing slash!.
		 *
		 * @var string
		 */
		'public_dir' => (function_exists('public_path')) ? public_path() : '',

		/**
		 * Directory for local CSS assets.
		 * Relative to your public directory ('public_dir').
		 * No trailing slash!.
		 *
		 * @var string
		 */
		'css_dir' => 'css',

		/**
		 * Directory for local JavaScript assets.
		 * Relative to your public directory ('public_dir').
		 * No trailing slash!.
		 *
		 * @var string
		 */
		'js_dir' => 'js',

		/**
		 * Directory for local package assets.
		 * Relative to your public directory ('public_dir').
		 * No trailing slash!.
		 *
		 * @var string
		 */
		//'packages_dir' => 'packages',

		/**
		 * Enable assets pipeline (concatenation and minification).
		 * Use a string that evaluates to `true` to provide the salt of the pipeline hash.
		 * Use 'auto' to automatically calculated the salt from your assets last modification time.
		 *
		 * @var bool|string
		 */
		'pipeline' => false,

		/**
		 * Directory for storing pipelined assets.
		 * Relative to your assets directories ('css_dir' and 'js_dir').
		 * No trailing slash!.
		 *
		 * @var string
		 */
		'pipeline_dir' => 'min',

		/**
		 * Enable pipelined assets compression with Gzip.
		 * Use only if your webserver supports Gzip HTTP_ACCEPT_ENCODING.
		 * Set to true to use the default compression level.
		 * Set an integer between 0 (no compression) and 9 (maximum compression) to choose compression level.
		 *
		 * @var bool|int
		 */
		'pipeline_gzip' => false,

		/**
		 * Closure used by the pipeline to fetch assets.
		 *
		 * Useful when file_get_contents() function is not available in your PHP
		 * instalation or when you want to apply any kind of preprocessing to
		 * your assets before they get pipelined.
		 *
		 * The closure will receive as the only parameter a string with the path/URL of the asset and
		 * it should return the content of the asset file as a string.
		 *
		 * @var Closure
		 */
		//'fetch_command' => function ($asset) {return preprocess(file_get_contents($asset));},

		/**
		 * Available collections.
		 * Each collection is an array of assets.
		 * Collections may also contain other collections.
		 *
		 * @var array
		 */
		'collections' => $siteSettings['assets']['collections'],

		/**
		 * Preload assets.
		 * Here you may set which assets (CSS files, JavaScript files or collections)
		 * should be loaded by default even if you don't explicitly add them on run time.
		 *
		 * @var array
		 */
		'autoload' => $siteSettings['assets']['autoload'],


	], // End of default group
];
