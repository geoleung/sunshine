<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$left_footertext = lapindos_get_config('footer-copyright-text','');
$left_footertext = apply_filters( 'lapindos_render_footer_text' , $left_footertext );

$right_footertext = lapindos_get_config('right-copyright-text','');
$right_footertext = apply_filters( 'lapindos_render_footer_text' , $right_footertext );

if($left_footertext=='' && $right_footertext=='') return;

if($left_footertext!='' && $right_footertext!=''){
?>
<div class="footer-copyright <?php print lapindos_get_config('footer-copyright-layout-mode','');?>">
	<div class="container">
		<div class="row">
<?php
	$left_grid = absint(lapindos_get_config( 'footer-copyright-grid' , 12));

$right_grid = $left_grid == 12 ? 12 : 12 - $left_grid;
?>
<div class="col-xs-12 <?php print 'col-md-'.$left_grid;?>">
	<?php print wp_kses_post($left_footertext); ?>
</div>
<div class="col-xs-12 <?php print 'col-md-'.$right_grid;?>">
	<?php print wp_kses_post($right_footertext); ?>
</div>

		</div>
	</div>
</div>
<?php
}
else{
?>
<div class="footer-copyright <?php print lapindos_get_config('footer-copyright-layout-mode','');?>">
	<div class="container">
		<?php print wp_kses_post($left_footertext.$right_footertext); ?>
	</div>
</div>
<?php
}
?>
