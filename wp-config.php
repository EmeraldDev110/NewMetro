<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbimosd33xguek' );

/** Database username */
define( 'DB_USER', 'unevysdxyew6r' );

/** Database password */
define( 'DB_PASSWORD', 'priwvzwcftdr' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'XSy*t,^z4_i,b_Qkk`3<~<A<[p-KE]]:IvVzcgvyEY9n4!_7D_dgg/z}M $gs|px' );
define( 'SECURE_AUTH_KEY',   '|I4+q2#rI3;~wjJ;RT%q4}v&ak%)TFOHA{+p%>jG?|cUx~Q>FZrzCz3UHAQp^/+5' );
define( 'LOGGED_IN_KEY',     '_?Rj#MwJSOBy& c%4+BbNt4d)p;N^;=*(=bwb)6&y28^TSeEMT?P/FE0?TAI (j2' );
define( 'NONCE_KEY',         '[S+V4omPfkLnYcg;lS8*3F] k7X~8ZQPf{ZZ:FD_A^tD&I2U|03ZAt:^ J8Vq6fY' );
define( 'AUTH_SALT',         'u;#6wVV+ljfI/(X6)QgTwR+3on`m&#x^8S{SHEDF!0QlArk|cz^HUBZ*j:0NBCD0' );
define( 'SECURE_AUTH_SALT',  'S2qH2>vgW6kz(?I4!^IPh9X94yM)p1+u[#5UJx)bcWhxKa;94kN#=U<oe4py`V*-' );
define( 'LOGGED_IN_SALT',    'W<2N/Qmmld}[:;_m`G!d,1bU69/q!xOJvbHvq}owlJCJUh[/:IcPxZV$DlMUs,aM' );
define( 'NONCE_SALT',        ' ~uxc,X@E/-6aZ{srk>lOXhl=<`-~%aWN}4MgJRhI*lI~Ce%EAl1]cIn6_GE<Xf)' );
define( 'WP_CACHE_KEY_SALT', 'xa+S-m.tp.Lb)Ya Y|-W/+Z#1&eh)9/QX+jw@hs/x01Vu%FwA4WJV8^5</@D>q|-' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fis_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
@include_once('/var/lib/sec/wp-settings-pre.php'); // Added by SiteGround WordPress management system
require_once ABSPATH . 'wp-settings.php';
@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system
