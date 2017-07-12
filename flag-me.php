<?php
/*
Plugin Name:	Flag Me
Plugin URI:	http://www.fahien.me/flag-me
Description:	Flag Me enables you to add a country flag before the title of your posts or pages.
Version:	0.2
Author:		Antonio Caggiano
Author URI:	http://www.fahien.me
License:	GPL3
License URI:    https://www.gnu.org/licenses/gpl-3.0.html
Domain Path:    /languages
Text Domain:    flag-me
*/

/*
 * Use plugin_dir_path() end plugins_url() for absolute paths and URLs
 */

/*
 * Block direct access to plugin files
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please' );

/*
 * Initialize the Flag Me plugin
 */
if ( ! function_exists( 'flagme_init' ) ) {
	function flagme_init() {
		wp_register_style( 'flagme_css', plugins_url( 'css/flag-me.css', __FILE__ ) );
		wp_enqueue_style( 'flagme_css' );
	}
	add_action( 'init', 'flagme_init' );
}

/*
 * Load Text Domain
 */
if ( ! function_exists( 'flagme_load_textdomain' ) ) {
        function flagme_load_textdomain() {
                load_plugin_textdomain(
			'flag-me',
			FALSE,
			basename( dirname( __FILE__) ) . '/languages/'
		);
        }
        add_action( 'plugins_loaded', 'flagme_load_textdomain' );
}

/*
 * Separate admin code using the conditional is_admin()
 * to prevent it from loading when not needed
 */
if ( is_admin() ) {
	// We are in admin mode
	require_once( plugin_dir_path( __FILE__ ).'/admin/flag-me_admin.php' );
}

/*
 * Modify the title of a post, adding the appropriate international flag
 */
if ( ! function_exists( 'flagme_modify_the_title' ) ) {
	function flagme_modify_the_title( $title, $id ) {
		// Do not modify if we are in the admin section
		// or in the display posts loop
		if ( is_admin() || in_the_loop() ) {
			return $title;
		}
		$language = get_post_meta( $id, 'flagme-language', true );
		$language = esc_attr( $language );
		// Do not modify if the language field is not set
		if ( $language == "" ) {
			return $title;
		}
		$flag = '<span class="flagme flagme-' . $language . '"></span>';
		$title = $flag . $title;
		return $title;
	}
	add_filter( 'the_title', 'flagme_modify_the_title', 10, 2 );
}

?>
