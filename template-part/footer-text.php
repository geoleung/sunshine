<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$from_page = false;

if(($page_id =  lapindos_get_config('pre-footer-page'))){
	
	if($page_id=='none') return;

	$footertext = lapindos_get_post_footer_page($page_id);
	$from_page = true;

}
else{

	$footertext = lapindos_get_config('pre-footer-text','');
	$footertext = apply_filters( 'lapindos_render_footer_text' , $footertext );
	$footertext = ($footertext!='') ? '<div class="container"><div class="row">'.do_shortcode($footertext).'</div></div>' : '';

}

if($footertext!=''){
?>
<div class="<?php print $from_page ? "no-padding":"footer-text";?>">
<?php
		print $footertext; 
?>
</div>
<?php
}

?>