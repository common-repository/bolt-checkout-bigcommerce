<?php

namespace BoltBigcommerce;
/**
 * Bolt Checkout for BigCommerce.
 *
 * @link              http://bolt.com
 * @since             1.0.0
 * @package           Bigcommerce_Bolt_Checkout
 *
 * Plugin Name:       Bolt Checkout for BigCommerce
 * Plugin URI:        http://bolt.com
 * Description:       It adds Bolt checkout to the Wordpress store using BigCommerce ECommerce plugin.
 * Version:           1.0.0
 * Author:            Bolt
 * Author URI:        https://bolt.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

define( 'BIGCOMMERCE_FOR_WORDPRESS_MAIN_PATH', 'bigcommerce-for-wordpress/bigcommerce.php' );
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'BOLT_BIGCOMMERCE_MAIN_PATH' ) ) {
	define( 'BOLT_BIGCOMMERCE_MAIN_PATH', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'BOLT_BIGCOMMERCE_PLUGIN_DIR' ) ) {
	define( 'BOLT_BIGCOMMERCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'BOLT_BIGCOMMERCE_PLUGIN_URL' ) ) {
	define( 'BOLT_BIGCOMMERCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Check if bigcommerce plugin installed and enables
if ( in_array( BIGCOMMERCE_FOR_WORDPRESS_MAIN_PATH, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! defined( 'BOLT_BIGCOMMERCE_VERSION' ) ) {
		$plugin_bolt_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
		define( 'BOLT_BIGCOMMERCE_VERSION', $plugin_bolt_data['Version'] );
	}
	if ( ! defined( 'BIGCOMMERCE_VERSION' ) ) {
		$plugin_bigcommerce_data = get_file_data( WP_PLUGIN_DIR . '/' . BIGCOMMERCE_FOR_WORDPRESS_MAIN_PATH, array( 'Version' => 'Version' ), false );
		define( 'BIGCOMMERCE_VERSION', $plugin_bigcommerce_data['Version'] );
	}

	// Check if there is admin user
	if ( is_admin() ) {
		require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-bigcommerce-wordpress-admin.php' );
		$bolt_bigcommerce = new Bolt_Bigcommerce_Wordpress_Admin();
	} else {
		require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-bigcommerce-wordpress.php' );
		$bolt_bigcommerce = new Bolt_Bigcommerce_Wordpress();
	}

	// Include Bugsnag Class.
	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/BugsnagHelper.php' );
	BugsnagHelper::initBugsnag();

	// include Bolt API
	require( dirname( __FILE__ ) . '/lib/bolt-php/init.php' );

	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/trait-bolt-order.php' );

	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-logger.php' );

	//class for confirmation page
	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-confirmation-page.php' );

	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-discounts-helper.php' );

	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-checkout.php' );

	require_once( BOLT_BIGCOMMERCE_PLUGIN_DIR . '/src/class-bolt-cart.php' );

	$bolt_bigcommerce->init();
}