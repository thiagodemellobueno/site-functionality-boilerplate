<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
if ( ! isset( $block->context['postId'] ) ) {
	return;
}
$post_id            = $block->context['postId'];
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'post-subtitle',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php
	if ( $subtitle = get_post_meta( $post_id, 'subtitle', 'true' ) ) :
		?>
		<div class="subtitle"><?php echo esc_html( $subtitle ); ?></div>
		<?php
	endif;
	?>
</div>
