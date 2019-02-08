<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$icons = lapindos_get_config('menu_iconflat_fields', array());
$icon_align = lapindos_get_config('iconflat_align', 'right');

if(count($icons) && is_array($icons)):
?>
<ul class="iconflat-graphic icon-align-<?php print sanitize_html_class($icon_align);?>">
<?php foreach ($icons as $icon ) {
$link = isset($icon['url']) && $icon['url']!='' ? $icon['url'] : '';

?>
	<li><?php if(isset($icon['icon']) && !empty($icon['icon'])): if($link!='') print '<a href="'.esc_url($link).'">';?><i class="fa <?php print esc_attr($icon['icon']);?>"></i><?php if($link!='') print '</a>'; endif;?>
		<?php if(isset($icon['label']) && !empty($icon['label'])):

	        if(function_exists('icl_t')){
	          $icon['label'] = icl_t('lapindos', sanitize_key( $icon['label'] ),$icon['label'] );
	        }
	    ?>
		<span class="info-title"><?php print esc_html($icon['label']);?></span>
		<?php endif;?>
		<?php if(isset($icon['text']) && !empty($icon['text'])):

	        if(function_exists('icl_t')){
	          $icon['text'] = icl_t('lapindos', sanitize_key( $icon['text'] ),$icon['text'] );
	        }
		?><span class="info-label"><?php print esc_html($icon['text']);?></span>
		<?php endif;?>
	</li>
<?php
}
?>
</ul>
<?php endif;?>