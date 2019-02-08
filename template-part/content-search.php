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

$post_type_object=get_post_type_object(get_post_type());
$label = $post_type_object->labels->singular_name;


?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="post-content clearfix">
			<h2 class="h4 post-title "><a class="bot-m20 cl-body color-hover-primary" href="<?php the_permalink();?>"><?php the_title();?></a></h2>
			<div class="color-secondary blog-post-type h5"><?php print esc_html($label);?></div>
			<div class="content-excerpt clearfix">
			<?php
				the_excerpt();
				lapindos_get_readmore(array('echo'=>true,'class'=>array('btn','btn-primary','shape-square'),'label'=> esc_html__('read more','lapindos')));
			?>
			</div>
		</div>
		<div class="clearfix"></div>	
</article>