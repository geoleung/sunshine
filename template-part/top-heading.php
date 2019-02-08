<?php
defined('ABSPATH') or die();
/**
 *
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$header_shadow = lapindos_get_config('header_shadow',true);
?>
<div  class="top-heading <?php print ($header_shadow) ? "heading-shadow":"";?>">
<?php
if(lapindos_get_config('show_top_bar',true)){
	get_template_part( 'template-part/top-bar'); 
}

?>
<?php get_template_part( 'template-part/middle-bar'); ?>
<?php if(lapindos_get_config('show_bottom_section',false)):
$hangdown = lapindos_get_config('bottom-layout-indent', '');

?>
<div class="bottom-section-header hidden-xs <?php print ($hangdown!='') ? 'hang-down-'.$hangdown.' ':''; print lapindos_get_config('bottom-layout-mode','');?>">
<div class="container">
	<div class="bottom-section-inner"><?php get_template_part( 'template-part/bottom-bar'); ?></div>  
</div>
</div>
<?php endif;?>
<?php if(($shape = lapindos_get_config('header-shape',false))):?>
	<?php get_template_part( 'template-part/bottom-shape-'.$shape); ?>
<?php endif;?>
</div>