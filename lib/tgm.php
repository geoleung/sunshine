<?php
defined('ABSPATH') or die();
require_once (get_template_directory().'/lib/tgm/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'lapindos_register_required_plugins' );

function lapindos_register_required_plugins() {

	$plugins = array(
			array(
				'name'     				=> esc_html__( 'Lapindos Page Attributes','lapindos'),
				'slug'     				=> 'lapindos_page_attributes',
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'source'                => esc_url('http://store.themegum.com/plugins/lapindos_page_attributes.zip')
			),
			array(
				'name'     				=> esc_html__( 'WordPress Importer','lapindos'),
				'slug'     				=> 'wordpress-importer',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'WP Options Importer','lapindos'),
				'slug'     				=> 'options-importer',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Nuno Builder','lapindos'),
				'slug'     				=> 'landingue',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'source'                => esc_url('http://store.themegum.com/plugins/landingue.zip')
			),
			array(
				'name'     				=> esc_html__( 'Crelly Slider By Fabio Rinaldi','lapindos'),
				'slug'     				=> 'crelly-slider',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Simple Line Icon Addon','lapindos'),
				'slug'     				=> 'landingue_icon_addon',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'source'                => esc_url('http://store.themegum.com/plugins/landingue_icon_addon.zip')
			),
			array(
				'name'     				=> esc_html__( 'WooCommerce','lapindos'),
				'slug'     				=> 'woocommerce',
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
			array(
				'name'     				=> esc_html__( 'Service Post by TemeGUM','lapindos'),
				'slug'     				=> 'petro_service',
				'source'   				=> esc_url('http://store.themegum.com/plugins/petro_service.zip'),
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
			),
		);



	$config = array(
		'domain'       		=> 'lapindos',         			
		'default_path' 		=> '',                         	
		'parent_slug' 		=> 'themes.php', 				
		'menu'         		=> 'install-required-plugins', 	
		'has_notices'      	=> true,                       	
		'is_automatic'    	=> false,					   	
		'message' 			=> ''							
	);

	tgmpa( $plugins, $config );

}