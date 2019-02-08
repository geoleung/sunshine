<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */


$header_layout = lapindos_get_config( 'header-layout', array());
$bottom_layout = isset($header_layout['bottom']) ? $header_layout['bottom'] : false;

if(! $bottom_layout ) return;

if(isset($bottom_layout['placebo'])){
	unset($bottom_layout['placebo']);
}
elseif(isset($bottom_layout['fields'])){
	$bottom_layout = $bottom_layout['fields'];
}

if(! count($bottom_layout) ) return;


?>
<?php foreach ($bottom_layout as $layout_name => $layout_label) {	

ob_start();
get_template_part( 'template-part/header-section-module', $layout_name);
$module_html = ob_get_clean();

print ($module_html!='') ? "<div class=\"bottom-bar-module heading-module\">{$module_html}</div>" : '';

} ?>