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
define('DB_NAME', 'saratoga');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'pass4rd');

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
define('AUTH_KEY',         'WItrjiO?E(Cyd-0~:PFJiz<m7BInJozs?2Zj0fRC!8r+$ ZDU7WC-c|aivt[Ee s');
define('SECURE_AUTH_KEY',  '[<y)),WuB|q,JOGAK-:-~c5||(*?W||0S4R^A:MUgtF+s7+V@+4pk)e>`,U}AT[<');
define('LOGGED_IN_KEY',    'khzpQ6=smd]}WnvT~Q<d/0YC,CG@H:4A&ol9y?OhS|m]jC5z3VIF!$mK+c#*!N)P');
define('NONCE_KEY',        'T)}oSl{qGN=yP~W<(Q}H$H2+mgt%(buBU@6(|Q{-V`9=-7$=O/NjlL0HyiyLw5:[');
define('AUTH_SALT',        'o_+/S`bA-gX!=xkdw5U]i({6!epx]jF7AN|$5}^6|7 Bf`Wx/DP`e:GTxb9wnMh0');
define('SECURE_AUTH_SALT', 'b@Oc?x8VUBMmuDugk^Ie.q&IS@;Rg+MO+`9B$%|L{6(REvp+iMEI6fC/3nq3Q=f{');
define('LOGGED_IN_SALT',   '6oAD,I;vD.{]!HZ$|Nxn5F/nd.Xb]s aqEE b |Ky(N.16nTS!%$9RLA:&WI1B#2');
define('NONCE_SALT',       'ZKR_S}:-p?-hEJer~rayS_8q/wu#yzlz:NJ;#%8!#?[+5%<+wUvP&LC0@m%8} `z');

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
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
