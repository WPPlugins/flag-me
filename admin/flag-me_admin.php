<?php
/*
 * Administration Menu
 */
if ( ! function_exists( 'flagme_add_menu' ) && 
	! function_exists( 'flagme_page_function' ) ) {
	/*
	 * Create the admin plugin page
	 */
	function flagme_page_function() {
		?>
		<div class="wrap">
			<h2>
				Flag Me
				<?php _e( 'Options', 'flag-me' ); ?>
			</h2>
			<p>
				<?php _e( 'Currently there are', 'flag-me' ); ?>
				<strong><?php _e( 'no options', 'flag-me' ); ?></strong>. 
				<?php _e( 'See you later', 'flag-me' ); ?>!
			</p>
		</div>
		<?php 
	}

	/*
	 * Add the plugin menu to the admin area
	 */
	function flagme_add_menu() {
		add_menu_page (
			'Flag Me',
			'Flag Me',
			'manage_options',
			'flag-me',
			'flagme_page_function',
			'dashicons-translation',
			'22.23'
		);
	}
	add_action( 'admin_menu', 'flagme_add_menu' );
}

/*
 * Add the Language Meta Box to the post edit screen
 */
if ( ! function_exists( 'flagme_add_language_box' ) &&
	! function_exists( 'flagme_inner_language_box' ) &&
	! function_exists( 'flagme_save_postdata' ) ) {

	/*
	 * Save Post Language Metadata
	 */
	function flagme_save_postdata( $post_id ) {
		if ( array_key_exists( 'flagme-language', $_POST ) ) {
			$language = sanitize_text_field( $_POST['flagme-language'] );
			update_post_meta ( $post_id, 'flagme-language', $language );
		}
	}
	add_action( 'save_post', 'flagme_save_postdata' );

	/*
	 * Create the Language Box Form
	 */
	function flagme_inner_language_box( $post ) {
		$languages = array(
			array( 'العربية', 'ar' ),
			array( 'Deutsch', 'de' ),
			array( 'English', 'en' ),
			array( 'Español', 'es' ),
			array( 'فارسی', 'fa' ),
			array( 'Suomi', 'fi' ),
			array( 'Français', 'fr' ),
			array( 'Italiano', 'it' ),
			array( '日本語', 'ja' ),
			array( 'Nederlands', 'nl' ),
			array( 'Norsk bokmål', 'no' ),
			array( 'Polski', 'pl' ),
			array( 'Português', 'pt' ),
			array( 'Русский', 'ru' ),
			array( 'Svenska', 'sv' ),
			array( 'Українська', 'uk' ),
			array( 'Tiếng Việt', 'vi' ),			
			array( '中文', 'zh' )
		);
		$value = get_post_meta( $post->ID, 'flagme-language', true);
		?>
		<select name="flagme-language" id="flagme-language" class="postbox">
			<option value="">
				<?php _e( 'Select language', 'flag-me' ); ?>
			</option>
			<?php
			foreach ( $languages as $language ) {
				echo '<option value="' . $language[1] . '"';
				if ( $language[1] == $value ) echo 'selected="selected"';
				echo '>' . $language[0] . '</option>';
			}
			?>
		</select>
		<?php
	}

	/*
	 * Create the Language Meta Box
	 */
	function flagme_add_language_box() {
		$screens = array( 'post', 'page' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'flagme_language_box',		// Unique ID
				__( 'Language', 'flag-me' ),	// Box Title
				'flagme_inner_language_box',	// Content callback
				$screen,			// The type of writing screen
				'side'				// The part of the page
			);
		}
	}
	add_action( 'add_meta_boxes', 'flagme_add_language_box' );
}
?>
