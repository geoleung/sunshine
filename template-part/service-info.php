<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 * @see /single/content-single-service.php
 */

$post_id = get_the_ID();

if(lapindos_get_config('petro_service_sidebar_position',true) !== 'nosidebar'):
	dynamic_sidebar('service-widget');
endif;
?>