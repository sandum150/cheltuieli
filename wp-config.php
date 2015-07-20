<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Sa72568339');

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
define('AUTH_KEY',         '=1J}5D_`(Q-<A#SlNZWjn6b,Vl?+1Ca0Lm8PdTDO,FKL@g@I9F1xnKw`;D0Zpb?I');
define('SECURE_AUTH_KEY',  '6vd<yNCM-lr^+)dS0x}|p3,rDaETG:Yvg0@-M{-v-(>@$uN<d`sU%Ml2n94rpx{r');
define('LOGGED_IN_KEY',    '##-xeBsGcN2l,#70-]st&M4G{!+$NRV$njlTid<U%.SH,GMq~glg}LDxyJ; f:x?');
define('NONCE_KEY',        ';_nt-#cqH9o62G.`({E&ld]iYh+*OtI-qGHt3/x24J4$!pJ6DJ}s3<-s.)`I2)K)');
define('AUTH_SALT',        'f;6rO/-o?S3/@&b>5Arm2odK52LF19wYv+]m_Hs.^ksjsAE[,,?|E.&>X?g|tSfy');
define('SECURE_AUTH_SALT', '!V,9Ysqq%po3MV0dmjIZ~KN]SeJH@G!ON-;<vgf9C,njC=$Ex#6rE2?GM+ye>Ldb');
define('LOGGED_IN_SALT',   'MF[2S4ct_Q{K=NG$@ZUb;0H,=ziXnx-p0oW/Tv]#dEU8FRhl{QRXgXva>VW4HTG}');
define('NONCE_SALT',       'dY0X&~;Lks<Cg^[pLSH|H2c^f{Iw3=0*Tk;zGK JqXj9qErEy[z|dU%Xsm{-?8@z');

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
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');


define('WP_POST_REVISIONS', 3);
//define('WP_POST_REVISIONS', true);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
