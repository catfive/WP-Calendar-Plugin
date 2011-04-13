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
define('DB_NAME', 'wp_events');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '4VjG{,?f_? %`&a+6~7*s1{@X.?p#H5*p^eLC9vV?wG~#B3xd:v&h!p>2`ejSyd7');
define('SECURE_AUTH_KEY',  '6 (K@rjnd]>jHZ=k<8WLSwm,7t15O,Au9wkW$-/OUWt<C5jgBAN*qsTN.y8t-[7Y');
define('LOGGED_IN_KEY',    '!HoN3~U2-n>qA2^~m~46g_H:V?yaKlU@=$qb^lQ2NtkKL3Z=901{<P%]?k(/v4t/');
define('NONCE_KEY',        'Y!.U(tQGQkr^{l^:vkG23jY3p0f4ovlHd{NH1=63H,GYzEx4:<C;?sB%67I{}u.v');
define('AUTH_SALT',        'Gs(lyO]Dht[@q#TQm1@.u]%`owt;~s#XsOX4< x|y+^c1j8Z1wq~Xd4+Jnvav)$9');
define('SECURE_AUTH_SALT', '+4y2LOTd4p:>`y<ubfJJIp7IG|Yt|a9FvaodYo5uGy^t@/8Oq$9;J@Y)c?cfZ,e)');
define('LOGGED_IN_SALT',   'Zk,]DMQY.|2)vvIFxNaa8NURi1`($me_?Me}cooK{hs2%k=Wa!u$1>|*^wwv2UJ_');
define('NONCE_SALT',       '};&h~g3@8^28vPsRFbz2^Z8_i@RQY=l[}3EBt6Ty0z{TLs(Z^wa)9TTt,3`I/u7(');

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

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
