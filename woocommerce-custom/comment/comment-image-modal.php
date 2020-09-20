<?php
/**
 * Image modal
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

$starter_comment            = get_comment( $starter_comment_id );
$starter_comment_author     = $starter_comment->comment_author;
$starter_comment_thumbnails = get_field( 'comment_image', $starter_comment );
$starter_comment_total_img  = count( $starter_comment_thumbnails );
?>

<div class="modal img_modal js_img_modal js_comment_img_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content js_wrap_img_thumbnails">
			<div class="modal-header">
				<h3 class="modal-title">
					<?php
						echo esc_html( $starter_comment_author );
						/* translators: count images of comment. */
						printf( esc_html( _n( ' Attached %s Photo', ' Attached %s Photos', $starter_comment_total_img, 'starter' ) ), esc_html( $starter_comment_total_img ) );
					?>
				</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?></button>
			</div>
			<div class="modal-body">
				<picture class="item_img js_main_img">
					<?php echo do_shortcode( "[img img_src='w1600' img_sizes='calc(100vw - 32px)' img_object=\"" . $starter_comment_thumbnails[0] . "\"]" ); ?>
				</picture>
				<!-- toggle pictures due chrome bug when change srcset -->
				<picture class="item_img js_main_img d-none">
					<?php echo do_shortcode( "[img img_src='w1600' img_sizes='calc(100vw - 32px)' img_object=\"" . $starter_comment_thumbnails[0] . "\"]" ); ?>
				</picture>
			</div>
			<div class="modal-footer">
				<div class="wrap_carousel thumbnail_carousel js_thumbnail_carousel">
					<div class="swiper-container object_fit">
						<div class="swiper-wrapper">
							<?php foreach ( $starter_comment_thumbnails as $key => $starter_img ) : ?>
								<div class="swiper-slide">
									<picture class="thumbnail js_thumbnail"><?php echo do_shortcode( "[img img_src='w200' img_sizes='80px' img_object=\"" . $starter_img . "\"]" ); ?></picture>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
					<div class="carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>