<?php
defined('ABSPATH') or die();
/**
 * The main single post template file
 *
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
get_header();

if ( have_posts() ) : 
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-part/single/content-single' ); 
endwhile;
else:?>
	<?php get_template_part( 'template-part/content', 'none' ); ?>
<?php 
endif;
get_footer();
?>
