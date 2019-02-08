<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$quote_menu_label = lapindos_get_config( 'quote_menu_label' , '');
$quote_menu_link = lapindos_get_config( 'quote_menu_link' , '');
$quote_menu_link_target = lapindos_get_config( 'quote_menu_link_target' , 'blank');
$button_skin = lapindos_get_config( 'button_skin' , 'primary');
$button_shape = lapindos_get_config( 'button_shape' , '');
$button_size = lapindos_get_config( 'button_size' , '');

$classes = array('btn','quote-btn','btn-'.$button_shape,'btn-skin-'.$button_skin,$button_size);
$classes = array_map('sanitize_html_class', $classes );

?>
<div class="quote-menu collapse">
<a class="<?php print implode(' ',$classes); ?>" target="_<?php print esc_attr($quote_menu_link_target);?>" href="<?php print esc_url($quote_menu_link);?>"><?php print wp_kses_post($quote_menu_label);?></a>
</div>
