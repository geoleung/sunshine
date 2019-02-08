<?php
defined('ABSPATH') or die();
/**
 * The template for displaying content - lite
 *
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$featured_image = lapindos_get_post_featured_image_tag($post->ID);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($featured_image!=''){
		print '<a href="'.get_the_permalink($post->ID).'">'.$featured_image.'</a>';
		}else{?>
		<div class="blog-image no-image clearfix"></div>
		<?php }?>
		<div class="post-content clearfix">
			<h4 class="post-title bot-m20"><a class="cl-body color-hover-primary" href="<?php the_permalink();?>"><?php the_title();?></a></h4>
			<?php get_template_part('template-part/post-meta','lite-top'); ?>
		</div>
		<div class="clearfix"></div>	
</article>