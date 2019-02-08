<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$logo_aligment = lapindos_get_config('logo-position','');

$header_layout = lapindos_get_config( 'header-layout', array());
$middle_layout = isset($header_layout['middle']) ? $header_layout['middle'] : array( "placebo" => "placebo", "mainmenu"=> esc_html__( 'Main Menu','lapindos'));
$responsiveness = lapindos_get_config( 'middle-responsiveness', '');
$widemode = lapindos_get_config('middle-layout-mode','');
$middle_class = array('middle-section-header');


if($responsiveness!=''){
	array_push( $middle_class, 'hidden-'.$responsiveness);
}

if($widemode!=''){
	array_push( $middle_class, $widemode);
}

if($logo_aligment!=''){
	array_push( $middle_class, 'logo-'.$logo_aligment);
}

$force_center  = true;
if(isset($middle_layout['placebo'])){
	unset($middle_layout['placebo']);
}
elseif(isset($middle_layout['fields'])){
	$middle_layout = $middle_layout['fields'];
}

if(  $middle_layout && count($middle_layout) ){
	$force_center = false;
}

$module_available = (bool)count($middle_layout);

?>

<div class="<?php print join(' ',$middle_class);?>">
<div class="container">
	<div class="middle-section-inner">
		<div class="middle-bar-module heading-module logo <?php print $force_center ? 'force-center':''; ?>">
		  <?php get_template_part( 'template-part/logo'); ?>
		</div>
<?php

if( !$force_center ){

?>
<?php foreach ($middle_layout as $layout_name => $layout_label) {	

	$layout_class = array('middle-bar-module','heading-module');
	$responsiv = lapindos_get_config( $layout_name.'-responsiveness', '');

	if($responsiv!=''){
		array_push( $layout_class, 'hidden-'.$responsiv);
	}

	ob_start();
	get_template_part( 'template-part/header-section-module', $layout_name);
	$module_html = ob_get_clean();

	print ($module_html!='') ? "<div class=\"".join(' ',$layout_class)."\">{$module_html}</div>" : '';

	} 
}
?>
	</div>
</div>
</div>
