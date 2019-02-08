<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$social_link_target = lapindos_get_config('social_link_target','');
if($social_link_target!=''){
	$social_link_target = '_'.$social_link_target;
}

$show_label = lapindos_get_config('social_show_label', false);
$sociallinks = lapindos_get_sociallinks(array('show_label'=>$show_label, 'target'=> $social_link_target));

if($sociallinks!=''):?>
<div class="module-social-icon">
<?php print wp_kses_post($sociallinks);?>
</div>
<?php endif;?>