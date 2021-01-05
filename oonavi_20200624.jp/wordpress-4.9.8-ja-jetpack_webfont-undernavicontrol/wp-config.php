<?php
define('WP_CACHE', true);
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'sddb0040280206');

/** MySQL database username */
define('DB_USER', 'sddbOTEyNzY1');

/** MySQL database password */
define('DB_PASSWORD', '00navijp$');

/** MySQL hostname */
define('DB_HOST', 'sddb0040280206.cgidb');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_SITEURL', 'https://oonavi.jp/wp');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Y~zC Qn_zy<pSP(~KzHM7Mp#SlW>9D86!38R8RC,cKeD<3K+gH~6dp7]`t/ixn}A');
define('SECURE_AUTH_KEY', 'U!L]if+Gy49m`1IYY(0ENV>^JkzEfmI-,hvYUOBvun7,=qfqo_z8nzCKBnRFcVTG');
define('LOGGED_IN_KEY', 'qJbB`,AZ*`n6}Ycq@BF#>f5Ft4T{#@kjV*|oj~k;jtM-b}#I[aLEA;[{o&uoWF#m');
define('NONCE_KEY', 'iWvCwF2^Igjq:>5%6Q}/:=t%D+?be?Rfl1A:T0JKb+cj Tb4tnSi0%*n:j!CJG?S');
define('AUTH_SALT', '<jfLx]|#MU_(q*gu}jHspIi;@o?/T<&4.:M7z4~#mM $=(&3dRv)Qhfe~:pK9]qo');
define('SECURE_AUTH_SALT', '2/{U~}ShyhRYu6X`fZD2K)5cXKFQX.^2Q[hH{jLc~{PPs+_zy1]b0).2- LmB3W.');
define('LOGGED_IN_SALT', '^W;cw@L[5Cb^fb}06A9~O&Afx+U3fdOQ836R2^8*]93?;fzp;8iEz:wS}U5{M{&S');
define('NONCE_SALT', 'a$6FKi5W2i5!ah7Wyf[BX!/8<vM,vL[B[Kk|..25x7 s.#.ye+&h?owZ${* %!<L');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
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

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
