<?php
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
get_header();


$term = get_queried_object();
if(!($layout = get_metadata( 'term', $term->term_id, '_service_layout', true )) || $layout==''){
	$layout =	lapindos_get_config( 'service_cat_grid_column',1 );
}

$grid_column = 1;
if($layout!='chess'){
	$grid_column = absint($layout);
}

$grid_css= array('grid-column',"col-xs-12");
$lg = 12 / $grid_column;
$grid_css[] = "col-lg-".$lg;
if($lg < 12 ) $grid_css[] = 'col-md-6';

if($layout=='chess'){
	$grid_css[] = 'chess';
}

$grid_class = join(' ',array_unique($grid_css));

$rows= array();

if ( have_posts() ) : 
?>
<?php

    $rich_description=get_metadata('term', $term->term_id, '_rich_description', true);
?>
<div class="taxonomy-description"><?php print wp_kses_post($rich_description);?></div>
<div id="post-lists" class="post-lists  blog-col-<?php print sanitize_html_class($grid_column);?> clearfix">
<?php
while ( have_posts() ) :

ob_start();
the_post();
?>
<div class="<?php print esc_attr($grid_class);?>">
<?php
if($layout=='chess'){
	get_template_part( 'template-part/content', 'service-chess' ); 
}
else{
	get_template_part( 'template-part/content', 'service' ); 
}
?>
</div>
<?php
$rows[] = ob_get_clean();

endwhile;

if(count($rows)):
	print join('',$rows);
endif;
unset($rows);
?>
</div>
<div class="clearfix"></div>

<?php
		$args=array("before"=>"<li>","after"=>"</li>","wrapper"=>"<div class=\"pagination %s\" dir=\"ltr\"><ul>%s</ul></div>");
		lapindos_pagination($args);
		 ?>
		<?php else:?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif;?>
<?php get_footer(); ?>