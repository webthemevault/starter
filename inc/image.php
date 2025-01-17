<?php
/**
 * Image function & settings
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Allow upload svg files.
 *
 * @since starter 1.0
 *
 * @param array $mimes Mime types keyed by the file extension regex corresponding to those types.
 * @return array $mimes with svg.
 */
function starter_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'starter_mime_types' );

/**
 * Image html output
 *
 * @since starter 1.0
 *
 * @param array $atts of image: image ID & sizes.
 * @return string img html
 */
function starter_img_func( $atts ) {
	$img = $atts['img_id'];
	if ( $img ) {
		$img_markup = '';
		$img_width  = 'width="100%"';
		$img_height = 'height="100%"';
		$img_src    = esc_url( wp_get_attachment_image_url( $img, $atts['img_src'] ) );
		$img_srcset = wp_get_attachment_image_srcset( $img );
		$img_sizes  = "sizes='" . $atts['img_sizes'] . "'";

		if ( get_theme_mod( 'image_webp', true ) && wp_get_attachment_image_srcset( $img ) ) {
			$img_srcset_webp = str_ireplace( array( '.jpg ', '.jpeg ', '.png ' ), array( '.jpg.webp ', '.jpeg.webp ', '.png.webp ' ), $img_srcset );
			$img_markup      = "<source type='image/webp' srcset=\"$img_srcset_webp\" $img_sizes>";
		}

		$img_alt = "alt='" . esc_attr( get_post_meta( $img, '_wp_attachment_image_alt', true ) ) . "'";
		if ( ! get_post_meta( $img, '_wp_attachment_image_alt', true ) ) {
			$img_alt = "alt='" . get_post( $img )->post_title . "'";
		}
		return $img_markup . "<img class='img-fluid' loading='lazy' src=\"$img_src\" srcset=\"$img_srcset\" $img_alt $img_sizes $img_width $img_height>";
	} else {
		return wc_placeholder_img( $size = '', $attr = 'class=img-fluid woocommerce-placeholder' );
	}
}

/**
 * Remove default WP/woo image sizes.
 *
 * @since starter 1.0
 *
 * @param array $default_sizes Default image size names.
 * @return array $default_sizes Updated image names
 */
function starter_remove_default_image_sizes( $default_sizes ) {
	return array_diff( $default_sizes, array( 'medium', 'medium_large', 'large', '1536x1536', '2048x2048', 'woocommerce_thumbnail', 'woocommerce_single', 'woocommerce_gallery_thumbnail', 'shop_catalog', 'shop_single', 'shop_thumbnail' ) );
}
add_action( 'intermediate_image_sizes', 'starter_remove_default_image_sizes', 999 );

/**
 * Add custom image sizes.
 *
 * @since starter 1.0
 */
function starter_custom_thumbnail_size() {
	add_image_size( 'w200', 200 );
	add_image_size( 'w400', 400 );
	add_image_size( 'w600', 600 );
	add_image_size( 'w800', 800 );
	add_image_size( 'w1000', 1000 );
	add_image_size( 'w1200', 1200 );
	add_image_size( 'w1400', 1400 );
	add_image_size( 'w1600', 1600 );
	add_image_size( 'w1800', 1800 );
	add_image_size( 'w2000', 2000 );
}
add_action( 'after_setup_theme', 'starter_custom_thumbnail_size', 999 );

/**
 * Add source to allowed wp_kses_post tags
 *
 * @since starter 1.0
 *
 * @param array  $tags Allowed tags, attributes, and/or entities.
 * @param string $context Context to judge allowed tags by.
 *
 * @return array
 */
function starter_wpkses_post_tags( $tags, $context ) {
	$tags['source']        = array(
		'srcset' => true,
		'sizes'  => true,
		'type'   => true,
	);
	$tags['img']['sizes']  = true;
	$tags['img']['srcset'] = true;
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'starter_wpkses_post_tags', 10, 2 );
