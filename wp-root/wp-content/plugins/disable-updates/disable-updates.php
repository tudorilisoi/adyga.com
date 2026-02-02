<?php
/*

Plugin Name:    Disable Updates
Plugin URI:     https://wordpress.org/plugins/disable-updates/
Description:    A simple plugin that prevents updating the WordPress core, plugins and themes.
Version:        1.4.2
Author:         Johan van der Wijk
Author URI:     https://vanderwijk.com/
License:        GPL-2.0+
License URI:    http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:    disable-updates
Domain Path:    /languages

*/

// add donation and review links to plugin description
function du_plugin_links ( $links, $file ) {
	$base = plugin_basename( __FILE__ );
	if ( $file == $base ) {
		$links[] = '<a href="https://wordpress.org/support/plugin/disable-updates/reviews/#new-post" target="_blank">' . __( 'Review', 'disable-updates' ) . ' <span class="dashicons dashicons-thumbs-up"></span></a> | <a href="https://paypal.me/vanderwijk">' . __( 'Donate', 'disable-updates' ) . ' <span class="dashicons dashicons-money"></span></a>';
	}
	return $links;
}
add_filter ( 'plugin_row_meta', 'du_plugin_links', 10, 2 );

// remove cron events for core, themes and plugins
function filter_cron_events ( $event ) {

	$ignore = array (
		'wp_version_check',
		'wp_update_plugins',
		'wp_update_themes',
		'wp_maybe_auto_update',
	);

	if ( in_array ( $event -> hook, $ignore ) ) {
		return false;
	}

	return $event;

}
add_action ( 'schedule_event', 'filter_cron_events' );

// hide all upgrade notices
function du_hide_admin_notices () {
	remove_action ( 'admin_notices', 'update_nag', 3 );
}
add_action ( 'admin_menu', 'du_hide_admin_notices' );

// remove the 'Updates' menu item from the admin interface
function du_remove_menus () {
	global $submenu;
	remove_submenu_page ( 'index.php', 'update-core.php' );
}
add_action ( 'admin_menu', 'du_remove_menus', 102 );

// disable core, theme and plugin updates
function du_disable_updates () {
	remove_action ( 'load-update-core.php', 'wp_update_core' );
	remove_action ( 'load-update-core.php', 'wp_update_themes' );
	remove_action ( 'load-update-core.php', 'wp_update_plugins' );
}
add_action ( 'init', 'du_disable_updates', 1 );

// fake last checked time (using __return_null makes the dashboard slow)
function du_last_checked () {
	global $wp_version;
	return ( object ) array (
		'last_checked' => time (),
		'version_checked' => $wp_version,
		'updates' => array ()
	);
}
add_filter ( 'pre_site_transient_update_core', 'du_last_checked' );
add_filter ( 'pre_site_transient_update_plugins', 'du_last_checked' ) ;
add_filter ( 'pre_site_transient_update_themes', 'du_last_checked' );

// disable automatic updates
add_filter ( 'automatic_updater_disabled', '__return_true' );

// disable update health check
add_filter ( 'site_status_tests', function ( $tests ) {
	unset ( $tests['async']['background_updates'] );
	unset ( $tests['direct']['plugin_theme_auto_updates'] );
	return $tests;
});
