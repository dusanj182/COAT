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
define( 'DB_NAME', 'coat' );

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
define( 'AUTH_KEY',         'qlQ;w_XAp+r9ahGID>=E*Nd9Lbh3yBZ|+4x*1)}gukR595 [C9g#d-wWMgm>mZD3' );
define( 'SECURE_AUTH_KEY',  'xf3v/#,q9@K<=V+_w$TIU20O|gZbC1r;k3KgT)%Elu!=ACi`19rm-Yg+cmY,)YyJ' );
define( 'LOGGED_IN_KEY',    '2Y7=%0l%9C!&=q!59E.kOciA]ZqK.<gt<65g:+ILJxto%g /)JcT%oR^kFqVE{[+' );
define( 'NONCE_KEY',        'KUNI,D^2PoSoU/4l iLy7Iw4ZMCqIQ-{:w-rWfscR,V/Z_03^YhE;sA8nz@-p%h{' );
define( 'AUTH_SALT',        'Oq~q=qA.mxd;LYI%T(-fyazWL^=w^Dk078vwJ:LbIj8T&g-4p/|oOs`U_gA5a]jJ' );
define( 'SECURE_AUTH_SALT', 'mNHIW;)t] I/as/K=>Y!)7&+|#U|;(3bV42/bs0bo48>uAxXx>;PO,EfRV !q*Ql' );
define( 'LOGGED_IN_SALT',   'IL=$oYR1DnK so*c1S!F/dbp;]hY!C@+ezs@<aNseqNP`DY8`pK0IC9+$Rw%Na;=' );
define( 'NONCE_SALT',       'c{-+@SgZT!Q%9x=<+#JW@gPpWk~KpHUhh,)3,pop+PF#A-v}?)P@#7FvEg%hNt9S' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
