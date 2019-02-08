<?php
/**
 * The search result template file
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
 * @since Lapindos 1.0.3
 */
get_header();

if ( have_posts() ) : 

if( 'content' == lapindos_get_config( 'search_form_position', 'content')){
?>
<h2 class="top-m0"><?php esc_html_e( 'Search Result','lapindos' );?></h2>
<div class="search-result-form">
<?php get_search_form(); ?>
</div>
<div class="bottom-devider"></div>
<?php 
      }


?>
<div id="post-lists" class="post-lists blog-col-1 clearfix">
<?php
while ( have_posts() ) :?>
<div class="grid-column col-xs-12">
<?php
the_post();
$post_format= get_post_format();

get_template_part( 'template-part/content-search',  'post'==get_post_type()? $post_format : get_post_type() );

?>
<div class="bottom-devider"></div>
</div>
<?php endwhile;?>
</div>
<div class="clearfix"></div>
<?php 
$args=array("before"=>"<li>","after"=>"</li>","wrapper"=>"<div class=\"pagination %s\" dir=\"ltr\"><ul>%s</ul></div>",'navigation_type'=>'number');
lapindos_pagination($args);

else:

?>
<div class="row">
	<div class="col-xs-12">
	<div class="error404-content search-404">
<?php 

$error_text=lapindos_get_config('search-empty-text','');

if($error_text!=''){
	print do_shortcode($error_text);
}
else{?>
		<h2 class="top-m0" ><?php esc_html_e( 'Nothing Found','lapindos' );?></h2>
		<h4><?php esc_html_e( 'Sorry, but nothing matched your search terms.','lapindos' );?></h4>		
		<p><?php esc_html_e( 'Please try again with some different keywords.', 'lapindos' ); ?></p>
<?php }
 
		if( 'content' == lapindos_get_config( 'search_form_position', 'content')){
			get_search_form(); 
		}
		?>
	</div>					
	</div>
</div>
<?php endif;?>
<?php
get_footer();
?>