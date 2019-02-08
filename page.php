<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

get_header();?>
<div <?php post_class();?>>
<?php
while ( have_posts() ) :?>
	<?php the_post();
	the_content();
	lapindos_link_pages();
endwhile;
?>
<?php 

if(comments_open()):

if(get_comments_number()):?>
<div class="content-comments clearfix">
<h3 class="h5 heading"><?php comments_number(esc_html__('No Comments','lapindos'),esc_html__('1 Comment','lapindos'),esc_html__('% Comments','lapindos')); ?> :</h3>
<?php comments_template(); ?>
</div>
<?php else:?>
<div class="top-m20 content-comments clearfix">
<?php comments_template(); ?>
</div>
<?php endif;
endif;?>

</div>
<?php
get_footer();
?>