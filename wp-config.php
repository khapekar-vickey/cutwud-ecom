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
define( 'DB_NAME', 'cutwud_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Y~lOw!i?a|IweH/<y8RrB=%Cm9m05-%|6jHS_6/XQcCJhXpCPI#d-}UqHP(6&8bt' );
define( 'SECURE_AUTH_KEY',  '<jDSEJ6_%x|pkR,[10X=1jgMrB}-MG b]Y*j7XO L/FBs45M34N?JT<R^e,mI};r' );
define( 'LOGGED_IN_KEY',    'z`Z!,Ax@|Vs{%(29:C+aK5]M2As]0cMgvLdB$y^NU~dbpP=Df,b^x*EtQuu.4jR.' );
define( 'NONCE_KEY',        '^v/ZtkQ5Z[@BLdIwYI}<d9bC}cYsV]GPMCVVS|@_lES8p,ukhmB`HB*q<4t$]c(r' );
define( 'AUTH_SALT',        '!yaP}_*bBp)d4z;lwnRN6q7|~/1BKW7p0ycaZsLHSPI4h^s7y: 8^EWA^jQ..*7y' );
define( 'SECURE_AUTH_SALT', '6Y#gM?wtP<8U75]c:O0@]j2DUxgR$8W/RK(u?];^l ]E=O@!fR=^FR4TMg8RP%rp' );
define( 'LOGGED_IN_SALT',   '_E.*g^T[S/w~=nv,6l.FUy01.CE+;(_hO09)&`Klc`uf-d!d+8Ly|jPJYz/qN-nE' );
define( 'NONCE_SALT',       'b+OA8k){LMCLl7/mH#+ Ph_?ls PDMQ#C3+hEF%fL!xqH>2@}u66QnI<[x7Ek>?)' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
