<?php
/*
Plugin Name: Domain Limiter YOURLS Plugin
Plugin URI: https://github.com/beanworks/yourls-domainlimit-plugin
Description: Allows a fallback URL in case there isn't a match for a short URL. Based on the plugin by Diego Peinador.
Version: 1.0
Author: Beanworks
Author URI: http://github.com/beanworks
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'redirect_keyword_not_found', 'dp_fallback_url' );
function dp_fallback_url() {
        // Get value from database
        global $fallback_url;
	yourls_redirect( $fallback_url, 302 ); //Use a temporal redirect in case there is a valid keyword in the future
	exit();
}

/*
 * Register the plugin admin page
 */
yourls_add_action( 'plugins_loaded', 'fallback_url_init' );
function fallback_url_init() {
        yourls_register_plugin_page( 'fallback_url', 'Fallback URL Settings', 'fallback_url_display_page' );
}

/*
 * Draw the plugin admin page
 */
function fallback_url_display_page() {
        global $fallback_url;

        ?>
        <h3><?php yourls_e( 'Fallback URL Settings' ); ?></h3>
        <p><?php yourls_se( "Configured fallback URL: %s", $fallback_url ); ?></p>
        <?php
}