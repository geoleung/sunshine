<?php
/**
 * Template Name: Page Builder
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php lapindos_view_port();?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head();?>
</head>
<body <?php body_class();?>>
<div class="main-container">
  <div class="page-heading <?php print lapindos_get_config('heading_position','');?>">
    <?php get_template_part( 'template-part/heading'); ?>
  </div>
	<div class="main-content clearfix <?php print apply_filters('lapindos_main_content_class','');?>">
<div <?php post_class();?>>
<?php
while ( have_posts() ) :?>
	<?php the_post();
	the_content();
endwhile;
?>
</div>
	</div>
<?php get_template_part( 'template-part/footers'); ?>
</div>
<?php if(lapindos_get_config('slidingbar')):
 get_template_part( 'template-part/slidesidebar' );
endif; ?>
<div id="toTop"><span></span></div>
<?php wp_footer(); ?>
</body>
</html>