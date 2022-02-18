<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentytwenty_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'twentytwenty' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwenty' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', twentytwenty_get_starter_content() );
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'twentytwenty_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-twentytwenty-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Register and Enqueue Styles.
 */
function twentytwenty_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'twentytwenty-style', twentytwenty_get_customizer_css( 'front-end' ) );

	// Add print CSS.
	wp_enqueue_style( 'twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function twentytwenty_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
	wp_script_add_data( 'twentytwenty-js', 'async', true );

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );

/** Enqueue non-latin language styles
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_non_latin_languages() {
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'twentytwenty-style', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_non_latin_languages' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function twentytwenty_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'twentytwenty' ),
		'expanded' => __( 'Desktop Expanded Menu', 'twentytwenty' ),
		'mobile'   => __( 'Mobile Menu', 'twentytwenty' ),
		'footer'   => __( 'Footer Menu', 'twentytwenty' ),
		'social'   => __( 'Social Menu', 'twentytwenty' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function twentytwenty_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'twentytwenty_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function twentytwenty_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'twentytwenty' ) . '</a>';
}

add_action( 'wp_body_open', 'twentytwenty_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'twentytwenty' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'twentytwenty' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty' ),
			)
		)
	);

}

add_action( 'widgets_init', 'twentytwenty_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function twentytwenty_block_editor_styles() {

	// Enqueue the editor styles.
	wp_enqueue_style( 'twentytwenty-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_style_add_data( 'twentytwenty-block-editor-styles', 'rtl', 'replace' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', twentytwenty_get_customizer_css( 'block-editor' ) );

	// Add inline style for non-latin fonts.
	wp_add_inline_style( 'twentytwenty-block-editor-styles', TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'twentytwenty-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'twentytwenty_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 */
function twentytwenty_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'twentytwenty_classic_editor_styles' );

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_customizer_styles( $mce_init ) {

	$styles = twentytwenty_get_customizer_css( 'classic-editor' );

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_customizer_styles' );

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_non_latin_styles( $mce_init ) {

	$styles = TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'classic-editor' );

	// Return if there are no styles to add.
	if ( ! $styles ) {
		return $mce_init;
	}

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'twentytwenty_add_classic_editor_non_latin_styles' );

/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 */
function twentytwenty_block_editor_settings() {

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'twentytwenty' ),
			'slug'  => 'accent',
			'color' => twentytwenty_get_color_for_area( 'content', 'accent' ),
		),
		array(
			'name'  => _x( 'Primary', 'color', 'twentytwenty' ),
			'slug'  => 'primary',
			'color' => twentytwenty_get_color_for_area( 'content', 'text' ),
		),
		array(
			'name'  => _x( 'Secondary', 'color', 'twentytwenty' ),
			'slug'  => 'secondary',
			'color' => twentytwenty_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'twentytwenty' ),
			'slug'  => 'subtle-background',
			'color' => twentytwenty_get_color_for_area( 'content', 'borders' ),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'twentytwenty' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'twentytwenty' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'twentytwenty' ),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'twentytwenty' ),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'twentytwenty' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( twentytwenty_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}

}

add_action( 'after_setup_theme', 'twentytwenty_block_editor_settings' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function twentytwenty_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'twentytwenty_read_more_tag' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_controls_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main customizer js file.
	wp_enqueue_script( 'twentytwenty-customize', get_template_directory_uri() . '/assets/js/customize.js', array( 'jquery' ), $theme_version, false );

	// Add script for color calculations.
	wp_enqueue_script( 'twentytwenty-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array( 'wp-color-picker' ), $theme_version, false );

	// Add script for controls.
	wp_enqueue_script( 'twentytwenty-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'twentytwenty-color-calculations', 'customize-controls', 'underscore', 'jquery' ), $theme_version, false );
	wp_localize_script( 'twentytwenty-customize-controls', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
}

add_action( 'customize_controls_enqueue_scripts', 'twentytwenty_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_preview_init() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'twentytwenty-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars() );
	wp_localize_script( 'twentytwenty-customize-preview', 'twentyTwentyPreviewEls', twentytwenty_get_elements_array() );

	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode( 'cover_opacity' ),
			wp_json_encode( twentytwenty_customize_opacity_range() )
		)
	);
}

add_action( 'customize_preview_init', 'twentytwenty_customize_preview_init' );

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function twentytwenty_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function twentytwenty_get_elements_array() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
				'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
				'background-color' => array( 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
				'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
			),
			'background' => array(
				'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
				'background-color' => array( ':root .has-background-background-color' ),
			),
			'text'       => array(
				'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
				'background-color' => array( ':root .has-primary-background-color' ),
			),
			'secondary'  => array(
				'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
				'background-color' => array( ':root .has-secondary-background-color' ),
			),
			'borders'    => array(
				'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
				'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
				'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
				'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
				'color'               => array( ':root .has-subtle-background-color' ),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
				'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
			),
			'background' => array(
				'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
				'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
			),
			'text'       => array(
				'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
				'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
				'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
				'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
			),
			'secondary'  => array(
				'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
			),
			'borders'    => array(
				'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
				'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
			),
		),
	);

	/**
	* Filters Twenty Twenty theme elements
	*
	* @since Twenty Twenty 1.0
	*
	* @param array Array of elements
	*/
	return apply_filters( 'twentytwenty_get_elements_array', $elements );
}

function create_post_type_products() {
	register_post_type( 'produtos',
	array(
			'labels' => array(
					'name' => __( 'Produtos' ),
					'singular_name' => __( 'Produto' )
			),
	'public' => true,
	'has_archive' => true,
	//'taxonomies' => array( 'category', 'post_tag' ),
	'supports' => array('title', 'editor', 'thumbnail', 'comments'),
	'menu_position' => 5,
	'menu_icon' => 'dashicons-cart',
	)
);
register_taxonomy('categorias', ['produtos'], [
	'label' => __('Categorias', 'txtdomain'),
	'hierarchical' => true,
	'rewrite' => ['slug' => 'produtos-categorias'],
	'show_admin_column' => true,
	'show_in_rest' => true,
	'labels' => [
		'singular_name' => __('Categorias', 'txtdomain'),
		'all_items' => __('Todas as Categorias', 'txtdomain'),
		'edit_item' => __('Editar Categoria', 'txtdomain'),
		'view_item' => __('Ver Categoria', 'txtdomain'),
		'update_item' => __('Atualizar Categoria', 'txtdomain'),
		'add_new_item' => __('Adicionar Categoria', 'txtdomain'),
		'new_item_name' => __('Novo nome para categoria', 'txtdomain'),
		'search_items' => __('Procurar Categoria', 'txtdomain'),
		'parent_item' => __('Categoria Ascendente', 'txtdomain'),
		'parent_item_colon' => __('Parent Categoria:', 'txtdomain'),
		'not_found' => __('Nenhuma categoria encontrada', 'txtdomain'),
	]
]);
register_taxonomy_for_object_type('categorias', 'produtos');



}
add_action( 'init', 'create_post_type_products' );



function colorpicker_field_add_new_category( $taxonomy ) { ?> 
	<div class="form-field term-colorpicker-wrap"> 
	<label for="term-colorpicker">Cor da Categoria</label> 
	<input name="_category_color" value="#ffffff" class="colorpicker" id="term-colorpicker" /> 
	<p>Escolha uma cor para representar a categoria.</p> 
	</div> <?php } 
	add_action( 'categorias_add_form_fields', 'colorpicker_field_add_new_category' ); // Variable Hook Name

	function colorpicker_field_edit_category( $term ) { 
		$color = get_term_meta( $term->term_id, '_category_color', true ); 
		$color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff'; ?> 
		<tr class="form-field term-colorpicker-wrap"> 
		<th scope="row">
		<label for="term-colorpicker">Editar a cor da categoria</label>
		</th> 
		<td> 
		<input name="_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" /> 
		<p class="description">Escolha uma cor para representar a categoria.</p> 
		</td> 
		</tr> <?php } 
		add_action( 'categorias_edit_form_fields', 'colorpicker_field_edit_category' ); // Variable Hook Name


		function save_termmeta( $term_id ) { 
			// Save term color if possible 
			if( isset( $_POST['_category_color'] ) && ! empty( $_POST['_category_color'] ) ) { 
			update_term_meta( $term_id, '_category_color', sanitize_hex_color_no_hash( $_POST['_category_color'] ) ); 
			} else { delete_term_meta( $term_id, '_category_color' ); 
			} 
			update_term_meta( $term_id, '_category_image', $_POST['imagem_base64'] ); 
		} 
			add_action( 'created_categorias', 'save_termmeta' ); // Variable Hook Name add_action( 'edited_category', 'save_termmeta' ); // Variable Hook Nam
			add_action( 'edited_categorias', 'save_termmeta' );

			function category_colorpicker_enqueue( $taxonomy ) { 
				if( null !== ( $screen = get_current_screen() ) && 'edit-categorias' !== $screen->id ) { 
				return; 
				} 
				// Colorpicker Scripts 
				wp_enqueue_script( 'wp-color-picker' ); 
				// Colorpicker Styles 
				wp_enqueue_style( 'wp-color-picker' ); } 
				add_action( 'admin_enqueue_scripts', 'category_colorpicker_enqueue' );
			

				function colorpicker_init_inline() { 
					if( null !== ( $screen = get_current_screen() ) && 'edit-categorias' !== $screen->id ) { 
					return; 
					} ?> 
					<script> 
					jQuery( document ).ready( function( $ ) {
					 $( '.colorpicker' ).wpColorPicker(); 
					} ); 
					// End Document Ready JQuery 
					</script> 
					<?php } add_action( 'admin_print_scripts', 'colorpicker_init_inline', 20 );


function the_category_colors($categoriaAtual) { 

			$categories = get_terms('categorias', array('hide_empty' => false)); 
			for($i=0;$i<sizeof($categories);$i++):
				if($categories[$i]->name == $categoriaAtual):
					$color = get_term_meta( $categories[$i]->term_id, '_category_color', true ); 
					$color = ( ! empty( $color ) ) ? "#{$color}" : '#000000'; $separator = ''; $output = ''; 
					$link = get_term_link( $categories[$i]->term_id,'categorias');
						 echo $output ="<span><a style='color:$color' href='$link'>".$categories[$i]->name."</a></span>";
					return;
				endif;
			endfor;

		} 

function campo_imagem(  ) { ?> 
		<div class="form-field term-group">
        <label for="">Fazer upload de imagem</label>
				<input type="file" onchange="encodeImageFileAsURL(this)" />
				<input type='hidden' name='imagem_base64' id='imagem_base64'></input>
    </div>
<?php } 



function imageToBase64_script(){?>
	<script>
	function encodeImageFileAsURL(element) {
		var file = element.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			//console.log('RESULT', reader.result)
			document.getElementById("imagem_base64").value = reader.result;
		}
		reader.readAsDataURL(file);
	}
	</script>
<?php }
add_action( 'admin_print_scripts', 'imageToBase64_script' );
add_action( 'categorias_add_form_fields', 'campo_imagem' );
add_action( 'categorias_edit_form', 'campo_imagem' );

function campos_extras_produtos() {
	$screens = [ 'produtos' ];

	foreach ( $screens as $screen ) {
			add_meta_box(
					'wporg_box_id',                 // Unique ID
					'Sobre o produto: ',      // Box title
					'mostrar_campos',  // Content callback, must be of type callable
					$screen                            // Post type
			);
	}
}
add_action( 'add_meta_boxes', 'campos_extras_produtos' );

function mostrar_campos( $post ) {
	$valor = get_post_meta( $post->ID, '_valor_meta_key', true );
	$estoque = get_post_meta( $post->ID, '_estoque_meta_key', true );
	$desconto = get_post_meta( $post->ID, '_desconto_meta_key', true );

    ?>
		
		<label>Valor: </label>
	
		<input name='valor' type="number" min="0.00" max="10000.00" step="0.01" value='<?php echo $valor ?>'/>
		<label>Estoque: </label>
		<input name='estoque'  type="number" min="0" max="1000000" step="1" value='<?php echo $estoque; ?>' /><br>

		<input onclick="checkado(this)" name='checkbox' type="checkbox" id="checkboxL">
		<span>Desconto</span>
		<input id='desconto'  name='desconto' style='display:none'  type="number"min="0.00" max="10000.00" step="0.01" value='<?php echo $desconto; ?>' />
    <?php
}

function wporg_save_postdata( $post_id ) {
	if ( array_key_exists( 'valor', $_POST ) ) {
			update_post_meta(
					$post_id,
					'_valor_meta_key',
					$_POST['valor']
			);
	}


	if ( array_key_exists( 'estoque', $_POST ) ) {
		update_post_meta(
				$post_id,
				'_estoque_meta_key',
				$_POST['estoque']
		);
	}


	if ( array_key_exists( 'desconto', $_POST ) ) {
		update_post_meta(
				$post_id,
				'_desconto_meta_key',
				$_POST['desconto']
		);
	}
}
add_action( 'save_post', 'wporg_save_postdata' );


function mostrarDesconto_script(){?>
<script>
window.onload = function(){
	if(document.getElementById("desconto").value != ""){
		document.getElementById("checkboxL").click();
	}
}

function checkado($checkbox){

	if ($checkbox.checked == true){
		document.getElementById("desconto").style.display="inline";
  }else{
		document.getElementById("desconto").style.display="none";;
		document.getElementById("desconto").value="";
	}
}

</script>
<?php }



add_action( 'admin_print_scripts', 'mostrarDesconto_script' );


function custom_user_profile_fields($user){
  ?>
    <h3>Informações Extras</h3>
    <table class="form-table">
        <tr>
            <th><label for="telefone">Telefone</label></th>
            <td>
                <input type="text" class="regular-text" name="telefone" value="<?php echo esc_attr( get_the_author_meta( 'telefone_meta_key', $user->ID ) ); ?>" id="telefone" /><br />
            </td>
						
        </tr>
				<tr>
            <th><label for="estado">Estado</label></th>
            <td>
                <input type="text" class="regular-text" name="estado" value="<?php echo esc_attr( get_the_author_meta( 'estado_meta_key', $user->ID ) ); ?>" id="estado" /><br />
            </td>
        </tr>		
				<tr>
            <th><label for="cidade">Cidade</label></th>
            <td>
                <input type="text" class="regular-text" name="cidade" value="<?php echo esc_attr( get_the_author_meta( 'cidade_meta_key', $user->ID ) ); ?>" id="cidade" /><br />
            </td>
        </tr>
				<tr>
            <th><label for="bairro">Bairro</label></th>
            <td>
                <input type="text" class="regular-text" name="bairro" value="<?php echo esc_attr( get_the_author_meta( 'bairro_meta_key', $user->ID ) ); ?>" id="bairro" /><br />
            </td>
        </tr>			
				<tr>
            <th><label for="rua">Rua</label></th>
            <td>
                <input type="text" class="regular-text" name="rua" value="<?php echo esc_attr( get_the_author_meta( 'rua_meta_key', $user->ID ) ); ?>" id="rua" /><br />
            </td>
        </tr>	
				<tr>
            <th><label for="numero">Número</label></th>
            <td>
                <input type="text" class="regular-text" name="numero" value="<?php echo esc_attr( get_the_author_meta( 'numero_meta_key', $user->ID ) ); ?>" id="numero" /><br />
            </td>
        </tr>	
				<tr>
            <th><label for="complemento">Complemento</label></th>
            <td>
                <input type="text" class="regular-text" name="complemento" value="<?php echo esc_attr( get_the_author_meta( 'complemento_meta_key', $user->ID ) ); ?>" id="complemento" /><br />
            </td>
        </tr>	
				<tr>
            <th><label for="cpf">CPF</label></th>
            <td>
                <input type="text" class="regular-text" name="cpf" value="<?php echo esc_attr( get_the_author_meta( 'cpf_meta_key', $user->ID ) ); ?>" id="cpf" /><br />
            </td>
        </tr>	
				<tr>
            <th><label for="nascimento">Data de nascimento</label></th>
            <td>
                <input type="text" class="regular-text" name="nascimento" value="<?php echo esc_attr( get_the_author_meta( 'nascimento_meta_key', $user->ID ) ); ?>" id="nascimento" /><br />
            </td>
        </tr>	
    </table>
  <?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
	# again do this only if you can
	if(!current_user_can('manage_options'))
			return false;

	# save my custom field
	update_usermeta($user_id, 'telefone_meta_key', $_POST['telefone']);
	update_usermeta($user_id, 'estado_meta_key', $_POST['estado']);
	update_usermeta($user_id, 'cidade_meta_key', $_POST['cidade']);
	update_usermeta($user_id, 'bairro_meta_key', $_POST['bairro']);
	update_usermeta($user_id, 'rua_meta_key', $_POST['rua']);
	update_usermeta($user_id, 'numero_meta_key', $_POST['numero']);
	update_usermeta($user_id, 'complemento_meta_key', $_POST['complemento']);
	update_usermeta($user_id, 'cpf_meta_key', $_POST['cpf']);
	update_usermeta($user_id, 'nascimento_meta_key', $_POST['nascimento']);
}
add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

function wpse27856_set_content_type(){
	return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );



function colorpicker_field_add_new_category_posts( $taxonomy ) { ?> 
	<div class="form-field term-colorpicker-wrap"> 
	<label for="term-colorpicker">Cor da Categoria</label> 
	<input name="_category_color" value="#ffffff" class="colorpicker" id="term-colorpicker" /> 
	<p>Escolha uma cor para representar a categoria.</p> 
	</div> <?php } 
	add_action( 'category_add_form_fields', 'colorpicker_field_add_new_category_posts' ); // Variable Hook Name

	function colorpicker_field_edit_category_posts( $term ) { 
		$color = get_term_meta( $term->term_id, '_category_color', true ); 
		$color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff'; ?> 
		<tr class="form-field term-colorpicker-wrap"> 
		<th scope="row">
		<label for="term-colorpicker">Editar a cor da categoria</label>
		</th> 
		<td> 
		<input name="_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" /> 
		<p class="description">Escolha uma cor para representar a categoria.</p> 
		</td> 
		</tr> <?php } 
		add_action( 'category_edit_form_fields', 'colorpicker_field_edit_category_posts' ); // Variable Hook Name


		function category_colorpicker_enqueue_posts( $taxonomy ) { 
			if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) { 
			return; 
			} 
			// Colorpicker Scripts 
			wp_enqueue_script( 'wp-color-picker' ); 
			// Colorpicker Styles 
			wp_enqueue_style( 'wp-color-picker' ); } 
			add_action( 'admin_enqueue_scripts', 'category_colorpicker_enqueue_posts' );
		

			function colorpicker_init_inline_posts() { 
				if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) { 
				return; 
				} ?> 
				<script> 
				jQuery( document ).ready( function( $ ) {
				 $( '.colorpicker' ).wpColorPicker(); 
				} ); 
				// End Document Ready JQuery 
				</script> 
				<?php } add_action( 'admin_print_scripts', 'colorpicker_init_inline_posts', 20 );


function save_termmeta_posts( $term_id ) { 
	// Save term color if possible 
	if( isset( $_POST['_category_color'] ) && ! empty( $_POST['_category_color'] ) ) { 
	update_term_meta( $term_id, '_category_color', sanitize_hex_color_no_hash( $_POST['_category_color'] ) ); 
	} else { delete_term_meta( $term_id, '_category_color' ); 
	} 
	update_term_meta( $term_id, '_category_image', $_POST['imagem_base64'] ); 
} 
	add_action( 'created_category', 'save_termmeta_posts' ); // Variable Hook Name add_action( 'edited_category', 'save_termmeta' ); // Variable Hook Nam
	add_action( 'edited_category', 'save_termmeta_posts' );




	function campo_imagem_posts(  ) { ?> 
		<div class="form-field term-group">
        <label for="">Fazer upload de imagem</label>
				<input type="file" onchange="encodeImageFileAsURL(this)" />
				<input type='hidden' name='imagem_base64' id='imagem_base64'></input>
    </div>
<?php } 



function imageToBase64_script_posts(){?>
	<script>
	function encodeImageFileAsURL(element) {
		var file = element.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			//console.log('RESULT', reader.result)
			document.getElementById("imagem_base64").value = reader.result;
		}
		reader.readAsDataURL(file);
	}
	</script>
<?php }
add_action( 'admin_print_scripts', 'imageToBase64_script_posts' );
add_action( 'category_add_form_fields', 'campo_imagem_posts' );

add_action( 'category_edit_form', 'campo_imagem_posts' );


add_filter( 'get_the_archive_title', function ($title) {    
	if ( is_category() ) {    
					$title = single_cat_title( '', false );    
			} elseif ( is_tag() ) {    
					$title = single_tag_title( '', false );    
			} elseif ( is_author() ) {    
					$title = '<span class="vcard">' . get_the_author() . '</span>' ;    
			} elseif ( is_tax() ) { //for custom post types
					$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
			} elseif (is_post_type_archive()) {
					$title = post_type_archive_title( '', false );
			}
	return $title;    
});

function wpse_172645_get_post_types_by_taxonomy( $tax = 'category' )
{
    global $wp_taxonomies;
    return ( isset( $wp_taxonomies[$tax] ) ) ? $wp_taxonomies[$tax]->object_type : array();
}

add_action('admin_menu', 'news_admin_test');
function news_admin_test() {
    add_menu_page( 'News Page Title', 'Pagamentos', 'manage_options', 'newspage', 'show_menu_news','dashicons-money-alt',6 );
}

function show_menu_news () {
	global $wpdb;
	$sql = 'SELECT * FROM wp_pagamentos';
	$res = $wpdb->get_results($sql);
echo "<h1>Todos os Pagamentos</h1>";



    echo "
		<table id='table' style='border:solid 1px black;'>
    <thead>
      <tr>
        <th style='text-align:center'>TIPO</th>
        <th style='text-align:center'>VALOR</th>
        <th style='text-align:center'>ITEMS</th>
        <th style='text-align:center'>STATUS</th>
				<th style='text-align:center'>CLIENTE</th>
      </tr>
    </thead>
    <tbody>";
		foreach($res as $item):
		


		echo "
      <tr>
        <td style='text-align:center'>$item->tipo</td>
        <td>R$ $item->total_carrinho</td>
        <td>$item->carrinho</td>
        <td>$item->status</td>
				<td>$item->email_cliente</td>
      </tr>";
		endforeach;
             
echo "</table>";
echo "<a id='downloadLink' onclick='exportF(this)'>Exportar para Excel</a>";



}

function exportar(){?>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
	<script>
function exportF(elem) {
  var table = document.getElementById("table");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "export.xls"); // Choose the file name
  return false;
}
	</script>
<?php }

add_action( 'admin_print_scripts', 'exportar' );


