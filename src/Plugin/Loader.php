<?php
/*
The MIT License (MIT)

Copyright (c) 2015 Twitter Inc.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

namespace Twitter\WordPress;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters
 *
 * @since 1.0.0
 */
class PluginLoader
{
	/**
	 * Uniquely identify plugin version
	 *
	 * Bust caches based on this value
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	const VERSION = '0.0.1';

	/**
	 * Unique domain of the plugin's translated text
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	const TEXT_DOMAIN = 'plugin';

	/**
	 * Bind to hooks and filters
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init()
	{
		$classname = get_called_class();

		// load translated text
		add_action( 'init', array( $classname, 'loadTranslatedText' ) );

		// compatibility wrappers to coexist with other popular plugins
		add_action( 'plugins_loaded', array( $classname, 'compatibility' ) );

		// // make widgets available on front and back end
		// add_action( 'widgets_init', array( $classname, 'widgetsInit' ) );

		// register Twitter JavaScript to eligible for later enqueueing
		add_action( 'wp_enqueue_scripts', array( $classname, 'registerScripts' ), 1, 0 );

		if ( is_admin() ) {
			// admin-specific functionality
			add_action( 'init', array( $classname, 'adminInit' ) );
		} else {
			// hooks to be executed on general execution of WordPress such as public pageviews
			add_action( 'init', array( $classname, 'publicInit' ) );
			add_action( 'wp_head', array( $classname, 'wpHead' ), 1, 0 );
		}

	}

	/**
	 * Full path to the directory containing the Twitter for WordPress plugin files
	 *
	 * @since 1.0.0
	 *
	 * @return string full directory path
	 */
	public static function getPluginDirectory()
	{
		return dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/';
	}

	/**
	 * Full path to the main file of the Twitter for WordPress plugin
	 *
	 * @since 1.0.0
	 *
	 * @return string full path to file
	 */
	public static function getPluginMainFile()
	{
		return static::getPluginDirectory() . 'plugin.php';
	}

	/**
	 * Load translated strings for the current locale, if a translation exists
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function loadTranslatedText()
	{
		load_plugin_textdomain( static::TEXT_DOMAIN );
	}


	/**
	 * Hook into actions and filters specific to a WordPress administrative view
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function adminInit()
	{
		// User profile fields
	
	}

	/**
	 * Register actions and filters shown in a non-admin context
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function publicInit()
	{
		// enhance web browser view only
		if ( is_feed() ) {
			return;
		}
	
		// do not add content filters to HTTP 404 response
		if ( is_404() ) {
			return;
		}


	}


	/**
	 * Attach actions to the wp_head action
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function wpHead()
	{
		return;	
	}

	/**
	 * Register JavaScript during the enqueue scripts action
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function registerScripts()
	{
		return this;
	}

}
