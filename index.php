<?php
/**
 * The main template file
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
get_header();
$grid_column = lapindos_get_config( 'grid_column', 1 );

$lite = absint($grid_column) > 1 ? '-lite':'';

$grid_css= array('grid-column',"col-xs-12");
$lg = 12 / $grid_column;
$grid_css[] = "col-lg-".$lg;
if($lg < 12 ) $grid_css[] = 'col-md-6';
$grid_class = join(' ',array_unique($grid_css));

$rows= array();
if ( have_posts() ) : 
?>
<div id="post-lists" class="post-lists blog-col-<?php print sanitize_html_class($grid_column);?> clearfix">
<?php
while ( have_posts() ) :

ob_start();
the_post();
$post_format= get_post_format();

get_template_part( 'template-part/content'.$lite, $post_format ); 

$rows[] = ob_get_clean();

endwhile;

if(count($rows)):?>
	<div class="<?php print esc_attr($grid_class);?>">
	<?php print join('</div><div class="'.esc_attr($grid_class).'">',$rows);?>
	</div>
<?php
endif;

unset($rows);
?>
</div>
<div class="clearfix"></div>
<?php 
$args=array("before"=>"<li>","after"=>"</li>","wrapper"=>"<div class=\"pagination %s\" dir=\"ltr\"><ul>%s</ul></div>",'navigation_type'=>'number');
lapindos_pagination($args);
 ?>
<?php else:?>
	<?php get_template_part( 'template-part/content', 'none' ); ?>
<?php endif;?>
<?php
get_footer();
?>