<?php
defined('ABSPATH') or die();
/**
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
?>
<div class="row">
	<div class="col-xs-12">
	<div class="error404-content search-404">
		<h2 class="top-m0" ><?php esc_html_e( 'Nothing Found','lapindos' );?></h2>
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'lapindos' )), admin_url( 'post-new.php' ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
		<h4 class="subtitle-404d"><?php esc_html_e( 'Sorry, but nothing matched your search terms.','lapindos' );?></h4>		
		<p><?php esc_html_e( 'Please try again with some different keywords.', 'lapindos' ); ?></p>
		<?php get_search_form(); ?>
		<?php else : ?>
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'lapindos' ); ?></p>
<?php get_search_form(); ?>
<?php endif; ?>
	</div>					

	</div>
</div>