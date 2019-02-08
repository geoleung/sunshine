<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */


$header_layout = lapindos_get_config( 'header-layout', array());
$tobar_layout = isset($header_layout['topbar']) ? $header_layout['topbar'] : false;
$responsiveness = lapindos_get_config( 'topbar-responsiveness', '');
$widemode = lapindos_get_config('topbar-layout-mode','');
$topbar_class = array();

if($responsiveness!=''){
	array_push( $topbar_class, 'hidden-'.$responsiveness);
}

if($widemode!=''){
	array_push( $topbar_class, $widemode);
}

if(!$tobar_layout ) return;

if(isset($tobar_layout['placebo'])){
	unset($tobar_layout['placebo']);
}
elseif(isset($tobar_layout['fields'])){
	$tobar_layout = $tobar_layout['fields'];
}

if(! count($tobar_layout) ) return;

$modules_html = array();
?>
<?php
foreach ($tobar_layout as $layout_name => $layout_label) {	

$layout_class = array('top-bar-module','heading-module');
$responsiv = lapindos_get_config( $layout_name.'-responsiveness', '');

if($responsiv!=''){
	array_push( $layout_class, 'hidden-'.$responsiv);
}

ob_start();
get_template_part( 'template-part/header-section-module', $layout_name);
$module_html = ob_get_clean();

	if($module_html!=''){
	 $modules_html[] =  "<div class=\"".join(' ', $layout_class)."\">{$module_html}</div>";
	}
} 
if(count($modules_html)):
?>
<div class="top-bar <?php print join(' ',$topbar_class);?>">
	<div class="container">
		<div class="top-bar-inner">
<?php print join("", $modules_html);?>
		</div>
	</div>
</div>
<?php  endif; ?>