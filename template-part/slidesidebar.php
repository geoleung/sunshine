<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$slidingbar_type = lapindos_get_config('slidingbar-type');

ob_start();

switch( $slidingbar_type ){
	case 'sidebar-widget':
		dynamic_sidebar('sidebar-widget');
		break;
	case 'page':

	$page_id = lapindos_get_config('slidingbar-page');
	$slide_html = lapindos_get_post_footer_page($page_id);

	print ($slide_html) ? $slide_html : '';
		break;
	default:
	dynamic_sidebar('slidingbar-widget');
	break;
}


$slidebar_content = ob_get_clean();

if($slidebar_content=='') return;

?>
<div class="slide-sidebar-overlay"></div>
<div class="slide-sidebar-container">
	<div class="slide-sidebar-wrap clearfix">
		<?php print apply_filters('lapindos_slidebar_content', $slidebar_content);?>
	</div>
</div>
