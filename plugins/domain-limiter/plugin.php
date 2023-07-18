<?php
/*
Plugin Name: Domain Limiter YOURLS Plugin
Description: Only allow URLs from admin-specified domains, with an admin panel. Based on the plugin by nicwaller.
Version: 1.0
Author: Beanworks
Author URI: http://github.com/beanworks
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter( 'shunt_add_new_link', 'domain_limit_link_filter' );
function domain_limit_link_filter( $original_return, $url, $keyword = '', $title = '' ) {
	global $domain_limit_list;
	global $domain_limit_exempt_users;
    $return = array();

    // Confirm environment variables are configured correctly
	if ( domain_limit_environment_check() != true ) {
		$return['status'] = 'fail';
		$return['code'] = 'error:configuration';
		$return['message'] = yourls__( 'Problem with domain limit configuration. Check PHP error log.' );
		$return['errorCode'] = $return['statusCode'] = '500';
		return $return;
	}

	// Sanitize URL
	$url = yourls_sanitize_url( $url );
	if ( !$url || $url == 'http://' || $url == 'https://' ) {
		$return['status']    = 'fail';
		$return['code']      = 'error:nourl';
		$return['message']   = yourls__( 'Missing or malformed URL' );
		$return['errorCode'] = $return['statusCode'] = '400';
		return yourls_apply_filter( 'add_new_link_fail_nourl', $return, $url, $keyword, $title );
	}

	// If the user is exempt, don't bother checking domains
	if ( isset( $domain_limit_exempt_users ) && in_array( YOURLS_USER, $domain_limit_exempt_users ) ) {
		return $original_return;
	}

	$allowed = false;
	$requested_domain = yourls_get_domain( $url );
	foreach ( $domain_limit_list as $domain_permitted ) {
		if ( domain_limit_is_subdomain( $requested_domain, $domain_permitted ) ) {
			$allowed = true;
			break;
		}
	}

	if ( $allowed == true ) {
		return false;
	}

	$return['status'] = 'fail';
	$return['code'] = 'error:disallowedhost';
	$return['message'] = yourls__( 'URL must be in ' . implode(', ', $domain_limit_list) );
    $return['errorCode'] = $return['statusCode'] = '400';
	return $return;
}

/*
 * Determine whether $test_domain is controlled by $parent_domain
 */
function domain_limit_is_subdomain( $test_domain, $parent_domain ) {
	if ( $test_domain == $parent_domain ) {
		return true;
	}

	// Note that "notunbc.ca" is NOT a subdomain of "unbc.ca"
	// Period must be added before comparing rightmost characters
	if ( substr( $parent_domain, 1, 1) != '.' ) {
		$parent_domain = '.' . $parent_domain;
	}

	$chklen = strlen( $parent_domain );
	return ( $parent_domain == substr( $test_domain, 0-$chklen ) );
}

/*
 * Returns true if everything is configured correctly
 * Fixes variables if they are not correctly set as arrays
 */
function domain_limit_environment_check() {
	// Domain limit list check
	global $domain_limit_list;
	if ( !isset( $domain_limit_list ) ) {
		error_log('Missing definition of $domain_limit_list in user/config.php');
		return false;
	} else if ( isset( $domain_limit_list ) && !is_array( $domain_limit_list ) ) {
		$domain = $domain_limit_list;
		$domain_limit_list = array( $domain );
	}

	// Domain limit exempt users check
	global $domain_limit_exempt_users;
	if ( isset( $domain_limit_exempt_users ) && !is_array( $domain_limit_exempt_users ) ) {
		$domain = $domain_limit_exempt_users;
		$domain_limit_exempt_users = array( $domain );
	}
	return true;
}

/*
 * Register the plugin admin page
 */
yourls_add_action( 'plugins_loaded', 'domain_limit_init' );
function domain_limit_init() {
    yourls_register_plugin_page( 'domain_limit', 'Domain Limiter Settings', 'domain_limit_display_page' );
}

/*
 * Draw the plugin admin page
 */
function domain_limit_display_page() {
	global $domain_limit_list;
	global $domain_limit_exempt_users;

	?>
	<h3><?php yourls_e( 'Domain Limiter Settings' ); ?></h3>
	<?php if( domain_limit_environment_check() != true ) { ?>
		<p><?php yourls_e( "Error in domain limit configuration" ); ?></p>
	<?php } else { ?>
		<p><?php echo $domain_limit_exempt_users; ?></p>
		<p><?php yourls_se( "Domains allowed to be shortened: %s", implode(", ", $domain_limit_list) ); ?></p>
		<?php if( !is_null($domain_limit_exempt_users) ) { ?>
			<p><?php yourls_se( "Users exempt from domain limit: %s", implode(", ", $domain_limit_exempt_users ) ); ?></p>
			<p><?php yourls_se( "Current user (%s) %s exempt from domain limit", YOURLS_USER, in_array( YOURLS_USER, $domain_limit_exempt_users ) ? "" : "not" ); ?></p>
		<?php } ?>
	<?php } ?>
	<?php
}