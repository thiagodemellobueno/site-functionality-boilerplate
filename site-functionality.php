<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/misfist/site-functionality
 * @since             1.0.0
 * @package           site-functionality
 *
 * @wordpress-plugin
 * Plugin Name:       ABC No Rio Custom Site Functionality
 * Plugin URI:        http://github.com/madeofpeople/site-functionality/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            Made of People
 * Author URI:        https://github.com/madeofpeople/site-functionality/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       site-functionality
 * Domain Path:       /languages
 *
 * GitHub Plugin URI: https://github.com/madeofpeople/site-functionality/
 * Release Asset:     true
 */

namespace Site_Functionality;

use Site_Functionality\Common\WP_Includes\Activator;
use Site_Functionality\Common\WP_Includes\Deactivator;


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	throw new \Exception( 'WordPress required but not loaded.' );
}

$autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $autoload ) ) {
	require_once $autoload;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SITE_FUNCTIONALITY_VERSION', '1.0.0' );
define( 'SITE_FUNCTIONALITY_BASENAME', plugin_basename( __FILE__ ) );
define( 'SITE_FUNCTIONALITY_PATH', plugin_dir_path( __FILE__ ) );
define( 'SITE_FUNCTIONALITY_URL', trailingslashit( plugins_url( plugin_basename( __DIR__ ) ) ) );

register_activation_hook( __FILE__, array( Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( Deactivator::class, 'deactivate' ) );

// disable comments globally
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
add_filter('acf/settings/show_admin', '__return_false');
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_site_functionality(): Site_Functionality {

	$settings = new Settings();

	$plugin = new Site_Functionality( $settings );

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['site_functionality'] = instantiate_site_functionality();
