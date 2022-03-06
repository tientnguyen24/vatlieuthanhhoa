<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vatlieuthanhhoa' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jB3Exx)U$}*bojb1BtUR>b5bRD$JU4C);A<@)#3qS]r]I<v1bgUkLK#?sLFx-[b2' );
define( 'SECURE_AUTH_KEY',  'mysFiT^%Y8&fAMj+D=L;sjN.|GkzHHE,^.UMZRMtY0a}G5iWiGxU->%`=^Ccw&rz' );
define( 'LOGGED_IN_KEY',    '/:1YptTwD*J3F?3}KXJZDU-]U`5A[J}*v>kGLf)TI~Azwn.>d`gQizpegop|HWn0' );
define( 'NONCE_KEY',        'Sq[/YMli]]79xi_0E-<|g|krXiX/k5*gB73,5vQd[fFQud4c4RYh|{<1>47<V)p<' );
define( 'AUTH_SALT',        'TBG0l4>(2<g)r35K|p^MZv}|dEG@>gLLpwuj%/tN$8PO[fLf24@r})%nvP2Jn]AT' );
define( 'SECURE_AUTH_SALT', 'c_@uI}6Y6q8|EYX^dR^M^It7b}:@qpdfK$EMe^:@Ux@?x,uz1QQ#=+U^1F_&1F- ' );
define( 'LOGGED_IN_SALT',   'f%C-w;/~nc)E)h)ZeO;RjTmR}#Nq1t]It:X[k `6(+Uv-~Q$ @5@qmh+ isxrW.4' );
define( 'NONCE_SALT',       ']KlU<;`J3)-WB9s/R3e-EnD2G[r[#h>iBD| _w?uOGO4T)!yezX+hK/PL J:k`OU' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'vlth_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
