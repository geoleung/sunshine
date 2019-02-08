<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
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
		
		}?>
		<div class="post-content clearfix">
			<h2 class="h4 post-title "><a class="bot-m20 cl-body color-hover-primary" href="<?php the_permalink();?>"><?php the_title();?></a></h2>
			<?php get_template_part('template-part/post-meta'); ?>
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
				lapindos_get_readmore(array('echo'=>true,'class'=>array('btn','btn-primary','shape-square'),'label'=> esc_html__('read more','lapindos')));
			?>
			</div>
		</div>
		<div class="clearfix"></div>	
</article>