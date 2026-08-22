<?php
/**
 * Farway theme functions and definitions.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'FARWAY_VERSION', '1.2.0' );

require_once get_template_directory() . '/inc/customizer.php';

/**
 * Theme setup.
 */
function farway_setup() {
	load_theme_textdomain( 'farway', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', array(
		'height'      => 40,
		'width'       => 40,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Booking flow sits in front of WooCommerce when it is installed.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	add_theme_support( 'custom-header', array(
		'width'       => 1200,
		'height'      => 600,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	add_theme_support( 'custom-background', array(
		'default-color' => '101f30',
	) );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'farway' ),
	) );
}
add_action( 'after_setup_theme', 'farway_setup' );

/**
 * Register a custom block style.
 */
function farway_register_block_styles() {
	register_block_style( 'core/button', array(
		'name'  => 'farway-outline',
		'label' => __( 'Outline', 'farway' ),
	) );
}
add_action( 'init', 'farway_register_block_styles' );

/**
 * Register custom block patterns.
 */
function farway_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern(
		'farway/travel-promo',
		array(
			'title'       => __( 'Travel promo', 'farway' ),
			'description' => __( 'A heading and paragraph with a call-to-action button for travel offers.', 'farway' ),
			'categories'  => array( 'text' ),
			'content'     => '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html__( 'Wander further, book with certainty.', 'farway' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">' . esc_html__( 'Real availability and transparent pricing on every departure.', 'farway' ) . '</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Find trips', 'farway' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons -->',
		)
	);
}
add_action( 'init', 'farway_register_block_patterns' );

/**
 * The trip, destination, testimonial, FAQ, and booking content types are
 * registered by the Farway Content Types companion plugin. Keeping
 * register_post_type() out of the theme keeps content data portable when the
 * theme is switched.
 */

/**
 * Include public custom post types in the default site search.
 */
function farway_searchable_post_types( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$query->set( 'post_type', array( 'post', 'page', 'farway_destination', 'farway_trip', 'farway_faq' ) );
}
add_action( 'pre_get_posts', 'farway_searchable_post_types' );

/**
 * Enqueue styles and scripts.
 */
function farway_scripts() {
	wp_enqueue_script( 'farway-detect', get_template_directory_uri() . '/js/detect.js', array(), FARWAY_VERSION, false );

	wp_enqueue_style(
		'farway-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,450;9..144,600&family=IBM+Plex+Mono:wght@400;500;600&family=Work+Sans:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'farway-style', get_stylesheet_uri(), array(), FARWAY_VERSION );

	wp_enqueue_script(
		'farway-main',
		get_template_directory_uri() . '/js/hero.js',
		array(),
		FARWAY_VERSION,
		true
	);

	wp_enqueue_script(
		'farway-animations',
		get_template_directory_uri() . '/js/animations.js',
		array(),
		FARWAY_VERSION,
		true
	);

	wp_localize_script( 'farway-main', 'farwayConfig', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'farway_inquiry' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'farway_scripts' );

/**
 * Handle the booking inquiry form submission.
 */
function farway_inquiry_handler() {
	check_ajax_referer( 'farway_inquiry', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$trip_id = isset( $_POST['trip_id'] ) ? absint( $_POST['trip_id'] ) : 0;

	if ( '' === $name || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please provide your name and a valid email address.', 'farway' ) ) );
	}

	$subject = sprintf( __( 'New trip inquiry from %s', 'farway' ), $name );
	$body    = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\nTrip: %s\n\n%s",
		$name,
		$email,
		$phone,
		$trip_id ? get_the_title( $trip_id ) : __( 'General inquiry', 'farway' ),
		$message
	);

	$to      = get_option( 'admin_email' );
	$sent    = wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	// Persist to the companion plugin's booking post type when it is available.
	if ( post_type_exists( 'farway_booking' ) ) {
		wp_insert_post( array(
			'post_type'    => 'farway_booking',
			'post_status'  => 'private',
			'post_title'   => sprintf( __( 'Inquiry from %s', 'farway' ), $name ),
			'post_content' => $body,
		) );
	}

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'Sorry, your inquiry could not be sent. Please try again.', 'farway' ) ) );
	}

	wp_send_json_success( array( 'message' => __( 'Thanks! Your inquiry is on its way. We will be in touch shortly.', 'farway' ) ) );
}
add_action( 'wp_ajax_farway_inquiry', 'farway_inquiry_handler' );
add_action( 'wp_ajax_nopriv_farway_inquiry', 'farway_inquiry_handler' );

/**
 * Register widget area for the footer.
 */
function farway_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer', 'farway' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'farway_widgets_init' );

/**
 * Returns the "my account" URL — uses WooCommerce's account page
 * if WooCommerce is active, otherwise falls back to /my-account/.
 */
function farway_account_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( 'myaccount' );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/my-account/' );
}

/**
 * Fallback menu if no "primary" menu has been assigned.
 */
function farway_default_menu() {
	echo '<ul class="nav-links">';
	echo '<li><a href="' . esc_url( home_url( '/#destinations' ) ) . '">' . esc_html__( 'Destinations', 'farway' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#trips' ) ) . '">' . esc_html__( 'Trips', 'farway' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#stories' ) ) . '">' . esc_html__( 'Stories', 'farway' ) . '</a></li>';
	echo '<li class="signin"><a href="' . esc_url( farway_account_url() ) . '">' . esc_html__( 'Sign in', 'farway' ) . '</a></li>';
	echo '</ul>';
}

/**
 * Body classes.
 */
function farway_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'farway-front';
	}
	return $classes;
}
add_filter( 'body_class', 'farway_body_classes' );

/**
 * Theme mod with a sanitized fallback.
 */
function farway_theme_mod( $key, $default ) {
	return sanitize_text_field( get_theme_mod( $key, $default ) );
}

/**
 * Wrap text in typewriter-friendly character spans.
 *
 * @param string $text Text to wrap.
 * @param string $class Optional class added to each character span.
 * @return string Escaped HTML with character spans.
 */
function farway_typewriter( $text, $class = '' ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return '';
	}

	$class_attr = $class ? ' class="' . esc_attr( $class ) . '"' : '';
	$out        = '';
	$chars      = preg_split( '//u', $text, -1, PREG_SPLIT_NO_EMPTY );

	if ( ! is_array( $chars ) ) {
		return esc_html( $text );
	}

	foreach ( $chars as $char ) {
		if ( ' ' === $char ) {
			$out .= ' ';
			continue;
		}
		$out .= '<span' . $class_attr . '>' . esc_html( $char ) . '</span>';
	}

	return $out;
}

/**
 * Departure airports shared by the boarding-pass form.
 *
 * @return array Code => city label.
 */
function farway_departures() {
	$defaults = array(
		'DAC' => __( 'Dhaka, BD', 'farway' ),
		'CXB' => __( 'Cox’s Bazar, BD', 'farway' ),
		'JFK' => __( 'New York, USA', 'farway' ),
		'LHR' => __( 'London, UK', 'farway' ),
		'DXB' => __( 'Dubai, AE', 'farway' ),
		'SIN' => __( 'Singapore, SG', 'farway' ),
		'BKK' => __( 'Bangkok, TH', 'farway' ),
		'KUL' => __( 'Kuala Lumpur, MY', 'farway' ),
	);

	return apply_filters( 'farway_departures', $defaults );
}

/**
 * Duration options shared by the form, meta box, and search.
 */
function farway_duration_options() {
	return array(
		'2-4'  => __( '2–4 days', 'farway' ),
		'5-7'  => __( '5–7 days', 'farway' ),
		'8-14' => __( '8–14 days', 'farway' ),
	);
}

/**
 * Build the trip search query used by the boarding-pass form.
 */
function farway_trip_search_query( $args = array() ) {
	$defaults = array(
		'from'        => isset( $_GET['from'] ) ? sanitize_text_field( wp_unslash( $_GET['from'] ) ) : '',
		'depart'      => isset( $_GET['depart'] ) ? sanitize_text_field( wp_unslash( $_GET['depart'] ) ) : '',
		'trip_length' => isset( $_GET['trip_length'] ) ? sanitize_text_field( wp_unslash( $_GET['trip_length'] ) ) : '',
		'travelers'   => isset( $_GET['travelers'] ) ? max( 1, absint( $_GET['travelers'] ) ) : 2,
		'destination' => isset( $_GET['destination'] ) ? absint( $_GET['destination'] ) : 0,
	);
	$args = wp_parse_args( $args, $defaults );

	$query = array(
		'post_type'      => 'farway_trip',
		'post_status'    => 'publish',
		'posts_per_page' => 9,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $args['destination'] ) {
		$query['meta_query'][] = array(
			'key'   => '_farway_destination_id',
			'value' => $args['destination'],
		);
	}

	if ( $args['trip_length'] && array_key_exists( $args['trip_length'], farway_duration_options() ) ) {
		$query['meta_query'][] = array(
			'key'   => '_farway_duration',
			'value' => $args['trip_length'],
		);
	}

	return new WP_Query( $query );
}

/**
 * Retrieve trip meta with sane defaults.
 */
function farway_trip_meta( $post_id ) {
	return array(
		'destination' => get_post_meta( $post_id, '_farway_destination_id', true ),
		'price'       => get_post_meta( $post_id, '_farway_price', true ),
		'sale_price'  => get_post_meta( $post_id, '_farway_sale_price', true ),
		'duration'    => get_post_meta( $post_id, '_farway_duration', true ),
		'trip_type'   => get_post_meta( $post_id, '_farway_trip_type', true ),
		'difficulty'  => get_post_meta( $post_id, '_farway_difficulty', true ),
		'group_size'  => get_post_meta( $post_id, '_farway_group_size', true ),
		'inclusions'  => get_post_meta( $post_id, '_farway_inclusions', true ),
		'featured'    => get_post_meta( $post_id, '_farway_featured', true ),
	);
}

/**
 * Retrieve destination meta with sane defaults.
 */
function farway_destination_meta( $post_id ) {
	return array(
		'country'     => get_post_meta( $post_id, '_farway_country', true ),
		'region'      => get_post_meta( $post_id, '_farway_region', true ),
		'best_season' => get_post_meta( $post_id, '_farway_best_season', true ),
		'currency'    => get_post_meta( $post_id, '_farway_currency', true ),
		'language'    => get_post_meta( $post_id, '_farway_language', true ),
	);
}

/**
 * Return an inclusion string as an array of trimmed, non-empty lines.
 */
function farway_inclusions_list( $inclusions ) {
	$inclusions = trim( (string) $inclusions );
	if ( '' === $inclusions ) {
		return array();
	}

	return array_values( array_filter( array_map( 'trim', explode( "\n", $inclusions ) ) ) );
}

/**
 * Format a price consistently.
 */
function farway_price( $price ) {
	$price = floatval( $price );
	return '$' . number_format_i18n( $price, 2 );
}

/**
 * Output a trip card used across the front page and archives.
 */
function farway_trip_card( $post ) {
	$meta      = farway_trip_meta( $post->ID );
	$dest_id   = $meta['destination'];
	$dest_name = $dest_id ? get_the_title( $dest_id ) : '';
	?>
	<article class="trip-card">
		<a href="<?php the_permalink(); ?>" class="trip-media">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large' ); ?>
			<?php else : ?>
				<div class="trip-placeholder"><?php esc_html_e( 'Trip', 'farway' ); ?></div>
			<?php endif; ?>
			<?php if ( $meta['featured'] ) : ?>
				<span class="trip-badge"><?php esc_html_e( 'Featured', 'farway' ); ?></span>
			<?php endif; ?>
		</a>
		<div class="trip-body">
			<div class="trip-meta">
				<?php if ( $dest_name ) : ?>
					<span class="trip-location"><?php echo esc_html( $dest_name ); ?></span>
				<?php endif; ?>
				<?php if ( $meta['duration'] && isset( farway_duration_options()[ $meta['duration'] ] ) ) : ?>
					<span class="trip-duration"><?php echo esc_html( farway_duration_options()[ $meta['duration'] ] ); ?></span>
				<?php endif; ?>
			</div>
			<h3 class="trip-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div class="trip-foot">
				<?php if ( $meta['price'] !== '' ) : ?>
					<span class="trip-price">
						<?php if ( $meta['sale_price'] !== '' && floatval( $meta['sale_price'] ) > 0 ) : ?>
							<span class="trip-price-was"><?php echo esc_html( farway_price( $meta['price'] ) ); ?></span>
							<?php echo esc_html( farway_price( $meta['sale_price'] ) ); ?>
						<?php else : ?>
							<?php echo esc_html( farway_price( $meta['price'] ) ); ?>
						<?php endif; ?>
						<em><?php esc_html_e( '/ person', 'farway' ); ?></em>
					</span>
				<?php endif; ?>
				<a class="trip-cta" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View trip', 'farway' ); ?> &rarr;</a>
			</div>
		</div>
	</article>
	<?php
}

/**
 * Output a destination card used across the front page and archives.
 */
function farway_destination_card( $post ) {
	$meta = farway_destination_meta( $post->ID );
	?>
	<article class="destination-card">
		<a href="<?php the_permalink(); ?>" class="destination-media">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large' ); ?>
			<?php else : ?>
				<div class="trip-placeholder"><?php esc_html_e( 'Destination', 'farway' ); ?></div>
			<?php endif; ?>
		</a>
		<h3 class="destination-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $meta['country'] ) : ?>
			<p class="destination-country"><?php echo esc_html( $meta['country'] ); ?></p>
		<?php endif; ?>
	</article>
	<?php
}
