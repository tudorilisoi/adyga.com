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
define('DB_NAME', 'adygaro_wp692');

/** MySQL database username */
define('DB_USER', 'adygaro_wp692');

/** MySQL database password */
define('DB_PASSWORD', 'p[(6S64SUp');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'fuw5neocvpfckqpiu0osqyntrzlxtztfjdkezupmord8l85wmzqlab2vas92oznc');
define('SECURE_AUTH_KEY',  'etlqiykes3uiqhh7cpdhxjqnxnmtcbrznds4up31pgflwdhlzaqrppdw7sgpgdsi');
define('LOGGED_IN_KEY',    'poxiy7aa2aodkkylgpwvv0ia0eou5xzzstiugd2vvw5sfdeurmhyblxneewvmktt');
define('NONCE_KEY',        'yngtq4syxjyplqfgs5huikbxkt32c6afo3csn2ptjlsyxjuomuaomifjyawoiawx');
define('AUTH_SALT',        'plfccuy7mezgez8cwrc3tjpkwp4g6m1p36rlchoqmfnb5jheeusx7zeqb6fapzay');
define('SECURE_AUTH_SALT', 'qlejwjqbixmv5zre9fhfcdhgpxnjqgvrsvhenq5wsnqyzpv0hcgtt14jkrstrjpw');
define('LOGGED_IN_SALT',   'dj9fp6eclawq2nbwdgmsp4748jxpamxeafihdzmmto3dqpvupfx49mhkwnmnzz7e');
define('NONCE_SALT',       'oupuznvxcep6qvqrkgzwlskknzo4ctn017ybfczyoorkqsuvlzjr0lmh2ajohz5s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wprg_';

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

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'www.adyga.ro');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
