<?php
defined('ABSPATH') or die();
/**
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		<?php 
if(!lapindos_get_config('petro_service_hide_featured_image',false)):		
	print lapindos_get_post_featured_image_tag($post->ID,array('css'=>'blog-image clearfix bot-m40'));
endif;
?>
<?php if(($title = lapindos_get_config('the_title')) && $title!='' && 'content' == lapindos_get_config('title_position')  ): ?>
		<h2 class="h3 service-title bot-m40"><?php the_title();?></h2>
<?php endif; ?>
		<div class="content-full clearfix">	
		<?php 
		the_content();
		lapindos_link_pages();
		?>
		</div>
	</div>
</article>
