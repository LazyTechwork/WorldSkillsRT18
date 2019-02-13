<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'webrt11');

/** MySQL database username */
define('DB_USER', 'webrt11');

/** MySQL database password */
define('DB_PASSWORD', 'dT6mQocX');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'b)v<nZq;a3+lT1v;9H|gC}Lj=0itXVZ,XQC3JFD~C>!LrRkbP`BFv`swj+(g5yc]');
define('SECURE_AUTH_KEY',  ' z9cW|pn^xD*@}-odwx&PVTwb>clAt1e9}T9Vill**.rJ8F60!6Xe5^9(jCmWpyJ');
define('LOGGED_IN_KEY',    'Ni3(HQd/pJ06^LA.>^NBG}S,)m3(JhE<{t:vfawp&XJFJOkL_cIv,qHJE0^pox?G');
define('NONCE_KEY',        '[MO;?OV=b~S)1,]$8F2{x-?D#gqk3WWA,b@KvH@{ZK!]] dJ;mNvrwu2[uc&09R,');
define('AUTH_SALT',        '.Pdo`NvGDw 4@sq-wy&As?1ZFc^ZPtytd3xX6cK#X-Wb/y@{)A~z/F>/$YLy9hj-');
define('SECURE_AUTH_SALT', 'P!,Jda,NbDL56[QHTzC!(1r_}|l/zd~#_6@xeM&%u}M%dG@;T%)?N~MFDPcwl0]>');
define('LOGGED_IN_SALT',   '[}XFA[3@;;xj#zO:f>UEZB2pUO)*gOlm48g)g@[2-:{}=g)Jrk_U87:S+xA$>l_K');
define('NONCE_SALT',       '+cSISx(P**/5XLZB14 FBSa1jBK./^pHpN@j:Fur/9>O;n6Fjkk.j.TfmZc{<OK9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
