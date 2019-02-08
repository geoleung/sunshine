<?php
defined('ABSPATH') or die();
/**
 * The service template content - chees style
 *
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$featured_image = lapindos_get_post_featured_image_tag($post->ID, array('size'=>'large'));
?>
<div class="row">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($featured_image!=''){?>
	<div class="col-sm-8 col-md-8 "><?php
		print $featured_image;?></div><div class="col-sm-4 col-md-4 chess-content"><?php
		}
		else{
		?>
<div class="col-sm-12 col-md-12 chess-content">
<?php		}?>
		<div class="post-content">
			<h2 class="post-title h4"><a class="cl-body color-hover-primary" href="<?php the_permalink($post->ID);?>"><?php the_title();?></a></h2>
			<div class="content-excerpt">
			<?php
				the_excerpt();
			?>
			</div>
			<?php lapindos_get_readmore(array('echo'=>true));?>
		</div>
	</div>
</article>
</div>