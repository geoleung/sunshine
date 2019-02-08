<?php
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
defined('ABSPATH') or die();


if ( ! isset( $content_width ) ) $content_width = 2000;

function lapindos_startup() {


	if((is_child_theme() && !load_theme_textdomain( 'lapindos', untrailingslashit(get_stylesheet_directory()) . "/languages/")) || !is_child_theme()){
		load_theme_textdomain('lapindos',untrailingslashit(get_template_directory())."/languages/");
	}

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 150,
		'flex-height' => true,
		'flex-width' => false,
	) );

	add_theme_support( 'woocommerce' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header', apply_filters( 'lapindos_custom_header_args', array(
		'width'              => 1500,
		'height'             => 900,
		'flex-height'        => true,
		'video'              => false,
		'wp-head-callback'   => 'lapindos_header_style',
	) ) );

	register_nav_menus(array(
		'main_navigation' => esc_html__('Top Navigation', 'lapindos')
	));

	// sidebar widget

	register_sidebar(
		array('name'=> esc_html__( 'Sidebar','lapindos'),
			'id'	=>'sidebar-widget',
			'description'=> esc_html__('The widget will displayed at left/right of main content.', 'lapindos'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>'
		)
	);

	register_sidebar(
		array('name'=> esc_html__( 'Slidingbar','lapindos'),
			'id'	=>'slidingbar-widget',
			'description'=> esc_html__('The widget will displayed at sliding bar (side menu).', 'lapindos'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>'
		)
	);


	register_sidebar(
		array('name'=> esc_html__( 'Bottom','lapindos'),
			'id'	=>'footer-widget',
			'description'=> esc_html__('The widget will displayed at bottom area before footer text.', 'lapindos'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>'
		)
	);

	if(class_exists('TG_Custom_Post')){
		register_sidebar(
			array('name'=> esc_html__( 'Portfolio Page','lapindos'),
				'id'	=>'portfolio-widget',
				'description'=> esc_html__('The widget will displayed at detail portfolio post.', 'lapindos'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="widget-title">',
				'after_title' => '</div>'
			)
		);

		add_filter('tg_custom_post_metabox_title', create_function('', 'return esc_html__(\'Portfolio Information\',\'lapindos\');'));

	}

	if(class_exists('petro_service')){
		register_sidebar(
			array('name'=> esc_html__( 'Service Page','lapindos'),
				'id'	=>'service-widget',
				'description'=> esc_html__('The widget will displayed at detail service post.', 'lapindos'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="widget-title">',
				'after_title' => '</div>'
			)
		);

	}

	if (function_exists('is_shop')) {

		register_sidebar(
			array('name'=> esc_html__('Shop Sidebar Widget Area', 'lapindos'),
				'id'=>'shop-sidebar',
				'description'=> esc_html__('Sidebar will display on woocommerce page only', 'lapindos'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="widget-title">',
				'after_title' => '</div>'
			));

	}

	add_action( 'wp_enqueue_scripts', 'lapindos_config_loader',1);
	add_action( 'wp_enqueue_scripts', 'lapindos_enqueue_scripts', 9999);
	add_filter( 'theme_mod_header_image', 'lapindos_header_image',1);
	add_filter( 'themegum_glyphicon_list', 'lapindos_awesome_icon_lists' );
	add_action( 'themegum-glyph-icon-loaded','lapindos_load_service_glyph');
} 

add_action('after_setup_theme','lapindos_startup');

require_once( get_template_directory().'/lib/tgm.php');
require_once( get_template_directory().'/lib/themegum_functions.php');
require_once( get_template_directory().'/lib/options.php');
require_once( get_template_directory().'/lib/widgets.php');
require_once( get_template_directory().'/lib/category_attributes.php');

if(function_exists('is_shop')){
  require_once( get_template_directory().'/lib/woocommerce.php'); 
}


if(function_exists('wp_landing_add_element_option')){
	require_once( get_template_directory().'/lib/nuno_elements.php');
}


function lapindos_enqueue_scripts(){


	if(!is_admin() && !defined('IFRAME_REQUEST')) {

		/* just front loaded */

		  if(class_exists('wp_landing') && (''!= lapindos_get_config('pre-footer-page') || ''!=lapindos_get_config('footer-page') ) ){

				wp_landing::wp_landing_load_front_css_style();
				wp_landing::wp_landing_load_front_script();
		  }

	 	wp_enqueue_style( 'lapindos-stylesheet', get_template_directory_uri() . '/style.css', array(), '', 'all');
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.5' );	

		$blog_id="";
		if ( is_multisite()){
			$blog_id="-site".get_current_blog_id();
		}

		wp_enqueue_style( "awesomeicon",get_template_directory_uri() . '/fonts/font-awesome/font-awesome.css', array(), '', 'all' );
		lapindos_load_service_glyph();

		wp_enqueue_style( "lapindos-main-style",get_template_directory_uri() . '/css/themestyle.css', array(), '', 'all' );
        wp_enqueue_style( 'lapindos-main-ie', get_template_directory_uri(). '/css/themestyle_ie9.css', array('lapindos-main-style'));

        wp_style_add_data( 'lapindos-main-ie', 'conditional', 'IE' );


		if(is_rtl()){
			wp_enqueue_style( "lapindos-rtl-style",  get_template_directory_uri() . '/css/themestyle-rtl.css', array(), '', 'all' );
		}

		wp_enqueue_style( 'poppins-font' , esc_url('//fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800,800i'));

		$bodyFont=lapindos_get_config('body-font');

		if (isset($bodyFont['font-family']) && isset($bodyFont['google']) && $bodyFont['font-family']!='') {
			if (isset($bodyFont['google']) && $bodyFont['google']) {
				$fontfamily = $bodyFont['font-family'];
				$subsets = (!empty($bodyFont['subsets'])) ? $bodyFont['subsets']: '';
				wp_enqueue_style( sanitize_title($fontfamily) , lapindos_slug_font_url($fontfamily,$subsets));
			}	
		}

		$headingFont=lapindos_get_config('heading-font');

		if (isset($headingFont['font-family']) && isset($headingFont['google']) && $headingFont['font-family']!='') {
			if (isset($headingFont['google']) && $headingFont['google']) {
				$fontfamily = $headingFont['font-family'];
				$subsets = (!empty($headingFont['subsets'])) ? $headingFont['subsets']: '';
				wp_enqueue_style( sanitize_title($fontfamily) , lapindos_slug_font_url($fontfamily,$subsets));
			}	
		}
		
		$subheadingFont=lapindos_get_config('sub-heading-font');

		if (isset($subheadingFont['font-family']) && isset($subheadingFont['google']) && $subheadingFont['font-family']!='') {
			if (isset($subheadingFont['google']) && $subheadingFont['google']) {
				$fontfamily = $subheadingFont['font-family'];
				$subsets = (!empty($subheadingFont['subsets'])) ? $subheadingFont['subsets']: '';
				wp_enqueue_style( sanitize_title($fontfamily) , lapindos_slug_font_url($fontfamily,$subsets));
			}	
		}


		if(is_child_theme()){
			wp_enqueue_style( 'lapindos-child-theme-style',get_stylesheet_directory_uri() . '/style.css', array(), '', 'all' );
		}



		if(!get_option( 'css_folder_writeable',true) || lapindos_get_config('devmode',false)){

			$custom_css = get_theme_mod( 'custom_css' );
			wp_add_inline_style( 'lapindos-main-style', $custom_css);

		}else{
			wp_enqueue_style( "lapindos-site-style",get_template_directory_uri() . '/css/style'.$blog_id.'.css', array(), '', 'all' );
		}

		if(''!=lapindos_get_config('footer-page') && ($page_id = lapindos_get_config('footer-page'))){
			$page_css = get_post_meta( $page_id, '_abuilder_custom_css', true );
			wp_add_inline_style( 'lapindos-main-style', $page_css);

		}

	}


    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'modernizr' , get_template_directory_uri() . '/js/modernizr.custom.js', array(), '1.0', true );
    wp_enqueue_script( 'bootstrap' , get_template_directory_uri() . '/js/bootstrap'.$suffix.'.js', array( 'jquery' ), '3.2.0', true );
    wp_enqueue_script( 'lapindos-theme-script' , get_template_directory_uri() . '/js/themescript.js', array( 'jquery','bootstrap'), '1.0', true );
    wp_enqueue_script( 'jquery.magnific-popup' , get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery'), '1.0', true );

    if(is_single() || is_page()){
	 	wp_enqueue_script( 'comment-reply' );
    }


	$custom_js=lapindos_get_config('js-code','');

	if(!empty($custom_js)){
		wp_add_inline_script('lapindos-theme-script', $custom_js);
	}


}

function lapindos_load_service_glyph(){
	wp_enqueue_style( "cleaning-service-glyph",get_template_directory_uri() . '/fonts/fontello-cleaning/service-cleaning.css', array(), '', 'all' );
}


function lapindos_slug_font_url($font_family,$subset,$font_weight='300,300italic,400,400italic,700,700italic,800,800italic,900,900italic') {

	$fonts_url = '';
	if ( !empty($font_family )) {
		$font_families = array();
	 
		$font_families[] = $font_family.':'.$font_weight;

		 
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( $subset ),
		);
		 
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	 
	return esc_url_raw( $fonts_url );
} 


function lapindos_awesome_icon_lists($icons){


  $icon_path=get_template_directory()."/fonts/fontello-cleaning/";

  if($service_icons = lapindos_get_glyph_lists($icon_path)){
    $icons = is_array($icons) ? array_merge( $icons, $service_icons ) : $service_icons;
  }

  $awesome_icon_path=get_template_directory()."/fonts/font-awesome/";

  if($awesome_icons = lapindos_get_glyph_lists($awesome_icon_path)){
    $icons = is_array($icons) ? array_merge( $icons, $awesome_icons ) : $awesome_icons;
  }

  return array_unique($icons);
}


?>