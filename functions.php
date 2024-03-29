<?php
/**
 * Bootship functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @since Bootship 0.1
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see bootship_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 730;

/**
 * Bootship setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Bootship supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Bootship 0.1
 */
function bootship_setup() {
	/*
	 * Makes Bootship available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Bootship, use a find and
	 * replace to change 'bootship' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'bootship', get_template_directory() . '/languages' );

  /*
   * This theme styles the visual editor to resemble the theme style,
   * specifically font, colors, icons, and column width.
   */
  add_theme_support( 'editor-styles' );
  add_editor_style( array( 'css/editor-style.css', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', 'css/bootstrap.css', bootship_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
  
  // Adds support for WooCommerce customization
  add_theme_support( 'woocommerce' );

  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
  add_theme_support( 'html5', array(
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'
  ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'bootship' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 728, 300, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'bootship_setup' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans 3 and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Bootship 0.1
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function bootship_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans 3, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans 3 font: on or off', 'bootship' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'bootship' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans 3:200,300,400,500,600,700,800,900,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Bootship 0.1
 */
function bootship_scripts_styles() {
  /*
   * Adds JavaScript to pages with the comment form to support
   * sites with threaded comments (when in use).
   */
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );

  // Adds Masonry to handle vertical alignment of footer widgets.
  if ( is_active_sidebar( 'sidebar-1' ) )
    wp_enqueue_script( 'jquery-masonry' );

  // Loads JavaScript file with functionality specific to Boot Ship.
  wp_enqueue_script( 'bootship-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery', 'wow', 'slick' ), '2020-08-09', true );
  wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.js', array(), '1.16.1', true );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery', 'popper' ), '5.3.3', true );

  // WOW.js @link https://github.com/matthieua/WOW
  wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js', array( 'jquery' ), '1.3.0', true );
  
  // Slick.js @link https://kenwheeler.github.io/slick/
  wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.js', array( 'jquery' ), '1.8.1', true );

  // Add Source Sans 3 and Bitter fonts, used in the main stylesheet.
  wp_enqueue_style( 'bootship-fonts', bootship_fonts_url(), array(), null );

  // Loads our main stylesheet.
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '5.3.3' );
  wp_enqueue_style( 'bootstrap-icons', get_template_directory_uri() . '/css/bootstrap-icons.css', array(), '1.11.3' );
  wp_enqueue_style( 'bootship-theme', get_template_directory_uri() . '/css/theme.css', array(), '2021-11-28' );
  wp_enqueue_style( 'bootship-default', get_template_directory_uri() . '/css/default.css', array(), '2021-11-28' );
  wp_enqueue_style( 'bootship-style', get_stylesheet_uri(), array(), '2016-08-09' );

  // Font Awesome stylesheet
  wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', array(), '5.15.4' );

  // Animate CSS @link: https://animate.style stylesheet
  wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '4.1.1' );

  // Hover CSS @link: https://github.com/IanLunn/Hover stylesheet
  wp_enqueue_style( 'hover', get_template_directory_uri() . '/css/hover.css', array(), '2.3.2' );
  
  // Slick.css @link https://kenwheeler.github.io/slick/
  wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), 'v1.8.1' );
  wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/css/slick-theme.css', array(), 'v1.8.1' );

  // Loads the Internet Explorer specific stylesheet.
  wp_enqueue_style( 'bootship-ie', get_template_directory_uri() . '/css/ie.css', array( 'bootship-style' ), '2016-08-09' );
  wp_style_add_data( 'bootship-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'bootship_scripts_styles');

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Bootship 0.1
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function bootship_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'bootship' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'bootship_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Bootship 0.1
 */
function bootship_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'bootship' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'bootship' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'bootship' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'bootship' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'bootship_widgets_init' );

if ( ! function_exists( 'bootship_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Bootship 0.1
 */
function bootship_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'bootship' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bootship' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bootship' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'bootship_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Bootship 0.1
*/
function bootship_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'bootship' ); ?></h1>
		<div class="nav-links">
			<div class="nav-previous">
				<?php previous_post_link( '<span class="nav-links__label">' . esc_html__( 'Previous Article', 'bootship' ) . '</span> %link' ); ?>
			</div>
			
			<div class="nav-next">
				<?php next_post_link( '<span class="nav-links__label">' . esc_html__( 'Next Article', 'bootship' ) . '</span> %link' ); ?>
			</div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'bootship_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own bootship_entry_meta() to override in a child theme.
 *
 * @since Bootship 0.1
 */
function bootship_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'bootship' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		bootship_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'bootship' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'bootship' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'bootship' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'bootship_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own bootship_entry_date() to override in a child theme.
 *
 * @since Bootship 0.1
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function bootship_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'bootship' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'bootship' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'bootship_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Bootship 0.1
 */
function bootship_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Bootship 0.1
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'bootship_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Bootship 0.1
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function bootship_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'bootship_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Bootship 0.1
 */
function bootship_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'bootship_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Bootship 0.1
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function bootship_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'bootship_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Bootship 0.1
 */
function bootship_customize_preview_js() {
	wp_enqueue_script( 'bootship-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'bootship_customize_preview_js' );

/**
 * Register Projects posts types.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 *
 * @since bootship 0.1
 */
function bootship_register_post_type() {
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name', 'bootship' ),
		'singular_name'      => _x( 'Project', 'post type singular name', 'bootship' ),
		'menu_name'          => _x( 'Projects', 'admin menu', 'bootship' ),
		'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'bootship' ),
		'add_new'            => _x( 'Add New', 'project', 'bootship' ),
		'add_new_item'       => __( 'Add New Project', 'bootship' ),
		'new_item'           => __( 'New Project', 'bootship' ),
		'edit_item'          => __( 'Edit Project', 'bootship' ),
		'view_item'          => __( 'View Project', 'bootship' ),
		'all_items'          => __( 'All Projects', 'bootship' ),
		'search_items'       => __( 'Search Projects', 'bootship' ),
		'parent_item_colon'  => __( 'Parent Projects:', 'bootship' ),
		'not_found'          => __( 'No projects found.', 'bootship' ),
		'not_found_in_trash' => __( 'No projects found in Trash.', 'bootship' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'bootship' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'project', $args );
}
add_action( 'init', 'bootship_register_post_type' );

/**
 * Add meta boxes to the post edit screen.
 *
 * @since bootship 0.1
 */
function bootship_add_meta_boxes() {
	add_meta_box( 'project_details', __( 'Contactor', 'bootship' ), 'project_details', 'project', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'bootship_add_meta_boxes' );

/**
 * Output meta box Petition details.
 *
 * @since bootship 0.1
 */
function project_details( $post ) {
	$project_contractor_name = get_post_meta( $post->ID, '_project_contractor_name', true );

	echo '<p>';
		echo '<label for="project_contractor_name">' . __('Name:', 'bootship' ) . '</label> ';
		echo '<input id="project_contractor_name" name="project_contractor_name" type="text" style="width:99%;" value="' . $project_contractor_name . '" />';
	echo '</p>';
}

/**
 * Save content posted in custom meta boxes.
 *
 * @since bootship 0.1
 */
function bootship_save_post( $post_id, $post ) {
	if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || defined('DOING_AJAX') )
		return $post_id;

	if( 'project' == $post->post_type ) {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;

		if ( isset( $_POST['project_contractor_name'] ) )
			update_post_meta( $post_id, '_project_contractor_name', $_POST['project_contractor_name'] );
	}
	return $post_id;
}
add_action( 'save_post', 'bootship_save_post', 10, 2 );
