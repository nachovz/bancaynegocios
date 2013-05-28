<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'C291728_bancaynegocios');//define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'C291728_byn');//define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Banca2013');//define('DB_PASSWORD', '435389');

/** MySQL hostname */
define('DB_HOST', 'mysql1009.ixwebhosting.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_MEMORY_LIMIT', '128M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':Hs;v:-l>`IxKW5DE3lR`1Z.B2Ru&+hsadcJlrhuJe+ANn660u|SdqjJs Oc&,jz');
define('SECURE_AUTH_KEY',  'v9I^/N !j;SG` Q9C3#MI1|5v+yd.6$*5V7Vj B|x6rdx1_c4k j,O=SZvY3;4NT');
define('LOGGED_IN_KEY',    'Uo8O,Z+p+|Zpco^2s5+fa@xa@>%hV(n7E@(m.$5z:;zvs}ga4MQ29q 0mm{wQ4-v');
define('NONCE_KEY',        'B5:g-vIrG%Fbj3y6u-/N47k^]~>DG>L{[?:sn,|H#eiA#B*T%2e|.VV|0P:7Cx;:');
define('AUTH_SALT',        'L2)<+G3;ve7/B$lC$cU!*q?escVC4rt-vkvsY,ylBKRxL<+kQkzZgyhu$EScBIuk');
define('SECURE_AUTH_SALT', ' ,l>}WtwB2pVb*J95o|84Bhg/id,.n<dmNluodQO4CLz$bxQY}$VH<CpA+|Tkzbn');
define('LOGGED_IN_SALT',   'oq|[?x}S 8-*?H`PbrwNnY1Y};{/:8I]D.-dX|clRv!acxh8WZq]Z=]=*zQb|MZe');
define('NONCE_SALT',       '?|hJ@2A$H2Dyv8TSJ!)+]B:oNiC18C=@LJM,>WZ:b-+-cO;&^hI8V2_YMf4i{5j@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
