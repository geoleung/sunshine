<?php
defined('ABSPATH') or die();
/**
 * The service template content
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
		print $featured_image;
		}?>
		<div class="post-content clearfix">
			<h2 class="post-title h4"><a class="bot-m20 cl-body color-hover-primary" href="<?php the_permalink($post->ID);?>"><?php the_title();?></a></h2>
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
			?>
			</div>
			<?php lapindos_get_readmore(array('echo'=>true));?>
		</div>
		<div class="clearfix"></div>	
</article>