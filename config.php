<?php
/*
 ** MySQL settings - You can get this info from your web host
 */

/* MySQL database username */
define( 'YOURLS_DB_USER', 'username' );

/* MySQL database password */
define( 'YOURLS_DB_PASS', 'password' );

/* The name of the database for YOURLS */
define( 'YOURLS_DB_NAME', 'yourls' );

/* MySQL hostname. */
define( 'YOURLS_DB_HOST', 'mysql' );

/* MySQL tables prefix */
define( 'YOURLS_DB_PREFIX', 'yourls_' );

/*
 ** Site options
 */

/* YOURLS installation URL */
define( 'YOURLS_SITE', 'http://localhost' );

/* YOURLS language */
define( 'YOURLS_LANG', '' );

/* Allow multiple short URLs for a same long URL */
define( 'YOURLS_UNIQUE_URLS', true );

/* Private means the Admin area will be protected with login/pass as defined below. */
define( 'YOURLS_PRIVATE', true );

/* A random secret hash used to encrypt cookies. You don't have to remember it, make it long and complicated */
define( 'YOURLS_COOKIEKEY', 'xJMt9JSU[-#D-aajf&h%0NK1FbAc{8x5[d8s$ZsM' );

/* Username(s) and password(s) allowed to access the site. Passwords either in plain text or as encrypted hashes. 
 * Passwords are encrypted by YOURLS. You can have one or more 'login'=>'password' lines */
$yourls_user_passwords = [
	'username' => 'password',
]; 

/* URL shortening method: either 36 or 62 */
define( 'YOURLS_URL_CONVERT', 62 );

/* Debug mode to output some internal information */
define( 'YOURLS_DEBUG', true );

/* Reserved keywords (so that generated URLs won't match them)
*  Define here negative, unwanted or potentially misleading keywords. */
$yourls_reserved_URL = [ 'exampleword1', 'exampleword2' ];

/*
 ** Plugin settings
 */

/* Domain limiter settings
*  domain_exempt_users can be optionally set to allow users to override domain limit. */
$domain_limit_list = array( 'beandev.com', 'beanworks.ca', 'eu.beanworks.com', 'amazonaws.com' );
// $domain_exempt_users = array( 'user1', 'user2', 'user2' );

/* Fallback URL settings */
$fallback_url = 'https://www.quadient.com/page-does-not-exist';

/* Approved Google domain for public login */
$approved_google_domain = 'beanworks.com';