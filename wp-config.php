<?php
# Database Configuration
define( 'DB_NAME', 'wp_localdwelling' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'vCGgB{m^>Kp2Qen!cnfhWGr=_Bz%!Tk,2x_De-rZlD7TpL{5tyz:e4iVY:g*SVLQ');
define('SECURE_AUTH_KEY',  'hJI2Q-P-JWN,.]EodR3YNbek6Hk3g(JLD=8RcLBr|{Ngq?@ny)_,n+)gw3F7i~=v');
define('LOGGED_IN_KEY',    '|,=y_~ic&f2*M]P3#NfZQ~r/<>2?Ll0hE|C/!z@+:{zGXv4|;+iD4l]LX:V^K,tm');
define('NONCE_KEY',        's$1hZ+g+SNue;5UzTVK==~)_JHg~=KFTw|GUZgM]Y~Sl$bU|T7KDLHg287M$Yfb<');
define('AUTH_SALT',        'XC8,a@^l<V&t.<6=m]y+7Z.+2lcDo%Nea~)vUU}a7-l7nvN7<Q{i>7;}#sQ2fst=');
define('SECURE_AUTH_SALT', '-21~:0LXY|-Z[4S./$OEcujgZV.~>28-91|$} :9>$#]-|w- 40SwZj&2}u|I~x2');
define('LOGGED_IN_SALT',   'L#-*8+oB<*(yuSY+au$K1TYfwg #<W{fyKTe%iDbCI=[=@--i,1$P~yRp+j||:8_');
define('NONCE_SALT',       'jwP+3qw,3&O|*_-voN+a|83J{sHdC{(z/CC&@18K=uM8Z3lQ@rK+z2OQ!-J(rIN@');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'localdwelling' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '135b918a98c7e90d31f1055b2ac6208ec07f3d53' );

define( 'WPE_CLUSTER_ID', '120082' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'localdwelling.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-120082', );

$wpe_special_ips=array ( 0 => '104.196.228.184', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
