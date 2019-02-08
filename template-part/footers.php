<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

//footer-type

if( ($type = lapindos_get_config('footer-type','option')) && $type =='page' && ($page_id = lapindos_get_config('footer-page')) ){
	$footer_html = lapindos_get_post_footer_page($page_id);

	print '<div class="no-padding">'.$footer_html.'</div>';
}
else{?>
<?php get_template_part( 'template-part/footer-text'); ?>
<?php get_template_part( 'template-part/footer-widget'); ?>
<?php get_template_part( 'template-part/footer-copyright'); ?>
<?php 
}?>