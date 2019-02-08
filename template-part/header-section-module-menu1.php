<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */


$menu_id = lapindos_get_config('top-bar-menu-1','');

if($menu_id=='' && $menu_id < 1) return;

$menuParams=array(
'menu' => $menu_id,
'echo' => false,
'container_class'=>'',
'container_id'=>'top-bar-menu-1',
'menu_class'=>'top-bar-menu',
'container'=>'',
'before' => '',
'after' => '',
'fallback_cb'=>false,
'walker'  => new mainmenu_walker(),
'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
);

  $menu1=wp_nav_menu($menuParams);

  if(!$menu1 || is_wp_error($menu1))
    return "";
	
print '<div class="module-menu">'.$menu1.'</div>';

?>
