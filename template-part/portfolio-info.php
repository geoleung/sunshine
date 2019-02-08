<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 * @see /single/content-single-portfolio.php
 */

$post_id = get_the_ID();

$fields = lapindos_get_portfolio_fields();
$hide_empty = lapindos_get_config('hide_empty',0);
$hide_date = lapindos_get_config('hide_date',0);
$hide_category = lapindos_get_config('hide_category',0);
$hide_detail = lapindos_get_config('hide_detail',0);

if(!$hide_detail):

$post_type_object = get_post_type_object( get_post_type() );
$post_type_name = $post_type_object->labels->singular_name;

$singular_name =  function_exists('icl_t') ? icl_t('lapindos', sanitize_key($post_type_name), $post_type_name ) : $post_type_name ;

?>
<div class="widget project-infos">
	<div class="h6 widget-title"><?php printf( esc_html__('%s details','lapindos'), $singular_name);?></div>
<ul class="portfolio-meta-info">
<?php if(!$hide_date):?>
	<li class="meta date-info"><label><?php esc_html_e('date','lapindos');?>:</label><?php the_date();?></li>
<?php endif;
if(!$hide_category && ($categories = get_the_term_list($post_id, 'tg_postcat','',", "))):?>
	<li class="meta categories-info"><label><?php esc_html_e('categories','lapindos');?>:</label><?php print ent2ncr($categories);?></li>
<?php endif;
	if(count($fields)){
		foreach($fields as $field_name => $field) {
			$value = get_post_meta( $post_id, '_'.$field_name , true );

			if($value=='' && $hide_empty) continue;

$field['label'] =  function_exists('icl_t') ? icl_t('lapindos', sanitize_key($field['label']), $field['label'] ) : $field['label'] ;
			?><li class="meta <?php print sanitize_html_class($field_name);?>"><?php
if($field_name=='url'){
	print '<label>'.$field['label'].':</label><a href="'.esc_url($value).'">'.esc_html($value)."</a>";

}
elseif($field_name=='download'){
	print '<a class="btn btn-secondary btn-block align-left" targer="_blank" href="'.esc_url($value).'"><span class="fa  fa-file-pdf-o"></span>'.esc_html($field['label'])."</a>";

}
else{
	print '<label>'.$field['label'].':</label>'.do_shortcode($value);
}
?></li><?php

		}
	}

?>
</ul>
<?php
$previous_post_link = get_previous_post_link( '%link', sprintf( esc_html__('previous %s','lapindos'), $singular_name), false, '', 'tg_postcat' ) ;
$next_post_link = get_next_post_link( '%link', sprintf( esc_html__('next %s','lapindos'), $singular_name), false, '', 'tg_postcat' ) ;
?>
</div>
<?php if($previous_post_link!='' || $next_post_link!=''):?>
<div class="widget superclean_nav_menu">
	<ul class="category-nav">
		<?php if($previous_post_link!=''){ print '<li>'.$previous_post_link.'</li>'; } ?>
		<?php if($next_post_link!=''){ print '<li>'.$next_post_link.'</li>'; } ?>
	</ul>
</div>
<?php endif;
endif;
?>
<?php

if(lapindos_get_config('tg_custom_post_sidebar_position',true) !== 'nosidebar'):
	dynamic_sidebar('portfolio-widget');
endif;
?>