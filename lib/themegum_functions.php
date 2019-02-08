<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

function lapindos_wp_landing_button_skin($skins= array()){

    if(!is_array($skins)){
      $skins = array();
    }

    $skins['default'] =esc_html__("Default", 'lapindos');
    $skins['default-ghost'] = esc_html__('Outline','lapindos');
    $skins['primary'] = esc_html__('Primary Color','lapindos');
    $skins['primary-ghost'] = esc_html__('Primary Color(Outline)','lapindos');
    $skins['primary-thirdy'] = esc_html__('Primary - Third Color','lapindos');
    $skins['secondary'] = esc_html__('Secondary Color','lapindos');
    $skins['secondary-ghost'] = esc_html__('Secondary Color(Outline)','lapindos');
    $skins['secondary-thirdy'] = esc_html__('Secondary - Third Color','lapindos');
    $skins['thirdy'] = esc_html__('Third Color','lapindos');
    $skins['thirdy-ghost'] = esc_html__('Third Color(Outline)','lapindos');
    $skins['thirdy-secondary'] = esc_html__('Third - Secondary Color','lapindos');

    return $skins;

}

function lapindos_get_custom_logo( $blog_id = 0 ) {
  $html = '';
  $switched_blog = false;

  if ( is_multisite() && ! empty( $blog_id ) && (int) $blog_id !== get_current_blog_id() ) {
    switch_to_blog( $blog_id );
    $switched_blog = true;
  }

  $custom_logo_id = get_theme_mod( 'custom_logo' );

  // We have a logo. Logo is go.
  if ( $custom_logo_id ) {
    $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
      esc_url( home_url( '/' ) ),
      wp_get_attachment_image( $custom_logo_id, 'full', false, array(
        'class'    => 'custom-logo',
      ) )
    );
  }

  // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
  elseif ( is_customize_preview() ) {
    $html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo"/></a>',
      esc_url( home_url( '/' ) )
    );
  }

  if ( $switched_blog ) {
    restore_current_blog();
  }

  /**
   * Filters the custom logo output.
   *
   * @since 4.5.0
   * @since 4.6.0 Added the `$blog_id` parameter.
   *
   * @param string $html    Custom logo HTML output.
   * @param int    $blog_id ID of the blog to get the custom logo for.
   */
  return apply_filters( 'get_custom_logo', $html, $blog_id );
}


function lapindos_get_author_blog_url($echo=false){
  $url="<a href=\"".get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )."\">".get_the_author()."</a>";
  if($echo)
    print wp_kses($url,array('a'=>array('href'=>array())));
  return $url;
}


function lapindos_header_image($mod){

  if(is_customize_preview()) return $mod;

  global $lapindos_header_image_once_one;

  if(isset($lapindos_header_image_once_one) && $lapindos_header_image_once_one) return $lapindos_header_image_once_one;

  $images= null;

  if(is_front_page()){
    $post_id = get_option('page_on_front');

    if(function_exists('is_shop') && is_shop()){
       $post_id=get_option( 'woocommerce_shop_page_id');
    }

    $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );

    if(($banner_image= isset($lapindos_page_args['banner_id']) ? absint($lapindos_page_args['banner_id']): '' )){
        $images = wp_get_attachment_image_src( $banner_image, 'full');
    }

  }
  elseif(is_page()){
    $post_id=get_the_id();

    $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );

    if(($banner_image= isset($lapindos_page_args['banner_id']) ? absint($lapindos_page_args['banner_id']): '' )){
        $images = wp_get_attachment_image_src( $banner_image, 'full');
    }

  }
  elseif(is_home()){
     $post_id=get_option( 'page_for_posts');

      $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );

      if(($banner_image= isset($lapindos_page_args['banner_id']) ? absint($lapindos_page_args['banner_id']): '' )){
          $images = wp_get_attachment_image_src( $banner_image, 'full');
      }

  }
  elseif(is_category() || is_tag() ){
    $term = get_queried_object();
    if(($category_image=get_metadata('term', $term->term_id, '_thumbnail_id', true))){
        $images = wp_get_attachment_image_src( $category_image, 'full');
    }
  }
  elseif(is_archive()){

    if(function_exists('is_shop') && (is_shop() || is_product_category())){
      $post_id=get_option( 'woocommerce_shop_page_id');

      $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );

      if(($banner_image= isset($lapindos_page_args['banner_id']) ? absint($lapindos_page_args['banner_id']): '' )){
          $images = wp_get_attachment_image_src( $banner_image, 'full');
      }

    } 
  }

  elseif(is_single()){

    $post_type = get_post_type();

    if(function_exists('is_product') && is_product()){

      if(($banner_image = lapindos_get_config( 'shop_heading_image', false))){

        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
      }
    }
    elseif($post_type=='post' && lapindos_get_config( 'blog_featured_image', false)){

        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $images = wp_get_attachment_image_src($thumb_id, 'full', false); 
    }
    elseif(($banner_image = lapindos_get_config( $post_type.'_featured_image', false))){
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $images = wp_get_attachment_image_src($thumb_id, 'full', false); 
    }elseif(($banner_image = lapindos_get_config( $post_type.'_heading_image', false))){
        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
    }


  }
  elseif(is_author()){

        $author = get_queried_object();

        if($author && ($banner_image=get_user_meta( $author->ID, '_banner_id', true))){
            $images = wp_get_attachment_image_src( $banner_image, 'full');
        }
 }
 elseif(is_search()){

      if(($banner_image = lapindos_get_config( 'search_heading_image', false))){

        if($banner_image && isset($banner_image['id']) && $banner_image['id']!=''){
             $images = wp_get_attachment_image_src( $banner_image['id'], 'full');
        }
      }
 }

  if(! $images){
    $default_image  = lapindos_get_config( 'heading_image', false);
    if($default_image && isset($default_image['url']) && $default_image['url']!=''){
      $lapindos_header_image_once_one = $default_image['url'];
    }
    else{
      $url = get_theme_support( 'custom-header', 'default-image' );
     $lapindos_header_image_once_one = $url;
    }
  }

  if($images){
    $lapindos_header_image_once_one =  $images[0];
  }else{
    $lapindos_header_image_once_one = $mod;
  }

  return $lapindos_header_image_once_one;
}


function lapindos_header_image_tag($html){

  if(is_customize_preview()) return $html;

  $heading_position = lapindos_get_config('heading_position');

  if($heading_position == 'fixed'){
    $html= '<div class="heading-fixed">'.$html.'</div>';    
  }

  return $html;

}

add_filter( 'get_header_image_tag','lapindos_header_image_tag');



function lapindos_config_loader(){

  $front_config=array();

  if(isset( $GLOBALS['front_config']) ){
    $front_config = & $GLOBALS['front_config'];
  }
  else{
    $GLOBALS['front_config']= & $front_config;
  }

  global $lapindos_config;

  $is_boxed=true;
  $bg_image_id=0;
  $the_title = "";


  if(isset($lapindos_config['boxed_background_image']) && array_key_exists('id',$lapindos_config['boxed_background_image']) ){
      $bg_image_id=$lapindos_config['boxed_background_image']['id'];
  } 

  if( !isset($lapindos_config['enable_boxed']) || (isset($lapindos_config['enable_boxed']) && !$lapindos_config['enable_boxed']) ) 
    $is_boxed=false;

  if(is_front_page()){

    $post_id = get_option('page_on_front');

    if(function_exists('is_shop') && is_shop()){
       $post_id=get_option( 'woocommerce_shop_page_id');       
    }

    $the_title = $post_id ? get_the_title($post_id) : "";
  }
  elseif(is_page()){
    $post_id=get_the_id();
    $the_title=get_the_title();

  }
  elseif(is_category() || is_tag() ){

  }
  elseif(is_archive()){

    if(function_exists('is_shop') && is_shop()){
      $post_id=get_option( 'woocommerce_shop_page_id');

      $the_title = $post_id ? get_the_title($post_id) : "";
    } 

    if( ($post_type = get_post_type())){

      $menu_id = isset($lapindos_config[$post_type.'_menu_id']) ? $lapindos_config[$post_type.'_menu_id'] : '';

      if($menu_id!=''){
        lapindos_set_config('main_menu_id' , $menu_id);
      }

    }

  }
  elseif(is_search()){
        add_filter('lapindos_use_breadcrumb','__return_false');
        $the_title= lapindos_get_config('search_heading_title','');
  }
  elseif(is_home()){
     $post_id=get_option( 'page_for_posts');
     $the_title = $post_id ? get_the_title($post_id) : "";
  }
  elseif(is_404()){

  }
  elseif(function_exists('is_product')  && (is_product() || is_product_category())){
    $the_title=get_the_title();
  }
  else{
    $post_id=get_the_ID();
    $the_title=get_the_title();
  }

  if(is_single()){

    $post_type = get_post_type();
    $title_position = isset($lapindos_config[$post_type.'_title_position']) ? $lapindos_config[$post_type.'_title_position'] : 'content';

    $menu_id = isset($lapindos_config[$post_type.'_menu_id']) ? $lapindos_config[$post_type.'_menu_id'] : '';

    if($menu_id!=''){
      lapindos_set_config('main_menu_id' , $menu_id);
    }

    switch ($title_position) {
      case 'hidden':
        $the_title = '';
        break;
      case 'header':
            if(isset($lapindos_config['hide_heading']) && $lapindos_config['hide_heading']){
              lapindos_set_config('title_position' , 'content');
            }
            else{
              lapindos_set_config('title_position' , 'header');
              remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

            }
        break;
      case 'content':
      default:
        add_filter('lapindos_hide_page_title','__return_true');

        lapindos_set_config('title_position' , 'content');
        break;
    }

  }

  if(isset($post_id) && $post_id){

      $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );


      if(isset($lapindos_page_args['hide_heading']) && (bool)$lapindos_page_args['hide_heading'] ){
        lapindos_set_config('hide_heading' , true);
        lapindos_set_config('heading_position' , '');
      }

      if(isset($lapindos_page_args['hide_heading_title']) && (bool)$lapindos_page_args['hide_heading_title'] ){

        lapindos_set_config('hide_heading_title' , true);
      }

      $footer_type = isset( $lapindos_config['footer-type']) ? $lapindos_config['footer-type'] : 'option';

      if($footer_type == 'page' && isset($lapindos_page_args['page_footer']) && ($page_footer = $lapindos_page_args['page_footer'] )){

        lapindos_set_config('footer-page' , $page_footer);
      }
      elseif($footer_type == 'option' && isset($lapindos_page_args['pre_page_footer']) && ($pre_page_footer = $lapindos_page_args['pre_page_footer'] ) ){
        lapindos_set_config('pre-footer-page' , $pre_page_footer);
      }

      if(isset($lapindos_page_args['menu_id']) && ($menu_id = $lapindos_page_args['menu_id'] )){

        lapindos_set_config('main_menu_id' , $menu_id);
      }


  }

  lapindos_set_config('the_title' , $the_title);

}

function lapindos_slides_show($params=array()){

    $args = wp_parse_args($params, 
      array(
        'el_id'=>'slides',
        'class'=>'',
        'play'=>5000,
        'animation'=>'slide',
        'easing'=>'swing',
        'container_width'=>'',
        'container_height'=>'',
        'slide_animation'=>'',
        'slide_speed'=>800,
        'pagination'=>true,
    ));

    $slides = lapindos_get_config( 'nuno-slides',array());

    if(!count($slides)) return;

    $slides_html = array();
    $slide_animation = (isset($args['slide_animation']) && $args['slide_animation'] !='') ? $args['slide_animation'] : '';

    wp_enqueue_script( 'easing' , get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), '1.3', true );
    wp_enqueue_script( 'superslides' , get_template_directory_uri() . '/js/jquery.superslides.js', array('jquery','easing'), '1.0', true );


    foreach ($slides as $slide) {

      ob_start();

      $title = isset($slide['title']) ? $slide['title'] : '';

      $description = isset($slide['description']) ? $slide['description'] : '';

      $url1 = isset($slide['url']) ? $slide['url'] : '';
      $url2 = isset($slide['url2']) ? $slide['url2'] : '';
      $btn1 = isset($slide['btn']) ? $slide['btn'] : '';
      $btn2 = isset($slide['btn2']) ? $slide['btn2'] : '';
      $image = isset($slide['attachment_id']) ? $slide['attachment_id'] : '';

      $content_align = isset($slide['align']) ? $slide['align'] : '';

      if(function_exists('icl_t')){
        $title= icl_t('lapindos', sanitize_key( $title ), $title );
        $description= icl_t('lapindos', sanitize_key( $description ), $description);
        $btn1= icl_t('lapindos', sanitize_key( $btn1 ), $btn1);
        $btn2= icl_t('lapindos', sanitize_key( $btn2 ), $btn2);

      }


      if($image){

          $slide_image = wp_get_attachment_image_src($image,'full',false); 

          if($slide_image){

             $alt_image = get_post_meta($image, '_wp_attachment_image_alt', true);

             if(function_exists('icl_t')){
                $alt_image = icl_t('lapindos', sanitize_key( $alt_image ), $alt_image );
             }

            print '<img src="'.esc_url($slide_image[0]).'" alt="'.esc_attr($alt_image).'" />';

          }
      }
      ?>
<div class="overlay-bg"></div>
<div class="container">
  <div class="wrap-caption <?php print sanitize_html_class($content_align);?> <?php print ($slide_animation !='') ? 'animated-'.sanitize_html_class($slide_animation) : '';?>">
    <?php 
    print ($title!='') ? '<h2 class="caption-heading">'.esc_html($title).'</h2>': '';
    print ($description!='') ? '<p class="excerpt">'.esc_html($description).'</p>': '';
    print ($btn1!='') ? '<a href="'.esc_url($url1).'" class="btn btn-primary">'.esc_html($btn1).'</a>': '';
    print ($btn2!='') ? '<a href="'.esc_url($url2).'" class="btn btn-secondary">'.esc_html($btn2).'</a>': '';
    ?>    
  </div>
</div>
<?php
      $slides_html[]= ob_get_clean();
      
    }


if(!count($slides_html)) return;

$slide_id =  !empty($args['el_id']) ? $args['el_id'] : 'slides';

$slide_width = $slide_height = 'window';

if($args['container_width'] == 'no'){
  $slide_width ='\'#'.$slide_id.'\'';
}

if($args['container_height'] == 'no'){
  $slide_height ='\'#'.$slide_id.'\'';
}



?>
<div id="<?php print esc_attr($slide_id);?>" class="<?php print esc_attr($args['class']);?> nuno-slide">
    <ul class="slides-container">
      <li>
    <?php print implode('</li><li>',$slides_html);?>
      </li>
    </ul>
<?php if($args['pagination']):?>
    <nav class="slides-navigation">
      <div class="container">
        <a href="#" class="next">
          <i class="fa fa-chevron-right"></i>
        </a>
        <a href="#" class="prev">
          <i class="fa fa-chevron-left"></i>
        </a>
          </div>
      </nav>    
<?php endif;?>
  </div>
<script type="text/javascript">
  jQuery(document).ready(function($){
    'use strict';
    $('#<?php print esc_js($slide_id);?>').superslides({
      play: <?php print esc_js($args['play']);?>,
      animation_speed: <?php print esc_js($args['slide_speed']);?>,
      inherit_height_from: <?php print $slide_height;?>,
      inherit_width_from: <?php print $slide_width;?>,
      pagination: <?php print ($args['pagination']) ? 'true':'false';?>,
      hashchange: false,
      scrollable: true,
<?php print (isset($args['easing']) && $args['easing']!='' ) ? 'animation_easing:\''. sanitize_html_class($args['easing']).'\',' : '';?>
      animation: '<?php print ($args['animation'] =='fade') ? 'fade':'slide';?>'            
    });
  });
</script>
<?php
}


function lapindos_is_has_image($page_id=null){
  
  if(empty($page_id)){
      $page_id=get_the_ID();
  }

  if(isset( $GLOBALS['front_config']) ){
    $front_config = & $GLOBALS['front_config'];
    if(array_key_exists('has_img_background',$front_config)){
      $return = $front_config['has_img_background'];
    }
    else{
      $return = false;
    }

  }
  else{
    $return = false;
  }

  return apply_filters('lapindos_is_has_image',$return,$page_id);
}


function lapindos_get_config($key,$default=null){

  global $lapindos_config;

  if(isset( $GLOBALS['front_config']) ){
    $front_config = $GLOBALS['front_config'];
    $lapindos_config=array_merge($front_config,$lapindos_config);
  }

  if(array_key_exists($key, $lapindos_config)){

      if(in_array($key, lapindos_translateable_config())){
        return apply_filters('lapindos_get_config_maybe_translate',$lapindos_config[$key],$key);
      }

      return $lapindos_config[$key];
  }
  return $default;
}

function lapindos_set_config($key, $value ){
  global $lapindos_config;

  if(isset( $GLOBALS['front_config']) ){
    $front_config = $GLOBALS['front_config'];
    $lapindos_config=array_merge($front_config,$lapindos_config);
  }

  $lapindos_config[$key] = $value;
}



function lapindos_get_config_from_pll($string="", $key=''){

  if($key=='') return $string;

  return pll__($string);
}


function lapindos_pll_register_string($config = array()){

   $translate_vars= lapindos_translateable_config();

   if(!count($translate_vars)) return;

   foreach ($translate_vars as $key) {

      $string = isset($config[$key]) ? $config[$key] : '';
      pll_register_string( $key, $string, 'lapindos', true );
   }

}

if(function_exists('pll_register_string')){

  add_action('lapindos_change_style','lapindos_pll_register_string');
  add_filter('lapindos_get_config_maybe_translate','lapindos_get_config_from_pll',1,2);
}



function lapindos_get_config_from_icl($string="", $key=''){

  if($key=='') return $string;
  return icl_t('lapindos', $key , $string);
}


if(function_exists('icl_t')){
  add_filter('lapindos_get_config_maybe_translate','lapindos_get_config_from_icl',1,2);
}

/**
 * sidebar function
 * @since Lapindos 1.0.0
 */
function lapindos_sidebar_loader(){


  global $lapindos_config;

  $sidebar_position = 'default';
  $sidebar='sidebar-widget';


  if(function_exists('is_shop') && is_shop()){

    $post_id=get_option( 'woocommerce_shop_page_id');
    $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );
    $sidebar_position = isset($lapindos_page_args['sidebar_position']) ? $lapindos_page_args['sidebar_position'] : 'default';

    if($sidebar_position == 'default'){
      $sidebar_position = isset($lapindos_config['shop_sidebar_position']) ? $lapindos_config['shop_sidebar_position'] : 'default';
    }

    $sidebar='shop-sidebar';

  }
  elseif(is_home()){
    $post_id=get_option( 'page_for_posts');
    $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );
    $sidebar_position = isset($lapindos_page_args['sidebar_position']) ? $lapindos_page_args['sidebar_position'] : 'default';
  }
  elseif (is_page()){
    $post_id= get_the_ID();


    if(function_exists('is_shop') &&  in_array($post_id , array( get_option( 'woocommerce_checkout_page_id' ) ,get_option( 'woocommerce_cart_page_id' ), get_option( 'woocommerce_myaccount_page_id' ),get_option('woocommerce_registration_page_id')))){
      $sidebar_position = 'nosidebar';
      $sidebar='shop-sidebar';

    }else{
      $lapindos_page_args = get_post_meta( $post_id, '_lapindos_page_args', true );
      $sidebar_position = isset($lapindos_page_args['sidebar_position']) ? $lapindos_page_args['sidebar_position'] : 'default';
    }

  }
  elseif(is_single()){
    
    $post_type = get_post_type();

    $sidebar_position = isset($lapindos_config[$post_type.'_sidebar_position']) ? $lapindos_config[$post_type.'_sidebar_position'] : 'default';

    if($post_type == 'product'){ $sidebar='shop-sidebar'; }
  }
  elseif(is_author()){
    $sidebar_position = isset($lapindos_config['author_sidebar_position']) ? $lapindos_config['author_sidebar_position'] : 'default';
  }  
  elseif(is_category() || is_tax()){

    $taxonomy = 'category';
    $term = get_queried_object();

    if($term){
      $taxonomy = $term->taxonomy;
      if($taxonomy == 'product_cat'){ $sidebar='shop-sidebar'; }
    }

    $sidebar_widget_function = 'lapindos_'.$taxonomy.'_sidebar_name';

    if( is_callable($sidebar_widget_function) ){
      $sidebar = $sidebar_widget_function($sidebar);
      add_filter('lapindos_sidebar_name', $sidebar_widget_function );
    }

    if($term && ($term_id = $term->term_id )){

      $hide_sidebar = get_metadata( 'term', $term_id, '_hide_sidebar', true );

      if($hide_sidebar=='1'){

        $lapindos_config[$term->taxonomy.'_sidebar_position'] = 'nosidebar';
      }
    }


    $sidebar_position = isset($lapindos_config[$taxonomy.'_sidebar_position']) ? $lapindos_config[$taxonomy.'_sidebar_position'] : 'default';

  }
  elseif(is_search()){

        $sidebar_position = isset($lapindos_config['search_sidebar_position']) ? $lapindos_config['search_sidebar_position'] : 'default';
  }

  if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){
    $sidebar_position = isset($lapindos_config['sidebar_position']) ? $lapindos_config['sidebar_position'] : "";

    if($sidebar_position == ''  || !in_array( $sidebar_position, array("nosidebar","left","right"))) $sidebar_position = "left";
  }

  $sidebar = apply_filters('lapindos_post_type_sidebar', $sidebar);
  $is_active_sidebar = is_active_sidebar( $sidebar );


  if($sidebar == 'portfolio-widget' && !$is_active_sidebar && isset($lapindos_config['hide_detail']) && (bool) $lapindos_config['hide_detail']){
    $sidebar_position= 'nosidebar';
  }

  if($sidebar_position!='nosidebar' && ( $sidebar == 'portfolio-widget' || $is_active_sidebar)){

    add_filter('is_themegum_load_sidebar','__return_true');
    $sidebar_grid = isset($lapindos_config['post_grid']) ? absint($lapindos_config['post_grid']) : 3; 
    $content_grid = 12 - $sidebar_grid;

    if($sidebar_position=='left'){
        add_filter( 'themegum_sidebar_css_column', 'lapindos_left_sidebar_'.$sidebar_grid );
        add_filter( 'themegum_content_css_column', 'lapindos_left_sidebar_content_'.$content_grid );
    }
    else{
        add_filter( 'themegum_sidebar_css_column', 'lapindos_right_sidebar_'.$sidebar_grid );
        add_filter( 'themegum_content_css_column', 'lapindos_right_sidebar_content_'.$content_grid );
    }

  }
  else{

    add_filter('is_themegum_load_sidebar','__return_false');
    add_filter('themegum_content_css_column',create_function('',' return "col-md-12";'));
  }

  $lapindos_config['sidebar_position']= $sidebar_position;
}

add_action('wp_head','lapindos_sidebar_loader');

function lapindos_service_cat_sidebar_name($name){
  
  return 'service-widget';

}

function lapindos_tg_postcat_sidebar_name($name){
  return 'portfolio-widget';
}


function lapindos_petro_service_sidebar_name($name){

  switch (get_post_type()) {
    case 'petro_service':
      $name = 'service-widget';
      break;
    case 'tg_custom_post':
      $name = 'portfolio-widget';
      break;
    default:
      break;
  }
  return $name;

}

add_filter('lapindos_post_type_sidebar', 'lapindos_petro_service_sidebar_name');


function lapindos_left_sidebar_2(){

  return 'col-sm-6 col-sm-pull-6 col-md-2 col-md-pull-10';
}

function lapindos_left_sidebar_content_10(){

  return 'col-sm-6 col-sm-push-6 col-md-10 col-md-push-2';
}

function lapindos_left_sidebar_3(){

  return 'col-sm-6 col-sm-pull-6 col-md-3 col-md-pull-9';
}

function lapindos_left_sidebar_content_9(){

  return 'col-sm-6 col-sm-push-6 col-md-9 col-md-push-3';
}

function lapindos_left_sidebar_4(){

  return 'col-sm-6 col-sm-pull-6 col-md-4 col-md-pull-8';
}

function lapindos_left_sidebar_content_8(){

  return 'col-sm-6 col-sm-push-6 col-md-8 col-md-push-4';
}

function lapindos_left_sidebar_5(){

  return 'col-sm-6 col-sm-pull-6 col-md-5 col-md-pull-7';
}

function lapindos_left_sidebar_content_7(){

  return 'col-sm-6 col-sm-push-6 col-md-7 col-md-push-5';
}

function lapindos_left_sidebar_6(){

  return 'col-sm-6 col-sm-pull-6';
}

function lapindos_left_sidebar_content_6(){

  return 'col-sm-6 col-sm-push-6';
}

/*
 *
 */
function lapindos_right_sidebar_2(){
  
  return 'col-sm-6 col-md-2';
}

function lapindos_right_sidebar_content_10(){

  return 'col-sm-6 col-md-10';
}

function lapindos_right_sidebar_3(){

  return 'col-sm-6 col-md-3';
}

function lapindos_right_sidebar_content_9(){

  return 'col-sm-6 col-md-9';
}

function lapindos_right_sidebar_4(){

  return 'col-sm-6 col-md-4';
}

function lapindos_right_sidebar_content_8(){

  return 'col-sm-6 col-md-8';
}

function lapindos_right_sidebar_5(){

  return 'col-sm-6 col-md-5';
}

function lapindos_right_sidebar_content_7(){

  return 'col-sm-6 col-md-7';
}

function lapindos_right_sidebar_6(){

  return 'col-sm-6 col-md-6';
}

function lapindos_right_sidebar_content_6(){

  return 'col-sm-6 col-md-6';
}



/* bottom widget column
 *
 */

function lapindos_makeBottomWidgetColumn($params){

  if('footer-widget' !=$params[0]['id']) return $params;

  global $wp_registered_sidebars, $register_one;

  $class="col-sm-4";
  $col=(int)lapindos_get_config('footer-widget-column',4);


  switch($col){

      case 2:
            $class='col-md-6 col-sm-12 col-xs-12';
        break;
      case 3:
            $class='col-md-4 col-sm-4 col-xs-12';
        break;
      case 4:
            $class='col-lg-3 col-md-3 col-sm-4 col-xs-12';
        break;
      case 1:
      default:
            $class='col-sm-12';
        break;
  }


  $params[0]['before_widget']='<div class="'.esc_attr($class).' col-'.esc_attr($col).'">'.$params[0]['before_widget'];
  $params[0]['after_widget']=$params[0]['after_widget'].'</div>';

  return $params;
}

add_filter( 'dynamic_sidebar_params', 'lapindos_makeBottomWidgetColumn' );


function lapindos_BottomWidget($instance, $widget_obj, $args){


  if('footer-widget' !=$args['id']) return $instance;

  global $wp_registered_sidebars, $register_one;

  if(isset($register_one)) return $instance;

    $footerwidget= $wp_registered_sidebars['footer-widget'];

    $class="col-sm-4";
    $col=(int)lapindos_get_config('footer-widget-column',4);


    switch($col){

        case 2:
              $class='col-md-6 col-sm-12 col-xs-12';
          break;
        case 3:
              $class='col-md-4 col-sm-4 col-xs-12';
          break;
        case 4:
              $class='col-lg-3 col-md-3 col-sm-4 col-xs-12';
          break;
        case 1:
        default:
              $class='col-sm-12';
          break;
    }


    $footerwidget['before_widget'] ='<div class="col '.esc_attr($class).' col-'.esc_attr($col).'">'.$footerwidget['before_widget'];
    $footerwidget['after_widget'] = $footerwidget['after_widget'].'</div>';

    $wp_registered_sidebars['footer-widget'] = $footerwidget;

    $register_one = true;

    return $instance;
}


add_filter( 'widget_display_callback', 'lapindos_BottomWidget',1,3);
/**
 * main menu walker
 * @since Lapindos 1.0.0.0
 */

class mainmenu_page_walker extends Walker_Page{

  /**
   * Outputs the beginning of the current element in the tree.
   *
   * @see Walker::start_el()
   * @since 2.1.0
   * @access public
   *
   * @param string  $output       Used to append additional content. Passed by reference.
   * @param WP_Post $page         Page data object.
   * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
   * @param array   $args         Optional. Array of arguments. Default empty array.
   * @param int     $current_page Optional. Page ID. Default 0.
   */
  public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
    if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
      $t = "\t";
      $n = "\n";
    } else {
      $t = '';
      $n = '';
    }
    if ( $depth ) {
      $indent = str_repeat( $t, $depth );
    } else {
      $indent = '';
    }

    $css_class = array( 'page_item', 'page-item-' . $page->ID );

    /**
    * Add caret at dropdown menu
    * @package Petro
    * @since   1.0.0
    */
    $caret  = '';

    if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
      $css_class[] = 'page_item_has_children';
      $caret = '<span class="caret"></span>';
    }

    if ( ! empty( $current_page ) ) {
      $_current_page = get_post( $current_page );
      if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
        $css_class[] = 'current_page_ancestor';
      }
      if ( $page->ID == $current_page ) {
        $css_class[] = 'current_page_item';
      } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
        $css_class[] = 'current_page_parent';
      }
    } elseif ( $page->ID == get_option('page_for_posts') ) {
      $css_class[] = 'current_page_parent';
    }

    /**
     * Filters the list of CSS classes to include with each page item in the list.
     *
     * @since 2.8.0
     *
     * @see wp_list_pages()
     *
     * @param array   $css_class    An array of CSS classes to be applied
     *                              to each list item.
     * @param WP_Post $page         Page data object.
     * @param int     $depth        Depth of page, used for padding.
     * @param array   $args         An array of arguments.
     * @param int     $current_page ID of the current page.
     */
    $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

    if ( '' === $page->post_title ) {
      /* translators: %d: ID of a post */
      $page->post_title = sprintf( __( '#%d (no title)','lapindos' ), $page->ID );
    }

    $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
    $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

    $title = apply_filters( 'page_menu_item_title', $page->post_title, $page, $args, $depth );

    $output .= $indent . sprintf(
      '<li class="%s"><a href="%s">%s%s%s%s</a>',
      $css_classes,
      get_permalink( $page->ID ),
      $args['link_before'],
      $title,
      $caret,
      $args['link_after']
    );

    if ( ! empty( $args['show_date'] ) ) {
      if ( 'modified' == $args['show_date'] ) {
        $time = $page->post_modified;
      } else {
        $time = $page->post_date;
      }

      $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
      $output .= " " . mysql2date( $date_format, $time );
    }
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<div class=\"sub-menu-container\"><ul class='sub-menu'>\n";
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div>\n";
  }

}

/* main menu walker */
/* make menu dropdown like bootstrap */

class mainmenu_walker extends Walker_Nav_Menu{

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;


    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since 4.4.0
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

    /**
     * Filters the CSS class(es) applied to a menu item's list item element.
     *
     * @since 3.0.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
     * @param WP_Post  $item    The current menu item.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    /**
     * Filters the ID applied to a menu item's list item element.
     *
     * @since 3.0.1
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
     * @param WP_Post  $item    The current menu item.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   Depth of menu item. Used for padding.
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title  Title attribute.
     *     @type string $target Target attribute.
     *     @type string $rel    The rel attribute.
     *     @type string $href   The href attribute.
     * }
     * @param WP_Post  $item  The current menu item.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $depth Depth of menu item. Used for padding.
     */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }


    $title = apply_filters( 'nav_menu_item_title', $item->title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $title . $args->link_after;

    /**
    * Add caret at dropdown menu
    * @package Petro
    * @since   1.0.0
    */

    if(in_array('menu-item-has-children', $classes)){
          $item_output .= '<span class="caret"></span>';
    }

    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filters a menu item's starting output.
     *
     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
     * no filter for modifying the opening and closing `<li>` for a menu item.
     *
     * @since 3.0.0
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @param int      $depth       Depth of menu item. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     */
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .="\t$indent<div class=\"sub-menu-container\"><ul class=\"sub-menu\">\n";
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul></div>\n";
  }

}


function lapindos_excerpt_more($excerpt_more=""){

  return " ";
}

function lapindos_excerpt_length($length=0){

  $exceprt_length = absint(lapindos_get_config('excerpt_length'));
  $exceprt_length = min($exceprt_length , 1000);

  if($exceprt_length) $length = $exceprt_length;

  return $length;

}

add_filter('excerpt_length', 'lapindos_excerpt_length');
add_filter('excerpt_more','lapindos_excerpt_more');

function lapindos_get_excerpt_length(){
  global $lapindos_excerpt_length;

  if(!$lapindos_excerpt_length){
    $lapindos_excerpt_length = apply_filters( 'excerpt_length', 55 );
  }

  return $lapindos_excerpt_length;
}

function lapindos_get_readmore($args=array()){

  $args = wp_parse_args($args, array('echo'=> false,'class'=>array('btn-block','cl-prime'),'label'=> esc_html__('read more','lapindos').' <i class="fa fa-angle-right"></i>' ));
  $more = '<a href="'.get_the_permalink().'" class="read-more '.join(' ', $args['class']).'">'.$args['label'].'</a>'; 

  if( isset($args['echo'])  && !(bool)$args['echo']) return $more;

  print wp_kses($more,array('a'=>array('href'=>array(),'class'=>array()),'span'=>array(),'i'=>array('class'=>array())));
}


function lapindos_get_blog_layout($atts=array()){


      extract(shortcode_atts(array(
          'size'=>'',
          'text_transform'=>'',
          'title_tag'=>'',
          'font_family'=>'',
          'blog_layout'=>'',
          'echo'=>false,
          'excerpt_length'=>55,
          'title_length'=>100
      ), $atts));

      if($blog_layout=='') $blog_layout = 1;

      $blog_html = $thumb = $heading= $text= $meta = '';

      if($title_tag=='') $title_tag = 'h4';

      if($blog_layout!='3'){

          $featured_image = lapindos_get_post_featured_image_tag(get_the_ID());

          $thumb = $featured_image!='' ? '<a href="'.get_the_permalink().'">'.$featured_image.'</a>' : '<div class="blog-image no-image clearfix"></div>';

      }

      $heading = '<a class="cl-prime" href="'.get_the_permalink().'">'.wp_trim_words(get_the_title(), absint($title_length) ,' ...').'</a>';

      $text = wp_trim_words(get_the_excerpt(), absint($excerpt_length), " ");

      ob_start();

      if($blog_layout=='2'){
       get_template_part('template-part/post-meta','lite');
      }
      else{
        get_template_part('template-part/post-meta','lite-top');
      }

      $meta = ob_get_clean();


      $layout_templates=array(
            '1'=>'{thumb}<div class="post-content clearfix"><'.$title_tag.' class="post-title '.$text_transform.' '.$font_family.'">{heading}</'.$title_tag.'><div class="content-excerpt bot-m12 clearfix">{text}</div>{meta}</div>',
            '2'=>'{meta}<div class="post-content top-m12 clearfix"><'.$title_tag.' class="post-title '.$text_transform.' '.$font_family.'">{heading}</'.$title_tag.'><div class="content-excerpt bot-m12 clearfix">{text}</div></div>{thumb}',
            '3'=>'<div class="post-content clearfix"><'.$title_tag.' class="post-title '.$text_transform.' '.$font_family.'">{heading}</'.$title_tag.'><div class="content-excerpt bot-m12 clearfix">{text}</div>{meta}</div>',
            '4'=>'{thumb}<div class="post-content clearfix"><'.$title_tag.' class="post-title '.$text_transform.' '.$font_family.' bot-m12">{heading}</'.$title_tag.'>{meta}</div>',
            '5'=>'{thumb}<div class="post-content hide-first clearfix"><'.$title_tag.' class="post-title '.$text_transform.' '.$font_family.' bot-m12">{heading}</'.$title_tag.'>{meta}</div>'
      );

        $blog_html = isset($layout_templates[$blog_layout]) ? $layout_templates[$blog_layout] : $layout_templates['1'];
        $blog_html = preg_replace('/{heading}/', $heading, $blog_html);
        $blog_html = preg_replace('/{thumb}/', $thumb, $blog_html);
        $blog_html = preg_replace('/{text}/', $text, $blog_html);
        $blog_html = preg_replace('/{meta}/', $meta, $blog_html);

      ob_start();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
  print wp_kses_post($blog_html);
?>
    <div class="clearfix"></div>  
</article>
<?php
      $html = ob_get_clean();

      if(!$echo) return $html;

      print $html;
}


/***
   * Output a comment in the HTML5 format.
   *
   * @access protected
   * @since 3.6.0
   *
   * @see wp_list_comments()
   *
   * @param object $comment Comment to display.
   * @param int    $depth   Depth of comment.
   * @param array  $args    An array of arguments.
  */
  
class lapindos_Walker_Comment extends Walker_Comment{

    protected function comment( $comment, $depth, $args ) {
    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }

?>
    <<?php echo esc_attr($tag); ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    <?php if ( 0 != $args['avatar_size'] && 'pingback' != $comment->comment_type ) :?>
    <div class="author-avatar">
      <?php echo get_avatar( $comment, $args['avatar_size'] );?> 
    </div>
    <?php endif;?>
    <div class="comment-author vcard">
      <?php 
      print wp_kses( sprintf( __( 'by : %s','lapindos' ), get_comment_author_link( get_comment_id() )), array('a'=>array('href')) ); ?>
      <?php   if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) {?>
    <a class="comment-edit-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
      <?php esc_html_e( '(Edit)' ,'lapindos');?>
      </a>
<?php
       }
?>
      <span class="comment-meta">
      <?php
        /* translators: 1: date, 2: time */
        printf( esc_html__( '%1$s at %2$s','lapindos' ), get_comment_date(),  get_comment_time() ); ?>
      </span>
    </div>
    <?php if ( '0' == $comment->comment_approved ) : ?>
    <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','lapindos' ) ?></em>
    <br />
    <?php endif; ?>

    <div class="comment-text">
    <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php
      comment_reply_link( array_merge( $args, array(
        'add_below' => $add_below,
        'depth'     => $depth,
        'max_depth' => $args['max_depth'],
        'before'    => '',
        'after'     => '',
        'reply_text'=> esc_html__('Reply','lapindos')
      ) ) );
  
      ?>
   
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
  }

  public function start_lvl( &$output, $depth = 0, $args = array() ) {

    $devider = get_option('thread_comments') && $depth && !($depth % 2) ? true : false;

   if($devider){
      $output.='<a href="#" class="comment-collapse">'.esc_html__( 'read more replies ...', 'lapindos').'</a>';
    }

    switch ( $args['style'] ) {
      case 'div':
        break;
      case 'ol':
        $output .= '<ol class="children">' . "\n";
        break;
      case 'ul':
      default:
        $output .= '<ul class="children">' . "\n";
        break;
    }


    $GLOBALS['comment_depth'] = $depth + 1;
  }


}


function lapindos_comment_form(){

      $commenter = wp_get_current_commenter();
      $html5=current_theme_supports( 'html5', 'comment-form' );
      $req      = get_option( 'require_name_email' );
      $aria_req = ( $req ? " aria-required='true'" : '' );
      $html_req = ( $req ? " required='required'" : '' );

      $fields   =  array(
        'author' => '<div class="row"><div class="col-lg-6 col-md-12 comment-form-author">' .
                    '<input id="author" class="inputbox form-control" name="author" type="text" placeholder="'.esc_attr__( 'Enter Name','lapindos' ).'*" value="" size="30"' . ($html5 ? $html_req : $aria_req) . ' /></div>',
        'email'  => '<div class="col-lg-6 col-md-12 comment-form-email">' .
                    '<input id="email" class="inputbox form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_attr__('Enter Email','lapindos' ) . '*" value="" size="30" aria-describedby="email-notes"' . ($html5 ? $html_req : $aria_req)  . ' /></div>',
        'url'    => '<div class="col-xs-12 comment-form-url">' .
                    '<input id="url" class="inputbox form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_attr__('Enter Website','lapindos') . '*" value="" size="30" /></div></div>',
      );

    comment_form(
      array(
        'fields'=>$fields,
        'comment_field'        => '<div class="row"><div class="col-xs-12 comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" class="inputbox form-control" '. ($html5 ? $html_req : $aria_req).' placeholder="'.esc_attr__('Enter Your Comment...','lapindos').'*"></textarea></div></div>',
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="button top-m12 btn btn-primary btn-square %3$s" value="%4$s" />',
        'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
        'label_submit'         => esc_html__('post comment','lapindos'),
        'comment_notes_before' => '<p class="comment-notes"><span id="email-notes"><span class="required">*</span> ' . esc_html__( 'Your email address will not be published.', 'lapindos' ) . '</span></p>',
        'comment_notes_after'  => '', 
        'title_reply_before'=>'<h3 class="h5 heading">',
        'title_reply_after'=>'</h3>',
        'cancel_reply_link'    => esc_html__( 'Cancel' ,'lapindos').' <i class="fa fa-times-circle"></i>',
      )
    );
}


//comment_form_fields

function lapindos_comment_form_fields($comment_fields){

  $comment = $comment_fields['comment'];
  unset($comment_fields['comment']);

  return array_merge($comment_fields , array('comment'=> $comment));

}

add_filter('comment_form_fields','lapindos_comment_form_fields');


function lapindos_get_pagenum_link_from_page($pagenum = 1, $base_url=null, $escape = true ) {
  global $wp_rewrite;

  $pagenum = (int) $pagenum;

  if($base_url){
    $request = remove_query_arg( 'paged' , $base_url );
    $request = preg_replace('|^'. home_url() . '|i', '', $request);
  }
  else{
    $request = remove_query_arg( 'paged');
  }

  $home_root = parse_url(home_url('/'));
  $home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
  $home_root = preg_quote( $home_root, '|' );

  $request = preg_replace('|^'. $home_root . '|i', '', $request);
  $request = preg_replace('|^/+|', '', $request);

  if ( !$wp_rewrite->using_permalinks() || is_admin() ) {
    $base = trailingslashit( home_url() );

    if ( $pagenum > 1 ) {
      $result = add_query_arg( 'paged', $pagenum, $base . $request );
    } else {
      $result = $base . $request;
    }

  } else {

    $qs_regex = '|\?.*?$|';
    preg_match( $qs_regex, $request, $qs_match );

    if ( !empty( $qs_match[0] ) ) {
      $query_string = $qs_match[0];
      $request = preg_replace( $qs_regex, '', $request );
    } else {
      $query_string = '';
    }


    $request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
    $request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
    $request = ltrim($request, '/');


    $base = trailingslashit( home_url('/') );

    if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
      $base .= $wp_rewrite->index . '/';

    if ( $pagenum > 1 ) {
      $request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
    }


    $result = $base . $request . $query_string;
  }

  /**
   * Filters the page number link for the current request.
   *
   * @since 2.5.0
   *
   * @param string $result The page number link.
   */

  $result = apply_filters( 'get_pagenum_link', $result );

  if ( $escape )
    return esc_url( $result );
  else
    return esc_url_raw( $result );
}

function lapindos_pagination($args=array()) {

  $defaults=array(
    'max_num_pages' => false,
    'before' => "",
    'after' => "",
    'base_url' => "",
    'navigation_type' => lapindos_get_config('navigation_type','number'),
    'wrapper'=> "<div class=\"pagination %s\" dir=\"ltr\">%s</div>"
    );

  $args=wp_parse_args($args,$defaults);


  if ($args['max_num_pages'] === false) {
    global $wp_query;
    $args['max_num_pages'] = $wp_query -> max_num_pages;
  }

  $links = array();
  $type = $args['navigation_type'];

  $base = str_replace( 999999999, '%#%', esc_url( lapindos_get_pagenum_link_from_page( 999999999,  $args['base_url'] ) ) );

  $current = max( 1, get_query_var('paged'));
  $next = $current + 1;
  $previous = $current - 1;
  $is_rtl = is_rtl();

  if($type == 'number'){

    $links = paginate_links( array(
      'base' => $base,
      'format' => '?paged=%#%',
      'current' => $current,
      'total' => $args['max_num_pages'],
      'prev_next'   => true,
      'prev_text'   => $is_rtl ? '<span><i class="fa fa-angle-right"></i></span>' : '<span><i class="fa fa-angle-left"></i></span>',
      'next_text'   => $is_rtl ? '<span><i class="fa fa-angle-left"></i>' : '<span><i class="fa fa-angle-right"></i></span>',
      'end_size'    => 0,
      'mid_size'    => 1,
      'before_page_number' => '<span>',
      'after_page_number' => '</span>',
      'type'      => 'array',
    ) );


  }
  else{

    if($previous > 0 ){
      $previous_link = str_replace('%#%', $previous , $base);
      $links[] = '<a class="newest-post btn btn-lg'.($is_rtl ? " rtl":"").'" href="'.esc_url($previous_link).'"><span>'.( $is_rtl ? '<i class="fa fa-angle-right"></i>' : '<i class="fa fa-angle-left"></i>').esc_html__('Newest Post','lapindos').'</span></a>';
    }

    if( $next <= $args['max_num_pages'] ){
      $next_link = str_replace('%#%', $next , $base);
      $links[] = '<a class="older-post btn btn-lg'.($is_rtl ? " rtl":"").'" href="'.esc_url($next_link).'"><span>'.( $is_rtl ? '<i class="fa fa-angle-left"></i>' : '<i class="fa fa-angle-right"></i>').esc_html__('Older Post','lapindos').'</span></a>';
    }
  }

  if (count($links)): 
      $pagination_links= $args["before"].join($args["after"].$args["before"],is_rtl()? array_reverse($links) : $links).$args["after"];

      print !empty($args['wrapper']) ? sprintf( $args['wrapper'] , $type , $pagination_links) : 
      sprintf( "<div class=\"%s\">%s</div>" , $type , $pagination_links ); 
  endif;
}


function lapindos_post_class($classes=array(), $class="", $post_id=0){

  if(is_page()){
     $classes[]='content';

  }
  return $classes;
}

add_filter( 'post_class', 'lapindos_post_class');


function lapindos_body_class($classes=array()){

  if(lapindos_is_has_image()){
    $classes[]='image-bg';
  }

  $logo_position = lapindos_get_config('logo-position');

  if(!empty($logo_position)){
    $classes[]="logo-".$logo_position;
  }

  if(lapindos_get_config('slidingbar')){
    $slidingbar_position = lapindos_get_config('slidingbar-position','right');
    $classes[]="slide-bar-".$slidingbar_position;
  }

  $sidebar_position = lapindos_get_config('sidebar_position','left');
  $classes[]="sidebar-".$sidebar_position;

  return $classes;
}

add_filter( 'body_class', 'lapindos_body_class');


function lapindos_get_post_footer_page($page_id){

  $post_ID=get_the_ID();

  $originalpost = $GLOBALS['post'];

  if($post_ID==$page_id)
    return;


  $post = lapindos_get_wpml_post($page_id);
  if(!$post)  return;

  $GLOBALS['post']=$post;
  $post_footer_page=do_shortcode($post->post_content);
  $GLOBALS['post']=$originalpost;

  return $post_footer_page;
}

/*wpml page translation */

function lapindos_get_wpml_post($post_id){

  if(function_exists('pll_get_post_translations')){

    $post_ids = pll_get_post_translations($post_id);
    $current_lang = pll_current_language();

    $post_id = isset($post_ids[$current_lang]) ? $post_ids[$current_lang] : $post_id;
  }
  elseif(defined('ICL_LANGUAGE_CODE')){

    global $wpdb;

     $postid = $wpdb->get_var(
        $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=(SELECT trid FROM {$wpdb->prefix}icl_translations WHERE element_id='%d' LIMIT 1) AND element_id!='%d' AND language_code='%s'", $post_id,$post_id,ICL_LANGUAGE_CODE)
     );

    if($postid){
      $post_id = $postid;
    }
  }

  return get_post($post_id);
}


/**
 * Breadcrumb
 * http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ 
 * 
 */


function lapindos_breadcrumbs($args=array()){

  $args=wp_parse_args($args,array(
    'wrap' => '<ol class="breadcrumb">%s</ol>',
    'before'=>'',
    'after' => '',
    'format' => '<li%s>%s</li>',
    'delimiter'=>'',
    'current_class' => 'active',
    'home_text' => esc_html__('Home','lapindos'), 
    'home_link' => home_url('/')
   ));

   $breadcrumbs=lapindos_get_breadcrumbs($args);

    if (function_exists('is_shop') && (is_product()||is_cart()||is_checkout()||is_shop()||is_product_category())) {
      // do nothing
      // woocomerce has different breadcrumb method
    } else {
       print $args['before'];
       printf($args['wrap'],join($args['delimiter']."\n",is_rtl()?array_reverse($breadcrumbs):$breadcrumbs));
       print $args['after'];
    }
}

function lapindos_get_breadcrumbs($breadcrumb_args) {
  global $post;

   $breadcrumbs[]= sprintf($breadcrumb_args['format'],is_front_page()?' class="current"':'','<a href="'.esc_url($breadcrumb_args['home_link']).'" title="'.esc_attr($breadcrumb_args['home_text']).'">'.$breadcrumb_args['home_text'].'</a>');

  if (is_front_page()) {
    // do nothing
  } elseif (is_home()) { // blog page
      lapindos_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args);
 
  } elseif (is_singular()) {

        if (is_single()) {

          $post_type=get_post_type();

          if('post'==$post_type){
            lapindos_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args,false);
            array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
          }
          else{
            array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
          }

        } else {

            lapindos_get_breadcrumbs_from_menu($post->ID,$breadcrumbs,$breadcrumb_args);
            if (count($breadcrumbs) < 2 ) {
              array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
            }
        }
  } else {
      $post_id = -1;
        if(is_category()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",single_cat_title(' ',false));
        }
        elseif(is_archive()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",is_tag()||is_tax()?single_tag_title(' ',false):single_month_title( ' ', false ));
        }
        else{
          if (isset($post->ID)) {
            $post_id = $post->ID;
            lapindos_get_breadcrumbs_from_menu($post_id,$breadcrumbs,$breadcrumb_args);
          }
        }
  }

  return apply_filters('lapindos_breadcrumbs',$breadcrumbs,$breadcrumb_args);
}


function lapindos_get_breadcrumbs_from_menu($post_id,&$breadcrumbs,$args,$iscurrent=true) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    foreach ($navs as $nav) {
      if (($nav->object_id)==$post_id) {

        if ($nav->menu_item_parent!=0) {
          //start recursive by menu parent
          lapindos_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
        }

        if ($iscurrent) {
          array_push($breadcrumbs, sprintf($args['format']," class=\"".$args['current_class']."\"",$nav->title));
        } else {
          array_push($breadcrumbs, sprintf($args['format'],"", '<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>' ));
        }

        break;
      }
    } 
  }  
}

function lapindos_get_breadcrumbs_from_menu_by_menuid($menu_id,&$breadcrumbs,$args) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    foreach ($navs as $nav) {
      if (($nav->ID)==$menu_id) {

        if ($nav->menu_item_parent!=0) {
          //recursive by menu parent
          lapindos_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
        }
        array_push($breadcrumbs, sprintf($args['format'],"",'<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>'));

        break;
      }
    } 
  } 
}

/* end breadcrumbs */

function lapindos_flexivideo($html) {

  if (!is_admin() && !preg_match("/flex\-video/mi", $html)) {
    $html="<div class=\"flex-video widescreen\">".$html."</div>";
  }
  return $html;
}

add_filter('embed_handler_html', 'lapindos_flexivideo', 90); 
add_filter('oembed_dataparse', 'lapindos_flexivideo', 90);
add_filter('embed_oembed_html', 'lapindos_flexivideo', 90);


function lapindos_link_pages(){
  $args = array(
    'before'           => '<div class="page-pagination" dir="ltr">',
    'after'            => '</div>',
    'link_before'      => '<span class="page-numbers">',
    'link_after'       => '</span>',
    'next_or_number'   => 'number',
    'separator'        => ' ',
    'nextpagelink'     => esc_html__( 'Next page','lapindos' ),
    'previouspagelink' => esc_html__( 'Previous page','lapindos' ),
    'pagelink'         => '%',
    'echo'             => 1
  );

  return wp_link_pages($args);
}

function lapindos_check_update($transient){

    $purchase_number = lapindos_get_config( 'purchase_number','' );

    if ( empty( $transient->checked ) || empty($purchase_number) || ''== $purchase_number ) {
      return $transient;
    }

    $themename = get_template();
    $theme=wp_get_theme($themename);

    $options = array(
      'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
      'body' => array(
        'theme'      => $themename,
        'sn' => $purchase_number,
        'version'      => $theme->get('Version'),
      ),
      'user-agent' => 'WordPress;' . home_url('/')
    );

    $url = 'http://update.themegum.com/themes/update-check/';
    $raw_response = wp_remote_post( $url, $options );

    if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ){
      return $transient;
    }

    $response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

    if ( $response) {

      $transient->response[$themename] = $response;
    }
    return $transient;
}


add_filter( 'pre_set_site_transient_update_themes', 'lapindos_check_update');


function lapindos_safe_post_title($the_title){
  $title=esc_html( strip_tags( $the_title ));
  return $title;
}

add_filter( 'the_title', 'lapindos_safe_post_title');

function lapindos_get_mainmenu(){


  $toggle_menu ="<li class=\"mobile-menu-heading\"><span class=\"menu-title\">".esc_html__('menu','lapindos')."</span>".
  "<a class=\"toggle-mobile-menu\" href=\"#\" onclick=\"javascript:;\">
        <span class=\"close-bar\">
          <span></span>
          <span></span>
        </span>
      </a></li>";

  $toggle_menu="";

  $menuParams=array(
    'theme_location' => 'main_navigation',
    'echo' => false,
    'container_class'=>'',
    'container_id'=>'main-menu',
    'menu_class'=>'main-menu navbar-collapse collapse',
    'container'=>'',
    'before' => '',
    'after' => '',
    'fallback_cb'=>false,
    'walker'  => new mainmenu_walker(),
    'items_wrap' => '<ul id="%1$s" class="%2$s">'.$toggle_menu.'%3$s</ul>'
  );

  $custom_menu = lapindos_get_config( 'main_menu_id');

  if($custom_menu!=''){

    $menuParams['theme_location'] = '';
    $menuParams['menu'] = absint($custom_menu);
  }

  $menuParams =  apply_filters( 'lapindos_main_menu_params' , $menuParams);

  if($menu=wp_nav_menu($menuParams)){
      return $menu;
  }

  $menuParams['container'] = "ul";
  $menuParams['before'] = $toggle_menu;

  $menuParams['fallback_cb']="wp_page_menu";
  $menuParams['walker']= new mainmenu_page_walker();

  $menu=wp_nav_menu($menuParams);

  if(!$menu || is_wp_error($menu))
    return "";
  return $menu;
}

if(!function_exists('lapindos_darken')){
  function lapindos_darken($colourstr, $procent=0) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r - ($r*$procent/100)));
    $g = max(0,min(255,$g - ($g*$procent/100)));  
    $b = max(0,min(255,$b - ($b*$procent/100)));

    return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
  }
}

if(!function_exists('lapindos_lighten')){

    function lapindos_lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

if(!function_exists('lapindos_hex_to_rgb')){
  function lapindos_hex_to_rgb($colourstr) {
    $colourstr = str_replace('#','',$colourstr);
    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = max(0,min(255,$r));
    $g = max(0,min(255,$g));  
    $b = max(0,min(255,$b));

    return  array($r,$g,$b);
  }
}

/* Gris system */

function lapindos_change_grid_system($config=array()){

  $body_spacing = isset($config['body-spacing']) ? $config['body-spacing'] :  array() ;

  $padding_top = isset($body_spacing['padding-top']) ? $body_spacing['padding-top'] : '';
  $padding_left = isset($body_spacing['padding-left']) ? $body_spacing['padding-left'] : '';

  if($padding_top!='' || $padding_left!=''){?>
body{
<?php if($padding_top!=''){ 
$padding_top = absint($padding_top);
  print 'padding-top:'. $padding_top.'px;' ;
  print 'padding-bottom:'. $padding_top.'px;' ;
 }?>
<?php if($padding_left!=''){ 
$padding_left = absint($padding_left);
  print 'padding-left:'. $padding_left.'px;' ;
  print 'padding-right:'. $padding_left.'px;' ;
 }?>
}
<?php
  }


  $gutter_width = isset($config['gutter-width']) ? trim($config['gutter-width']) :  "";

  if($gutter_width!='' && $gutter_width!='30'):
    $gutter_width = floor($gutter_width / 2 );
?>

.row,
.mainmenu-bar-inner, .top-bar-inner, .middle-section-inner, .bottom-section-inner{
  margin-left: -<?php print $gutter_width;?>px;
  margin-right: -<?php print $gutter_width;?>px;  
}
.bottom-section-header .bottom-section-inner,
.container,
.container-fluid,
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
  padding-left: <?php print $gutter_width;?>px;
  padding-right: <?php print $gutter_width;?>px;
}
<?php 
  endif;

  $tablet_width = isset($config['screen-tablet']) ? trim($config['screen-tablet']) :  "";
  if($tablet_width!='' && $tablet_width!='768'):

    $tablet_width = absint($tablet_width);
?>
@media (min-width: <?php print $tablet_width;?>px) {
  .container {
    width: 100%;
  }

  .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
    float: left;
  }
  .col-sm-12 {
    width: 100%;
  }
  .col-sm-11 {
    width: 91.66666667%;
  }
  .col-sm-10 {
    width: 83.33333333%;
  }
  .col-sm-9 {
    width: 75%;
  }
  .col-sm-8 {
    width: 66.66666667%;
  }
  .col-sm-7 {
    width: 58.33333333%;
  }
  .col-sm-6 {
    width: 50%;
  }
  .col-sm-5 {
    width: 41.66666667%;
  }
  .col-sm-4 {
    width: 33.33333333%;
  }
  .col-sm-3 {
    width: 25%;
  }
  .col-sm-2 {
    width: 16.66666667%;
  }
  .col-sm-1 {
    width: 8.33333333%;
  }
  .col-sm-pull-12 {
    right: 100%;
  }
  .col-sm-pull-11 {
    right: 91.66666667%;
  }
  .col-sm-pull-10 {
    right: 83.33333333%;
  }
  .col-sm-pull-9 {
    right: 75%;
  }
  .col-sm-pull-8 {
    right: 66.66666667%;
  }
  .col-sm-pull-7 {
    right: 58.33333333%;
  }
  .col-sm-pull-6 {
    right: 50%;
  }
  .col-sm-pull-5 {
    right: 41.66666667%;
  }
  .col-sm-pull-4 {
    right: 33.33333333%;
  }
  .col-sm-pull-3 {
    right: 25%;
  }
  .col-sm-pull-2 {
    right: 16.66666667%;
  }
  .col-sm-pull-1 {
    right: 8.33333333%;
  }
  .col-sm-pull-0 {
    right: auto;
  }
  .col-sm-push-12 {
    left: 100%;
  }
  .col-sm-push-11 {
    left: 91.66666667%;
  }
  .col-sm-push-10 {
    left: 83.33333333%;
  }
  .col-sm-push-9 {
    left: 75%;
  }
  .col-sm-push-8 {
    left: 66.66666667%;
  }
  .col-sm-push-7 {
    left: 58.33333333%;
  }
  .col-sm-push-6 {
    left: 50%;
  }
  .col-sm-push-5 {
    left: 41.66666667%;
  }
  .col-sm-push-4 {
    left: 33.33333333%;
  }
  .col-sm-push-3 {
    left: 25%;
  }
  .col-sm-push-2 {
    left: 16.66666667%;
  }
  .col-sm-push-1 {
    left: 8.33333333%;
  }
  .col-sm-push-0 {
    left: auto;
  }
  .col-sm-offset-12 {
    margin-left: 100%;
  }
  .col-sm-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-sm-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-sm-offset-9 {
    margin-left: 75%;
  }
  .col-sm-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-sm-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-sm-offset-6 {
    margin-left: 50%;
  }
  .col-sm-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-sm-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-sm-offset-3 {
    margin-left: 25%;
  }
  .col-sm-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-sm-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-sm-offset-0 {
    margin-left: 0%;
  }

/* nuno grid */
  .tablet-grid-12 {
    width: 100%;
  }

  .tablet-grid-11 {
    width: 91.66666666666666%;
  }
  .tablet-grid-10 {
    width: 83.33333333333334%;
  }
  .tablet-grid-9 {
    width: 75%;
  }
  .tablet-grid-8 {
    width: 66.66666666666666%;
  }
  .tablet-grid-7 {
    width: 58.333333333333336%;
  }
  .tablet-grid-6 {
    width: 50%;
  }
  .tablet-grid-5 {
    width: 41.66666666666667%;
  }
  .tablet-grid-4 {
    width: 33.33333333333333%;
  }
  .tablet-grid-3 {
    width: 25%;
  }
  .tablet-grid-2 {
    width: 16.666666666666664%;
  }
  .tablet-grid-1 {
    width: 8.333333333333332%;
  }

  .tablet-grid-hide {
    display: none;
  }

}
<?php 
  endif;

  $desktop_width = isset($config['screen-desktop']) ? trim($config['screen-desktop']) :  "";
  if($desktop_width!='' && $desktop_width!='992'):

    $desktop_width = absint($desktop_width);
?>

@media (min-width: <?php print $desktop_width;?>px) {
  .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
    float: left;
  }
  .col-md-12 {
    width: 100%;
  }
  .col-md-11 {
    width: 91.66666667%;
  }
  .col-md-10 {
    width: 83.33333333%;
  }
  .col-md-9 {
    width: 75%;
  }
  .col-md-8 {
    width: 66.66666667%;
  }
  .col-md-7 {
    width: 58.33333333%;
  }
  .col-md-6 {
    width: 50%;
  }
  .col-md-5 {
    width: 41.66666667%;
  }
  .col-md-4 {
    width: 33.33333333%;
  }
  .col-md-3 {
    width: 25%;
  }
  .col-md-2 {
    width: 16.66666667%;
  }
  .col-md-1 {
    width: 8.33333333%;
  }
  .col-md-pull-12 {
    right: 100%;
  }
  .col-md-pull-11 {
    right: 91.66666667%;
  }
  .col-md-pull-10 {
    right: 83.33333333%;
  }
  .col-md-pull-9 {
    right: 75%;
  }
  .col-md-pull-8 {
    right: 66.66666667%;
  }
  .col-md-pull-7 {
    right: 58.33333333%;
  }
  .col-md-pull-6 {
    right: 50%;
  }
  .col-md-pull-5 {
    right: 41.66666667%;
  }
  .col-md-pull-4 {
    right: 33.33333333%;
  }
  .col-md-pull-3 {
    right: 25%;
  }
  .col-md-pull-2 {
    right: 16.66666667%;
  }
  .col-md-pull-1 {
    right: 8.33333333%;
  }
  .col-md-pull-0 {
    right: auto;
  }
  .col-md-push-12 {
    left: 100%;
  }
  .col-md-push-11 {
    left: 91.66666667%;
  }
  .col-md-push-10 {
    left: 83.33333333%;
  }
  .col-md-push-9 {
    left: 75%;
  }
  .col-md-push-8 {
    left: 66.66666667%;
  }
  .col-md-push-7 {
    left: 58.33333333%;
  }
  .col-md-push-6 {
    left: 50%;
  }
  .col-md-push-5 {
    left: 41.66666667%;
  }
  .col-md-push-4 {
    left: 33.33333333%;
  }
  .col-md-push-3 {
    left: 25%;
  }
  .col-md-push-2 {
    left: 16.66666667%;
  }
  .col-md-push-1 {
    left: 8.33333333%;
  }
  .col-md-push-0 {
    left: auto;
  }
  .col-md-offset-12 {
    margin-left: 100%;
  }
  .col-md-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-md-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-md-offset-9 {
    margin-left: 75%;
  }
  .col-md-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-md-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-md-offset-6 {
    margin-left: 50%;
  }
  .col-md-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-md-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-md-offset-3 {
    margin-left: 25%;
  }
  .col-md-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-md-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-md-offset-0 {
    margin-left: 0%;
  }
  
/* nuno grid */
  .tablet-wide-grid-12 {
    width: 100%;
  }

  .tablet-wide-grid-11 {
    width: 91.66666666666666%;
  }
  .tablet-wide-grid-10 {
    width: 83.33333333333334%;
  }
  .tablet-wide-grid-9 {
    width: 75%;
  }
  .tablet-wide-grid-8 {
    width: 66.66666666666666%;
  }
  .tablet-wide-grid-7 {
    width: 58.333333333333336%;
  }
  .tablet-wide-grid-6 {
    width: 50%;
  }
  .tablet-wide-grid-5 {
    width: 41.66666666666667%;
  }
  .tablet-wide-grid-4 {
    width: 33.33333333333333%;
  }
  .tablet-wide-grid-3 {
    width: 25%;
  }
  .tablet-wide-grid-2 {
    width: 16.666666666666664%;
  }
  .tablet-wide-grid-1 {
    width: 8.333333333333332%;
  }

  .tablet-wide-grid-hide {
    display: none;
  }

}
<?php 
  endif;

  $desktop_lg_width = isset($config['screen-lg-desktop']) ? trim($config['screen-lg-desktop']) :  "";
  if($desktop_lg_width!='' && $desktop_lg_width!='1200'):

    $desktop_lg_width = absint($desktop_lg_width);
?>
@media (min-width: <?php print $desktop_lg_width;?>px) {
  .wl_container{
    width: <?php print ($desktop_lg_width - 30);?>px;
  }
  .container{
    max-width: <?php print ($desktop_lg_width - 30);?>px;
  }

  .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
    float: left;
  }
  .col-lg-12 {
    width: 100%;
  }
  .col-lg-11 {
    width: 91.66666667%;
  }
  .col-lg-10 {
    width: 83.33333333%;
  }
  .col-lg-9 {
    width: 75%;
  }
  .col-lg-8 {
    width: 66.66666667%;
  }
  .col-lg-7 {
    width: 58.33333333%;
  }
  .col-lg-6 {
    width: 50%;
  }
  .col-lg-5 {
    width: 41.66666667%;
  }
  .col-lg-4 {
    width: 33.33333333%;
  }
  .col-lg-3 {
    width: 25%;
  }
  .col-lg-2 {
    width: 16.66666667%;
  }
  .col-lg-1 {
    width: 8.33333333%;
  }
  .col-lg-pull-12 {
    right: 100%;
  }
  .col-lg-pull-11 {
    right: 91.66666667%;
  }
  .col-lg-pull-10 {
    right: 83.33333333%;
  }
  .col-lg-pull-9 {
    right: 75%;
  }
  .col-lg-pull-8 {
    right: 66.66666667%;
  }
  .col-lg-pull-7 {
    right: 58.33333333%;
  }
  .col-lg-pull-6 {
    right: 50%;
  }
  .col-lg-pull-5 {
    right: 41.66666667%;
  }
  .col-lg-pull-4 {
    right: 33.33333333%;
  }
  .col-lg-pull-3 {
    right: 25%;
  }
  .col-lg-pull-2 {
    right: 16.66666667%;
  }
  .col-lg-pull-1 {
    right: 8.33333333%;
  }
  .col-lg-pull-0 {
    right: auto;
  }
  .col-lg-push-12 {
    left: 100%;
  }
  .col-lg-push-11 {
    left: 91.66666667%;
  }
  .col-lg-push-10 {
    left: 83.33333333%;
  }
  .col-lg-push-9 {
    left: 75%;
  }
  .col-lg-push-8 {
    left: 66.66666667%;
  }
  .col-lg-push-7 {
    left: 58.33333333%;
  }
  .col-lg-push-6 {
    left: 50%;
  }
  .col-lg-push-5 {
    left: 41.66666667%;
  }
  .col-lg-push-4 {
    left: 33.33333333%;
  }
  .col-lg-push-3 {
    left: 25%;
  }
  .col-lg-push-2 {
    left: 16.66666667%;
  }
  .col-lg-push-1 {
    left: 8.33333333%;
  }
  .col-lg-push-0 {
    left: auto;
  }
  .col-lg-offset-12 {
    margin-left: 100%;
  }
  .col-lg-offset-11 {
    margin-left: 91.66666667%;
  }
  .col-lg-offset-10 {
    margin-left: 83.33333333%;
  }
  .col-lg-offset-9 {
    margin-left: 75%;
  }
  .col-lg-offset-8 {
    margin-left: 66.66666667%;
  }
  .col-lg-offset-7 {
    margin-left: 58.33333333%;
  }
  .col-lg-offset-6 {
    margin-left: 50%;
  }
  .col-lg-offset-5 {
    margin-left: 41.66666667%;
  }
  .col-lg-offset-4 {
    margin-left: 33.33333333%;
  }
  .col-lg-offset-3 {
    margin-left: 25%;
  }
  .col-lg-offset-2 {
    margin-left: 16.66666667%;
  }
  .col-lg-offset-1 {
    margin-left: 8.33333333%;
  }
  .col-lg-offset-0 {
    margin-left: 0%;
  }
/* nuno grid */

  .notebook-grid-12 {
    width: 100%;
  }

  .notebook-grid-11 {
    width: 91.66666666666666%;
  }
  .notebook-grid-10 {
    width: 83.33333333333334%;
  }
  .notebook-grid-9 {
    width: 75%;
  }
  .notebook-grid-8 {
    width: 66.66666666666666%;
  }
  .notebook-grid-7 {
    width: 58.333333333333336%;
  }
  .notebook-grid-6 {
    width: 50%;
  }
  .notebook-grid-5 {
    width: 41.66666666666667%;
  }
  .notebook-grid-4 {
    width: 33.33333333333333%;
  }
  .notebook-grid-3 {
    width: 25%;
  }
  .notebook-grid-2 {
    width: 16.666666666666664%;
  }
  .notebook-grid-1 {
    width: 8.333333333333332%;
  }

  .notebook-grid-hide {
    display: none;
  }
}
<?php 
    endif; // desktop_width
}

add_action( 'lapindos_change_style', 'lapindos_change_grid_system');


/* body text color */
function lapindos_change_text_color($config=array()){

  $color= isset($config['textcolor']) ? trim($config['textcolor']) :  "";

  if(empty($color) || '#4f4f4f'== strtolower($color)) return;
  ?>
body,
.text-color,
.page-pagination .page-numbers,
.widget.widget_categories > ul > li > a,
.btn-default .badge,
a.btn-default .badge,
.btn.btn-default:hover,
.el-btn a.btn.btn-default:hover,
.el-btn button.btn.btn-default:hover,
a.btn.btn-default:hover,
.btn.btn-skin-default:hover,
.el-btn a.btn.btn-skin-default:hover,
.el-btn button.btn.btn-skin-default:hover,
a.btn.btn-skin-default:hover,
.btn.btn-default:focus,
.el-btn a.btn.btn-default:focus,
.el-btn button.btn.btn-default:focus,
a.btn.btn-default:focus,
.btn.btn-skin-default:focus,
.el-btn a.btn.btn-skin-default:focus,
.el-btn button.btn.btn-skin-default:focus,
a.btn.btn-skin-default:focus,
.btn.btn-default-outline,
.el-btn a.btn.btn-default-outline,
.el-btn button.btn.btn-default-outline,
a.btn.btn-default-outline,
.btn.btn-skin-default-ghost,
.el-btn a.btn.btn-skin-default-ghost,
.el-btn button.btn.btn-skin-default-ghost,
a.btn.btn-skin-default-ghost,
.btn.btn-primary:hover,
.el-btn a.btn.btn-primary:hover,
.el-btn button.btn.btn-primary:hover,
a.btn.btn-primary:hover,
.btn.btn-skin-primary:hover,
.el-btn a.btn.btn-skin-primary:hover,
.el-btn button.btn.btn-skin-primary:hover,
a.btn.btn-skin-primary:hover,
.btn.btn-primary:focus,
.el-btn a.btn.btn-primary:focus,
.el-btn button.btn.btn-primary:focus,
a.btn.btn-primary:focus,
.btn.btn-skin-primary:focus,
.el-btn a.btn.btn-skin-primary:focus,
.el-btn button.btn.btn-skin-primary:focus,
a.btn.btn-skin-primary:focus,
.btn.btn-primary-thirdy:hover,
.el-btn a.btn.btn-primary-thirdy:hover,
.el-btn button.btn.btn-primary-thirdy:hover,
a.btn.btn-primary-thirdy:hover,
.btn.btn-skin-primary-thirdy:hover,
.el-btn a.btn.btn-skin-primary-thirdy:hover,
.el-btn button.btn.btn-skin-primary-thirdy:hover,
a.btn.btn-skin-primary-thirdy:hover,
.btn.btn-primary-thirdy:focus,
.el-btn a.btn.btn-primary-thirdy:focus,
.el-btn button.btn.btn-primary-thirdy:focus,
a.btn.btn-primary-thirdy:focus,
.btn.btn-skin-primary-thirdy:focus,
.el-btn a.btn.btn-skin-primary-thirdy:focus,
.el-btn button.btn.btn-skin-primary-thirdy:focus,
a.btn.btn-skin-primary-thirdy:focus,
.btn.btn-secondary,
.el-btn a.btn.btn-secondary,
.el-btn button.btn.btn-secondary,
a.btn.btn-secondary,
.btn.btn-skin-secondary,
.el-btn a.btn.btn-skin-secondary,
.el-btn button.btn.btn-skin-secondary,
a.btn.btn-skin-secondary,
.btn.btn-secondary-thirdy,
.el-btn a.btn.btn-secondary-thirdy,
.el-btn button.btn.btn-secondary-thirdy,
a.btn.btn-secondary-thirdy,
.btn.btn-skin-secondary-thirdy,
.el-btn a.btn.btn-skin-secondary-thirdy,
.el-btn button.btn.btn-skin-secondary-thirdy,
a.btn.btn-skin-secondary-thirdy,
.btn.btn-thirdy-ghost:hover,
.el-btn a.btn.btn-thirdy-ghost:hover,
.el-btn button.btn.btn-thirdy-ghost:hover,
a.btn.btn-thirdy-ghost:hover,
.btn.btn-skin-thirdy-ghost:hover,
.el-btn a.btn.btn-skin-thirdy-ghost:hover,
.el-btn button.btn.btn-skin-thirdy-ghost:hover,
a.btn.btn-skin-thirdy-ghost:hover,
.btn.btn-thirdy-ghost:focus,
.el-btn a.btn.btn-thirdy-ghost:focus,
.el-btn button.btn.btn-thirdy-ghost:focus,
a.btn.btn-thirdy-ghost:focus,
.btn.btn-skin-thirdy-ghost:focus,
.el-btn a.btn.btn-skin-thirdy-ghost:focus,
.el-btn button.btn.btn-skin-thirdy-ghost:focus,
a.btn.btn-skin-thirdy-ghost:focus,
.wp-caption-text a,
.single-tg_custom_post .portfolio-meta-info .meta,
.single-superclean_service .portfolio-meta-info .meta,
.single-tg_custom_post .portfolio-meta-info .meta a,
.single-superclean_service .portfolio-meta-info .meta a,
.el_progress_bar .progress-bar-outer .progress-bar-value,
.el_progress_bar .progress-bar-outer .progress-bar-unit,
.gum_portfolio .portfolio-filter li,
.gum_portfolio .portfolio-filter li a
{
  color: <?php print sanitize_hex_color($color);?>;
}


.comment-respond .comment-form input::-moz-placeholder,
.comment-respond .comment-form textarea::-moz-placeholder,
.comment-respond .comment-form .button::-moz-placeholder,
.comment-respond .comment-form input:-ms-input-placeholder,
.comment-respond .comment-form textarea:-ms-input-placeholder,
.comment-respond .comment-form .button:-ms-input-placeholder,
.comment-respond .comment-form input::-webkit-input-placeholder,
.comment-respond .comment-form textarea::-webkit-input-placeholder,
.comment-respond .comment-form .button::-webkit-input-placeholder,
.social-icons .search-form .search-field::-moz-placeholder,
.social-icons .search-form .search-field:-ms-input-placeholder,
.social-icons .search-form .search-field::-webkit-input-placeholder {
  color: <?php print sanitize_hex_color($color);?>;
}

.btn.btn-default,
.el-btn a.btn.btn-default,
.el-btn button.btn.btn-default,
a.btn.btn-default,
.btn.btn-skin-default,
.el-btn a.btn.btn-skin-default,
.el-btn button.btn.btn-skin-default,
a.btn.btn-skin-default,
.btn.btn-default-outline:hover,
.el-btn a.btn.btn-default-outline:hover,
.el-btn button.btn.btn-default-outline:hover,
a.btn.btn-default-outline:hover,
.btn.btn-skin-default-ghost:hover,
.el-btn a.btn.btn-skin-default-ghost:hover,
.el-btn button.btn.btn-skin-default-ghost:hover,
a.btn.btn-skin-default-ghost:hover,
.btn.btn-default-outline:focus,
.el-btn a.btn.btn-default-outline:focus,
.el-btn button.btn.btn-default-outline:focus,
a.btn.btn-default-outline:focus,
.btn.btn-skin-default-ghost:focus,
.el-btn a.btn.btn-skin-default-ghost:focus,
.el-btn button.btn.btn-skin-default-ghost:focus,
a.btn.btn-skin-default-ghost:focus,
.background-text,
.close-bar span,
.pagination li .older-post:hover,
.pagination li .newest-post:hover,
.pagination li .older-post:focus,
.pagination li .newest-post:focus{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.btn.btn-default,
.el-btn a.btn.btn-default,
.el-btn button.btn.btn-default,
a.btn.btn-default,
.btn.btn-skin-default,
.el-btn a.btn.btn-skin-default,
.el-btn button.btn.btn-skin-default,
a.btn.btn-skin-default,
.btn.btn-default-outline,
.el-btn a.btn.btn-default-outline,
.el-btn button.btn.btn-default-outline,
a.btn.btn-default-outline,
.btn.btn-skin-default-ghost,
.el-btn a.btn.btn-skin-default-ghost,
.el-btn button.btn.btn-skin-default-ghost,
a.btn.btn-skin-default-ghost,
.btn.btn-default-outline:hover,
.el-btn a.btn.btn-default-outline:hover,
.el-btn button.btn.btn-default-outline:hover,
a.btn.btn-default-outline:hover,
.btn.btn-skin-default-ghost:hover,
.el-btn a.btn.btn-skin-default-ghost:hover,
.el-btn button.btn.btn-skin-default-ghost:hover,
a.btn.btn-skin-default-ghost:hover,
.btn.btn-default-outline:focus,
.el-btn a.btn.btn-default-outline:focus,
.el-btn button.btn.btn-default-outline:focus,
a.btn.btn-default-outline:focus,
.btn.btn-skin-default-ghost:focus,
.el-btn a.btn.btn-skin-default-ghost:focus,
.el-btn button.btn.btn-skin-default-ghost:focus,
a.btn.btn-skin-default-ghost:focus,
.border-text,
.close-bar{
  border-color: <?php print sanitize_hex_color($color);?>;
}

blockquote{
  color: <?php print lapindos_lighten($color,27.5);?>;
}

<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_text_color');


/* top section header */
function lapindos_change_topbar_color($config=array()){

  $color= isset($config['topbar-bgcolor']) ? $config['topbar-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#041e42' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.top-heading .top-bar,
.top-bar,
.top-bar .top-bar-module .module-menu .sub-menu-container
{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['topbar-inner-bgcolor']) ? $config['topbar-inner-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#000000' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='0')){?>
.top-bar .module-menu .sub-menu-container,
.top-bar .top-bar-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['topbar-color']) ? $config['topbar-color'] : "";


  if(!empty($color) && strtolower($color) !=='#ffffff' ){?>
.top-bar,
.top-bar a,
.top-bar .module-menu .menu-item,
.top-bar .module-menu .menu-item > a,
.top-bar .module-menu > .menu-item > a,
.top-bar .icon-graphic > li .info-title,
.top-bar .icon-graphic > li .info-label
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color= isset($config['topbar-border-color']) ? $config['topbar-border-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";


  if(!empty($bgcolor['color']) ){?>
.top-bar .top-bar-inner
{
  border-bottom: solid 1px <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $spacing= isset($config['topbar-section-spacing']) ? $config['topbar-section-spacing'] :  array();


  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .top-bar .top-bar-inner{
  <?php   if($padding_top!='' && 5 != $padding_top ) {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' && 5 != $padding_bottom ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php
  $height= isset($config['topbar-height']) ? trim($config['topbar-height']) :  "";

  if($height!='' && 35 != absint($height) ) {
  ?>
  .top-bar .top-bar-inner{
        min-height: <?php print absint($height);?>px;
  }
<?php
  }

  $radius= isset($config['topbar-radius']) ? trim($config['topbar-radius']) :  "";

  if($radius!='' && 0 != absint($radius) ) {
  ?>
  .top-bar .top-bar-inner{
        border-radius: <?php print absint($radius);?>px;
  }
<?php
  }


}

add_action( 'lapindos_change_style', 'lapindos_change_topbar_color');


/* middle section color */
function lapindos_change_middle_section_color($config=array()){

  $color= isset($config['iconbar-background-color']) ? $config['iconbar-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.top-heading .middle-section-header,
.middle-section-header{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['iconbar-inner-background-color']) ? $config['iconbar-inner-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#000000' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='0')  ){?>
.middle-section-header .module-menu .sub-menu-container,
.middle-section-header .middle-section-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}


  $color= isset($config['iconbar-color']) ? trim($config['iconbar-color']) :  "";

  if(!empty($color) && '#2e96db' != strtolower($color)) {
  ?>

.middle-section-header,
.middle-section-header a,
.middle-section-header .logo-text,
.middle-section-header .logo-text a,
.middle-section-header .module-menu .menu-item,
.middle-section-header .module-menu .menu-item > a,
.middle-section-header .module-menu > .menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $height= isset($config['middle-section-height']) ? trim($config['middle-section-height']) :  "";

  if($height!='' && 40 != absint($height) ) {
  ?>
  .middle-section-header .middle-section-inner{
        min-height: <?php print absint($height);?>px;
  }
<?php
  }

  $spacing= isset($config['middle-section-spacing']) ? $config['middle-section-spacing'] :  array();

  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .middle-section-header .middle-section-inner{
  <?php   if($padding_top!='' && 20 != $padding_top ) {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' && 20 != $padding_bottom ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php

  $radius= isset($config['middle-section-radius']) ? trim($config['middle-section-radius']) :  "";

  if($radius!='' && 0 != absint($radius) ) {
  ?>
  .middle-section-header .middle-section-inner{
        border-radius: <?php print absint($radius);?>px;
  }
<?php
  }

}

add_action( 'lapindos_change_style', 'lapindos_change_middle_section_color');


/* bottom section header */

function lapindos_change_bottom_section_color($config=array()){

  $shape_height = isset($config['height']) ? $config['height'] : '';

  if($shape_height!=''){

    $shape_height = absint($shape_height);
    $height_wave = isset( $config['height_wave'] ) ? $config['height_wave'] : 50;

    $shape_height_sticky = absint($shape_height) * ( $height_wave / 100 );


    print '.top-heading .top-heading-shape{height: '.absint($shape_height).'px;}';
    print '.mainmenu-bar .top-heading-shape{height: '.absint($shape_height_sticky).'px;}';

  }


  $color= isset($config['navbar-outer-bgcolor']) ? $config['navbar-outer-bgcolor'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.bottom-section-header{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color= isset($config['navbar-inner-background-color']) ? $config['navbar-inner-background-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));


  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.bottom-section-header .bottom-section-inner{
  background-color: <?php print $bgcolor_rgba;?> !important;
}
<?php
}

  $color = isset($config['navbar-color']) ? trim($config['navbar-color']) :  "";

  if(!empty($color) && '#222222' != strtolower($color)) {
  ?>
.bottom-section-header,
.bottom-section-header a,
.bottom-section-header .logo-text,
.bottom-section-header .logo-text a,
.bottom-section-header .heading-module .icon-graphic > li .info-title,
.bottom-section-header .heading-module .icon-graphic > li .info-label,
.bottom-section-header .icon-graphic > li > a, .bottom-section-header .icon-graphic > li > i,
.bottom-section-header .module-menu .menu-item,
.bottom-section-header .module-menu .menu-item > a,
.bottom-section-header .module-menu > .menu-item > a
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $height= isset($config['bottom-section-height']) ? trim($config['bottom-section-height']) :  "";

  if($height!='' && 40 != absint($height) ) {
  ?>
  .bottom-section-header .bottom-section-inner{
        min-height: <?php print absint($height);?>px;
  }
<?php
  }

  $spacing= isset($config['bottom-section-spacing']) ? $config['bottom-section-spacing'] :  array();

  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .bottom-section-header .bottom-section-inner{
  <?php   if($padding_top!='' && 0 != $padding_top ) {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' && 0 != $padding_bottom ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php


  $color= isset($config['bottom-border-color']) ? $config['bottom-border-color'] : array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";


  if(!empty($bgcolor['color']) && ('#333333' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.bottom-section-header .bottom-section-inner
{
  border-top: solid 1px <?php print $bgcolor_rgba;?>;
}
<?php
  }


  $radius= isset($config['bottom-section-radius']) ? trim($config['bottom-section-radius']) :  "";

  if($radius!='' && 0 != absint($radius) ) {
  ?>
  .bottom-section-header .bottom-section-inner{
        border-radius: <?php print absint($radius);?>px;
  }
<?php
  }

}

add_action( 'lapindos_change_style', 'lapindos_change_bottom_section_color');

/*
 * change icons color
 */

function lapindos_change_infoicons_color($config=array()){


  $icongraphic_sticky_style = isset($config['sticky_icongraphic_skin']) ? (bool)$config['sticky_icongraphic_skin'] : false;
  $iconflat_sticky_style = isset($config['sticky_iconflat_skin']) ? (bool)$config['sticky_iconflat_skin'] : false;

  $color = isset($config['menu_icon_color']) ? trim($config['menu_icon_color']) :  "";

  if(!empty($color) && '#2e96db' != strtolower($color)) {
  ?>
.icon-graphic > li > a,
.icon-graphic > li > i,
.bottom-section-header  .heading-module .icon-graphic > li > a{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color = isset($config['menu_icon_label_color']) ? trim($config['menu_icon_label_color']) :  "";

  if(!empty($color) && '#2e96db' != strtolower($color)) {
  ?>
.icon-graphic > li .info-title,
.bottom-section-header .heading-module .icon-graphic > li .info-title{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $color = isset($config['menu_icon_value_color']) ? trim($config['menu_icon_value_color']) :  "";

  if(!empty($color) && '#747578' != strtolower($color)) {
  ?>
.icon-graphic > li .info-label,
.bottom-section-header .heading-module .icon-graphic > li .info-label{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  if($icongraphic_sticky_style){

      $icon_color = isset($config['icongraphic_sticky_color']) ? trim($config['icongraphic_sticky_color']) :  "";
      $label_color = isset($config['icongraphic_sticky_label_color']) ? trim($config['icongraphic_sticky_label_color']) :  "";
      $value_color = isset($config['icongraphic_sticky_value_color']) ? trim($config['icongraphic_sticky_value_color']) :  "";


      if($icon_color!='') {
      ?>
    .mainmenu-bar .icon-graphic > li > a,
    .mainmenu-bar .icon-graphic > li > i{
      color: <?php print sanitize_hex_color($icon_color);?>;
    }
    <?php
      }


  if($label_color!='') {
  ?>
    .mainmenu-bar .icon-graphic > li .info-title{
      color: <?php print sanitize_hex_color($label_color);?>;
    }
<?php
  }

 if($value_color!='') {
  ?>
.mainmenu-bar .icon-graphic > li .info-label{
  color: <?php print sanitize_hex_color($value_color);?>;
}
<?php
  }


  }

// flat icon //

  $color = isset($config['menu_iconflat_color']) ? trim($config['menu_iconflat_color']) :  "";

  if(!empty($color) && '#fde428' != strtolower($color)) {
  ?>
.iconflat-graphic > li > i, .iconflat-graphic > li > a{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }


  $color = isset($config['menu_iconflat_label_color']) ? trim($config['menu_iconflat_label_color']) :  "";

  if(!empty($color) && '#ffffff' != strtolower($color)) {
  ?>
.iconflat-graphic > li .info-title{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

 $color = isset($config['menu_iconflat_value_color']) ? trim($config['menu_iconflat_value_color']) :  "";

  if(!empty($color) && '#ffffff' != strtolower($color)) {
  ?>
.iconflat-graphic > li .info-label{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  if($iconflat_sticky_style){

      $icon_color = isset($config['iconflat_sticky_color']) ? trim($config['iconflat_sticky_color']) :  "";
      $label_color = isset($config['iconflat_sticky_label_color']) ? trim($config['iconflat_sticky_label_color']) :  "";
      $value_color = isset($config['iconflat_sticky_value_color']) ? trim($config['iconflat_sticky_value_color']) :  "";


  if($icon_color!='') {
  ?>
.mainmenu-bar .iconflat-graphic > li > i, .mainmenu-bar .iconflat-graphic > li > a{
  color: <?php print sanitize_hex_color($icon_color);?>;
}
<?php
  }

 if($label_color!='') {
  ?>
.mainmenu-bar .iconflat-graphic > li .info-title{
  color: <?php print sanitize_hex_color($label_color);?>;
}
<?php
  }

  if($value_color!='') {
  ?>
.mainmenu-bar .iconflat-graphic > li .info-label{
  color: <?php print sanitize_hex_color($value_color);?>;
}
<?php
  }


  }


}


add_action( 'lapindos_change_style', 'lapindos_change_infoicons_color');

/*
 * change button link color
 */

function lapindos_change_button_link_styles($config=array()){


  $color = isset($config['quote_menu_color']) ? $config['quote_menu_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));

  $bg_color = isset($config['quote_menu_bg_color']) ? $config['quote_menu_bg_color'] : array();
  $bg_color = wp_parse_args($bg_color,array('regular'=>'','hover'=>''));


  $border_color = isset($config['quote_menu_border_color']) ? $config['quote_menu_border_color'] : array();
  $border_color = wp_parse_args($border_color,array('regular'=>'','hover'=>''));

  $sticky_style = isset($config['sticky_menu_skin']) ? (bool)$config['sticky_menu_skin'] : false;

  $sticky_color = isset($config['quote_menu_sticky_color']) ? $config['quote_menu_sticky_color'] : array();
  $sticky_color = wp_parse_args($sticky_color,array('regular'=>'','hover'=>''));

  $sticky_bg_color = isset($config['quote_menu_sticky_bg_color']) ? $config['quote_menu_sticky_bg_color'] : array();
  $sticky_bg_color = wp_parse_args($sticky_bg_color,array('regular'=>'','hover'=>''));

  $sticky_border_color = isset($config['quote_menu_sticky_border_color']) ? $config['quote_menu_sticky_border_color'] : array();
  $sticky_border_color = wp_parse_args($sticky_border_color,array('regular'=>'','hover'=>''));


  $button_styles = $button_hover_styles = $sticky_button_styles = $sticky_button_hover_styles = array();


  $radius= isset($config['button-radius']) ? trim($config['button-radius']) :  "";

  if($radius!='' && 0 != absint($radius) ) {
    $button_styles['border-radius'] = 'border-radius:'.absint($radius).'px';
    $sticky_button_styles['border-radius'] = 'border-radius:'.absint($radius).'px';
  }

  if(isset($color['regular']) && !empty($color['regular'])) {
     $button_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
    $button_hover_styles['color'] = 'color:'.sanitize_hex_color($color['hover']).'!important';
  }


  if(isset($bg_color['regular']) && !empty($bg_color['regular'])) {
    $button_styles['background-color'] = 'background-color:'.sanitize_hex_color($bg_color['regular']);
  }


  if(isset($bg_color['hover']) && !empty($bg_color['hover'])) {
    $button_hover_styles['background-color'] = 'background-color:'.sanitize_hex_color($bg_color['hover']).'!important';
  }


  if(isset($border_color['regular']) && !empty($border_color['regular'])) {
    $button_styles['border-color'] = 'border-color:'.sanitize_hex_color($border_color['regular']);
  }


  if(isset($border_color['hover']) && !empty($border_color['hover'])) {
    $button_hover_styles['border-color'] = 'border-color:'.sanitize_hex_color($border_color['hover']).'!important';
  }

  if(count($button_styles)) {
?>
.top-heading .quote-menu .quote-btn,
.mainmenu-bar .quote-menu .quote-btn{ <?php print join(';', $button_styles); ?>}
<?php
  }

 if(count($button_hover_styles)) {
?>
.top-heading .quote-menu .quote-btn:hover,
.top-heading .quote-menu .quote-btn:focus,
.mainmenu-bar .quote-menu .quote-btn:hover,
.mainmenu-bar .quote-menu .quote-btn:focus{ <?php print join(';', $button_hover_styles); ?>}
<?php
  }

  if(isset($sticky_color['regular']) && !empty($sticky_color['regular'])) {
     $sticky_button_styles['color'] = 'color:'.sanitize_hex_color($sticky_color['regular']);
  }

  if(isset($sticky_color['hover']) && !empty($sticky_color['hover'])) {
    $sticky_button_hover_styles['color'] = 'color:'.sanitize_hex_color($sticky_color['hover']).'!important';
  }


  if(isset($sticky_bg_color['regular']) && !empty($sticky_bg_color['regular'])) {
    $sticky_button_styles['background-color'] = 'background-color:'.sanitize_hex_color($sticky_bg_color['regular']);
  }


  if(isset($sticky_bg_color['hover']) && !empty($sticky_bg_color['hover'])) {
    $sticky_button_hover_styles['background-color'] = 'background-color:'.sanitize_hex_color($sticky_bg_color['hover']).'!important';
  }


  if(isset($sticky_border_color['regular']) && !empty($sticky_border_color['regular'])) {
    $sticky_button_styles['border-color'] = 'border-color:'.sanitize_hex_color($sticky_border_color['regular']);
  }


  if(isset($sticky_border_color['hover']) && !empty($sticky_border_color['hover'])) {
    $sticky_button_hover_styles['border-color'] = 'border-color:'.sanitize_hex_color($sticky_border_color['hover']).'!important';
  }

  if($sticky_style && count($sticky_button_styles)) {
?>
.mainmenu-bar .mainmenu-bar-inner .quote-menu .quote-btn{ <?php print join(';', $sticky_button_styles); ?>}
<?php
  }

 if($sticky_style && count($sticky_button_hover_styles)) {
?>
.mainmenu-bar .mainmenu-bar-inner .quote-menu .quote-btn:hover,
.mainmenu-bar .mainmenu-bar-inner .quote-menu .quote-btn:focus{ <?php print join(';', $sticky_button_hover_styles); ?>}
<?php
  }



}


add_action( 'lapindos_change_style', 'lapindos_change_button_link_styles');

/*
 * change social link color
 */

function lapindos_change_social_link_color($config=array()){


  $color = isset($config['social_color']) ? $config['social_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));


  $bg_color = isset($config['social_bg_color']) ? $config['social_bg_color'] : array();
  $bg_color = wp_parse_args($bg_color,array('regular'=>'','hover'=>''));


  $sticky_color = isset($config['social_sticky_color']) ? $config['social_sticky_color'] : array();
  $sticky_color = wp_parse_args($sticky_color,array('regular'=>'','hover'=>''));

  $sticky_bg_color = isset($config['social_sticky_bg_color']) ? $config['social_sticky_bg_color'] : array();
  $sticky_bg_color = wp_parse_args($sticky_bg_color,array('regular'=>'','hover'=>''));


  $sticky_style = isset($config['sticky_social_skin']) ? (bool)$config['sticky_social_skin'] : false;

  $social_styles = $social_hover_styles = $sticky_social_styles = $sticky_social_hover_styles = array();


 if(isset($color['regular']) && !empty($color['regular'])) {
    $social_styles['color'] = 'color: '.sanitize_hex_color($color['regular']);
  }

  if(isset($color['hover']) && !empty($color['hover'])) {
     $social_hover_styles['color'] = 'color: '.sanitize_hex_color($color['hover']);
  }


  if(isset($bg_color['regular']) && !empty($bg_color['regular'])) {
    $social_styles['background-color'] = 'background-color: '.sanitize_hex_color($bg_color['regular']);
  }


  if(isset($bg_color['hover']) && !empty($bg_color['hover'])) {
    $social_hover_styles['background-color'] = 'background-color: '.sanitize_hex_color($bg_color['hover']);

  }

  if(count($social_styles)) {
?>
.top-heading .module-social-icon .social-item,
.mainmenu-bar .module-social-icon .social-item{ <?php print join(';', $social_styles); ?>}
<?php
  }

 if(count($social_hover_styles)) {
?>
.top-heading .module-social-icon .social-item:hover,
.top-heading .module-social-icon .social-item:focus,
.mainmenu-bar .module-social-icon .social-item:hover,
.mainmenu-bar .module-social-icon .social-item:focus{ <?php print join(';', $social_hover_styles); ?>}
<?php
  }



  if(isset($sticky_color['regular']) && !empty($sticky_color['regular'])) {
     $sticky_social_styles['color'] = 'color:'.sanitize_hex_color($sticky_color['regular']);
  }

  if(isset($sticky_color['hover']) && !empty($sticky_color['hover'])) {
    $sticky_social_hover_styles['color'] = 'color:'.sanitize_hex_color($sticky_color['hover']).'!important';
  }

  if(isset($sticky_bg_color['regular']) && !empty($sticky_bg_color['regular'])) {
    $sticky_social_styles['background-color'] = 'background-color:'.sanitize_hex_color($sticky_bg_color['regular']);
  }


  if(isset($sticky_bg_color['hover']) && !empty($sticky_bg_color['hover'])) {
    $sticky_social_hover_styles['background-color'] = 'background-color:'.sanitize_hex_color($sticky_bg_color['hover']).'!important';
  }



  if($sticky_style && count($sticky_social_styles)) {
?>
.mainmenu-bar .mainmenu-bar-inner .module-social-icon .social-item{ <?php print join(';', $sticky_social_styles); ?>}
<?php
  }

 if($sticky_style && count($sticky_social_hover_styles)) {
?>
.mainmenu-bar .mainmenu-bar-inner .module-social-icon .social-item:hover,
.mainmenu-bar .mainmenu-bar-inner .module-social-icon .social-item:focus{ <?php print join(';', $sticky_social_hover_styles); ?>}
<?php
  }



}


add_action( 'lapindos_change_style', 'lapindos_change_social_link_color');


function lapindos_change_mainmenu($config=array()){


 $sticky_color= isset($config['sticky-color']) ? $config['sticky-color'] : "";


  if(!empty($sticky_color) && $sticky_color !='' ){?>
.mainmenu-bar,
.mainmenu-bar a
{
  color: <?php print sanitize_hex_color($sticky_color);?>;
}
.mainmenu-bar .heading-module .search-form.nav > li{
  border-color: <?php print sanitize_hex_color($sticky_color);?>;
}

<?php
}
  if(isset($config['sticky_shadow']) && (bool) $config['sticky_shadow']){
    print ($config['sticky_shadow']=='2') ? '.mainmenu-bar.affix .mainmenu-bar-inner{box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);}':'.mainmenu-bar.affix{box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);}';
  }

  $menucolor= isset($config['menu-color']) ? $config['menu-color'] : array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'','active'=>''));

  $menu_styles = $menu_hover_styles  = array();

  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '#222222') {
    $menu_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
  }

  $menuborder =  isset($config['menu-border']) ? $config['menu-border']: '';

  if(is_array($menuborder) && count($menuborder)){

    foreach($menuborder as $property => $val){
        $menu_styles[$property] = esc_attr($property).":".esc_attr($val);
    }
  }

  if(count($menu_styles)) {
?>
  .main-menu > li.page_item > a,
  .main-menu > li.menu-item > a{ <?php print join(';', $menu_styles); ?>}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover']) && $color['hover'] != '#2e96db') {
    $menu_hover_styles['color'] = 'color:'.sanitize_hex_color($color['hover']);
  }


  $menuhoverborder= isset($config['hover-menu-border']) ? $config['hover-menu-border'] :  '';

  $brcolor = wp_parse_args($menuhoverborder,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($brcolor['rgba']) ? $brcolor['rgba'] : "";
  $brcolor_hex = !empty($brcolor['color']) ? $brcolor['color'] : "";

   if($brcolor['color']!='' && '' != strtolower($brcolor_hex)){
    $menu_hover_styles['border-color'] = 'border-color:'.$bgcolor_rgba;
   }

  if(count($menu_hover_styles)) {
?>
.main-menu li.page_item:hover > a,
.main-menu li.menu-item:hover > a
{
  <?php print join(';', $menu_hover_styles); ?>
}
  <?php
  }  
  
  if(isset($color['active']) && !empty($color['active']) && $color['active'] != '#2e96db' ) {?>
.main-menu > li.page_item.current-menu-item > a,
.main-menu > li.menu-item.current-menu-item > a,
.main-menu > li.page_item.current-menu-parent > a,
.main-menu > li.menu-item.current-menu-parent > a,
.main-menu > li.page_item.current_page_item > a,
.main-menu > li.menu-item.current_page_item > a,
.main-menu > li.page_item.current_page_parent > a,
.main-menu > li.menu-item.current_page_parent > a{
  color: <?php print sanitize_hex_color($color['active']);?>;
}
@media (max-width: 768px){

  .main-menu .page_item.page_item_has_children.menu-expand > a,
  .main-menu .menu-item.page_item_has_children.menu-expand > a,
  .main-menu .page_item.menu-item-has-children.menu-expand > a,
  .main-menu .menu-item.menu-item-has-children.menu-expand > a {
      color: <?php print sanitize_hex_color($color['active']);?>;
  }

  .main-menu > li.current-menu-item, .main-menu > li.current-menu-parent,
  .main-menu > li.current_page_item, .main-menu > li.current_page_parent,
  .main-menu > li:hover, .main-menu > li:focus, .main-menu > li.active {
      border-color: <?php print sanitize_hex_color($color['active']);?>;
  }

}
<?php
  } 

  $menucolor= isset($config['sub-menu-color']) ? $config['sub-menu-color'] :  array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'', 'active'=>''));


  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '#ffffff') {?>
.main-menu .sub-menu .page_item > a,
.main-menu .sub-menu .menu-item > a{
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
 <?php }

  if(isset($color['hover']) && !empty($color['hover']) && $color['hover']!='#fde428') {
  ?>
.main-menu .sub-menu .page_item:hover > a,
.main-menu .sub-menu .menu-item:hover > a,
.main-menu .sub-menu .page_item:focus > a,
.main-menu .sub-menu .menu-item:focus > a {
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  if(isset($color['active']) && !empty($color['active']) && $color['active'] !='#fde428') {?>
.main-menu .sub-menu .page_item.current_page_item > a,
.main-menu .sub-menu .menu-item.current_page_item > a,
.main-menu .sub-menu .page_item.current_page_parent > a,
.main-menu .sub-menu .menu-item.current_page_parent > a {
 color: <?php print sanitize_hex_color($color['active']);?>;
}
  <?php 
  }


  $dropcolor= isset($config['dropdown-background-color']) ? $config['dropdown-background-color'] :  '';

  $bgcolor = wp_parse_args($dropcolor,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && '#5aace2' != strtolower($bgcolor_hex)){?>
.main-menu .sub-menu-container,
.heading-module .search-form.nav .dropdown-menu{
  background-color: <?php print $bgcolor_rgba;?>;
}

.main-menu .sub-menu-container .page_item:hover,
.main-menu .sub-menu-container .menu-item:hover,
.main-menu .sub-menu-container .page_item:focus,
.main-menu .sub-menu-container .menu-item:focus {
  background: <?php print lapindos_darken($bgcolor_hex,10);?>;
}

.main-menu .sub-menu .page_item,
.main-menu .sub-menu .menu-item {
  border-bottom-color: <?php print lapindos_lighten($bgcolor_hex,10);?>;
}

<?php 
  }

  $color= isset($config['mobile-background-color']) ? $config['mobile-background-color'] :  array();

  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.mainmenu-bar.affix{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $color= isset($config['mobile-inside-background-color']) ? $config['mobile-inside-background-color'] :  array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#ffffff' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.mainmenu-bar .mainmenu-bar-inner{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }


  $menucolor= isset($config['mobile-menu-color']) ? $config['mobile-menu-color'] :  array();
  $color = wp_parse_args($menucolor,array('regular'=>'','hover'=>'', 'active'=>''));
?>
@media (max-width: 768px){
<?php
  if(isset($color['regular']) && !empty($color['regular']) && $color['regular'] != '') {?>
.main-menu .sub-menu-container .sub-menu .menu-item > a,
.main-menu .sub-menu-container .sub-menu page_item > a,
.main-menu > li.page_item > a, .main-menu > li.menu-item > a {
  color: <?php print sanitize_hex_color($color['regular']);?>;
}
 <?php 
}

  if(isset($color['hover']) && !empty($color['hover']) && $color['hover']!='') {
  ?>
.main-menu > li:hover,
.main-menu .sub-menu-container .menu-item:focus > a,
.main-menu .sub-menu-container .page_item:focus > a,
.main-menu .sub-menu-container .menu-item:hover > a,
.main-menu .sub-menu-container .page_item:hover > a{
  color: <?php print sanitize_hex_color($color['hover']);?>;
}
<?php
  }

  if(isset($color['active']) && !empty($color['active']) && $color['active'] !='') {?>

.main-menu .page_item.page_item_has_children.menu-expand > a,
.main-menu .menu-item.page_item_has_children.menu-expand > a,
.main-menu .page_item.menu-item-has-children.menu-expand > a,
.main-menu .menu-item.menu-item-has-children.menu-expand > a {
    color: <?php print sanitize_hex_color($color['active']);?>;
}

.main-menu > li.current-menu-item, .main-menu > li.current-menu-parent,
.main-menu > li.current_page_item, .main-menu > li.current_page_parent,
.main-menu > li:hover, .main-menu > li:focus, .main-menu > li.active {
    border-color: <?php print sanitize_hex_color($color['active']);?>;
}
  <?php 
  }


  $color= isset($config['mobile-menu-bg']) ? $config['mobile-menu-bg'] :  array();
  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor['color']!='' && ('#f7f7f7' != strtolower($bgcolor_hex) || $bgcolor['alpha']!='1') ){?>
.main-menu > li{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }

?>
}
<?php

  $spacing= isset($config['stickybar-spacing']) ? $config['stickybar-spacing'] :  array();
  $padding_top = isset($spacing['padding-top']) ? $spacing['padding-top'] : '';
  $padding_bottom = isset($spacing['padding-bottom']) ? $spacing['padding-bottom'] : '';

  ?>
  .mainmenu-bar .mainmenu-bar-inner,
  .mainmenu-bar.affix .mainmenu-bar-inner{
  <?php   if($padding_top!='') {?>
        padding-top: <?php print absint($padding_top);?>px;
  <?php }
    if($padding_bottom!='' ) {?>
        padding-bottom: <?php print absint($padding_bottom);?>px;
  <?php }?>
  }
<?php

  $menubar = isset($config['menubar-border']) ? $config['menubar-border'] : '';
  $menubar_styles = array();

  if(is_array($menubar) && count($menubar)){
    foreach($menubar as $property => $val){
      $menubar_styles[$property] = esc_attr($property).":".esc_attr($val);
    }

  }

  if(count($menubar_styles)):?>

  .top-heading .module-main-menu .main-menu{<?php print join(';', $menubar_styles);?> }

  <?php endif;


  $stikcy_menucolor= isset($config['sticky-menu-color']) ? $config['sticky-menu-color'] : array();
  $menucolor = wp_parse_args($stikcy_menucolor,array('regular'=>'','hover'=>'','active'=>''));

 if(isset($menucolor['regular']) && $menucolor['regular']!= '') {
?>
.mainmenu-bar .main-menu > li.page_item > a,
.mainmenu-bar .main-menu > li.menu-item > a{ color: <?php print sanitize_hex_color($menucolor['regular']); ?>}
<?php
  }

  if(isset($menucolor['hover']) && $menucolor['hover']!= '') {?>
.mainmenu-bar .main-menu li.page_item:hover > a,
.mainmenu-bar .main-menu li.menu-item:hover > a
{
  color: <?php print sanitize_hex_color($menucolor['hover']); ?>
}

<?php
  }
  
if(isset($menucolor['active']) && $menucolor['active'] != '' ) {?>
  .mainmenu-bar .main-menu > li.page_item.current-menu-item > a,
  .mainmenu-bar .main-menu > li.menu-item.current-menu-item > a,
  .mainmenu-bar .main-menu > li.page_item.current-menu-parent > a,
  .mainmenu-bar .main-menu > li.menu-item.current-menu-parent > a,
  .mainmenu-bar .main-menu > li.page_item.current_page_item > a,
  .mainmenu-bar .main-menu > li.menu-item.current_page_item > a,
  .mainmenu-bar .main-menu > li.page_item.current_page_parent > a,
  .mainmenu-bar .main-menu > li.menu-item.current_page_parent > a{
    color: <?php print sanitize_hex_color($menucolor['active']);?>;
  }

<?php
  }

}

add_action( 'lapindos_change_style', 'lapindos_change_mainmenu');


function lapindos_change_shortmenu_styles($config=array()){


  $color = isset($config['short_menu_color']) ? $config['short_menu_color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));

  $sticky_style = isset($config['sticky_short_menu_skin']) ? (bool)$config['sticky_short_menu_skin'] : false;

  $sticky_color = isset($config['short_menu_sticky_color']) ? $config['short_menu_sticky_color'] : array();
  $sticky_color = wp_parse_args($sticky_color,array('regular'=>'','hover'=>''));


  if(isset($color['regular']) && !empty($color['regular'])) {?>
.top-heading .top-bar-menu > .menu-item > a,
.mainmenu-bar .top-bar-menu > .menu-item > a{color: <?php print sanitize_hex_color($color['regular']); ?>;}
<?php
  }

  if(isset($color['hover']) && !empty($color['hover'])) {?>
.top-heading .top-bar-menu > .menu-item > a:hover,
.mainmenu-bar .top-bar-menu > .menu-item > a:hover{color: <?php print sanitize_hex_color($color['hover']); ?>!important;}
<?php
  }

  if($sticky_style){

    if(isset($sticky_color['regular']) && !empty($sticky_color['regular'])) {?>
  .mainmenu-bar .top-bar-menu > .menu-item > a{color: <?php print sanitize_hex_color($sticky_color['regular']); ?>;}
  <?php
    }

    if(isset($sticky_color['hover']) && !empty($sticky_color['hover'])) {?>
  .mainmenu-bar .top-bar-menu > .menu-item > a:hover{color: <?php print sanitize_hex_color($sticky_color['hover']); ?>!important;}
  <?php
    }

  }


}


add_action( 'lapindos_change_style', 'lapindos_change_shortmenu_styles');

/* brand color */
function lapindos_change_primary_color($config=array()){

  $color= isset($config['primary_color']) ? trim($config['primary_color']) :  "";

  if(empty($color) || '#2e96db'== strtolower($color)) return;?>

.text-primary,
.cl-prime,
.primary-color,
.color-primary,
.cl-hover-prime:hover,
.color-hover-primary:hover,
pre,
.widget .widget-title,
.widget .widgettitle,
.widget.widget_calendar #wp-calendar td a,
.widget.widget_calendar table td a,
.widget.widget_calendar #wp-calendar #today,
.widget.widget_calendar table #today,
.widget.widget_calendar #wp-calendar #today a,
.widget.widget_calendar table #today a,
.widget.widget_recent_entries > ul > li > a:hover,
.widget.widget_recent_entries > ul > li > a:focus,
.widget.widget_archive li:hover, .widget.widget_archive li:hover a,
.widget.widget_archive li a:hover,
.btn-primary .badge,
a.btn-primary .badge,
.btn.btn-primary-outline,
.el-btn a.btn.btn-primary-outline,
.el-btn button.btn.btn-primary-outline,
a.btn.btn-primary-outline,
.btn.btn-skin-primary-outline,
.el-btn a.btn.btn-skin-primary-outline,
.el-btn button.btn.btn-skin-primary-outline,
a.btn.btn-skin-primary-outline,
.btn.btn-skin-primary-ghost,
.el-btn a.btn.btn-skin-primary-ghost,
.el-btn button.btn.btn-skin-primary-ghost,
a.btn.btn-skin-primary-ghost,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:hover,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:focus,
.widget.soclean_widget_social .social-icon-lists.skin-primary-ghost .social-item i,
.widget.widget_rss li a:hover, .widget.widget_meta li a:hover,.widget.widget_recent_comments li a:hover,
.widget.superclean_nav_menu ul .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_superclean_pages ul .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.superclean_nav_menu .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_superclean_pages .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.superclean_nav_menu ul .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_superclean_pages ul .page_item.menu-item-has-children .menu-item > a:hover,
.widget.superclean_nav_menu .menu .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_superclean_pages .menu .page_item.menu-item-has-children .menu-item > a:hover,
.widget.superclean_nav_menu ul .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_superclean_pages ul .menu-item.page_item_has_children .menu-item > a:hover,
.widget.superclean_nav_menu .menu .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_superclean_pages .menu .menu-item.page_item_has_children .menu-item > a:hover,
.widget.superclean_nav_menu ul .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_superclean_pages ul .page_item.page_item_has_children .menu-item > a:hover,
.widget.superclean_nav_menu .menu .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_superclean_pages .menu .page_item.page_item_has_children .menu-item > a:hover,
.widget.superclean_nav_menu ul .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_superclean_pages ul .menu-item.menu-item-has-children .page_item > a:hover,
.widget.superclean_nav_menu .menu .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_superclean_pages .menu .menu-item.menu-item-has-children .page_item > a:hover,
.widget.superclean_nav_menu ul .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_superclean_pages ul .page_item.menu-item-has-children .page_item > a:hover,
.widget.superclean_nav_menu .menu .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_superclean_pages .menu .page_item.menu-item-has-children .page_item > a:hover,
.widget.superclean_nav_menu ul .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_superclean_pages ul .menu-item.page_item_has_children .page_item > a:hover,
.widget.superclean_nav_menu .menu .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_superclean_pages .menu .menu-item.page_item_has_children .page_item > a:hover,
.widget.superclean_nav_menu ul .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_superclean_pages ul .page_item.page_item_has_children .page_item > a:hover,
.widget.superclean_nav_menu .menu .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_superclean_pages .menu .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_nav_menu ul .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_pages ul .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_nav_menu .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_pages .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.widget.widget_nav_menu ul .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_pages ul .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_nav_menu .menu .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_pages .menu .page_item.menu-item-has-children .menu-item > a:hover,
.widget.widget_nav_menu ul .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_pages ul .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_nav_menu .menu .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_pages .menu .menu-item.page_item_has_children .menu-item > a:hover,
.widget.widget_nav_menu ul .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_pages ul .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_nav_menu .menu .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_pages .menu .page_item.page_item_has_children .menu-item > a:hover,
.widget.widget_nav_menu ul .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_pages ul .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_nav_menu .menu .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_pages .menu .menu-item.menu-item-has-children .page_item > a:hover,
.widget.widget_nav_menu ul .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_pages ul .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_nav_menu .menu .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_pages .menu .page_item.menu-item-has-children .page_item > a:hover,
.widget.widget_nav_menu ul .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_pages ul .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_nav_menu .menu .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_pages .menu .menu-item.page_item_has_children .page_item > a:hover,
.widget.widget_nav_menu ul .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_pages ul .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_nav_menu .menu .page_item.page_item_has_children .page_item > a:hover,
.widget.widget_pages .menu .page_item.page_item_has_children .page_item > a:hover,
.team_custom .phone > span,
.responsive_tab.style-faq .panel.panel-default .panel-heading a:hover,
.responsive_tab .panel.panel-default .panel-heading.openedup,
.responsive_tab .panel.panel-default .panel-heading.openedup a:focus,
.responsive_tab .nav-tabs > li.active a,
.widget.widget_categories ul li .sub-menu li:hover,
.widget.widget_product_categories ul li .sub-menu li:hover,
.widget.widget_categories ul li .children li:hover,
.widget.widget_product_categories ul li .children li:hover,
.widget.widget_categories ul li .sub-menu li:hover a,
.widget.widget_product_categories ul li .sub-menu li:hover a,
.widget.widget_categories ul li .children li:hover a,
.widget.widget_product_categories ul li .children li:hover a,
.widget.widget_categories ul li .sub-menu li > a:hover,
.widget.widget_product_categories ul li .sub-menu li > a:hover,
.widget.widget_categories ul li .children li > a:hover,
.widget.widget_product_categories ul li .children li > a:hover,
.widget.widget_categories ul li .sub-menu li > a:focus,
.widget.widget_product_categories ul li .sub-menu li > a:focus,
.widget.widget_categories ul li .children li > a:focus,
.widget.widget_product_categories ul li .children li > a:focus,
ul.list-info > li:before, ul.checklist > li:before,ul.checkbox > li:before,
ul.bull > li:before, ul.circle > li:before,
.search-results .post-lists article.type-product .price,
.gum_portfolio .portfolio-filter li > a:hover,
.gum_portfolio .portfolio-filter li > a:focus,
.gum_portfolio .portfolio-filter li.active a,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:hover,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:focus
{
  color: <?php print sanitize_hex_color($color);?>;
}

.bc-prime,
.background-primary,
.btn.btn-primary,
.el-btn a.btn.btn-primary,
.el-btn button.btn.btn-primary,
a.btn.btn-primary,
.btn.btn-primary-thirdy,
.el-btn a.btn.btn-primary-thirdy,
.el-btn button.btn.btn-primary-thirdy,
a.btn.btn-primary-thirdy,
.btn.btn-skin-primary,
.el-btn a.btn.btn-skin-primary,
.el-btn button.btn.btn-skin-primary,
a.btn.btn-skin-primary,
.btn.btn-skin-primary-thirdy,
.el-btn a.btn.btn-skin-primary-thirdy,
.el-btn button.btn.btn-skin-primary-thirdy,
a.btn.btn-skin-primary-thirdy,
.btn.btn-primary-outline:hover,
.el-btn a.btn.btn-primary-outline:hover,
.el-btn button.btn.btn-primary-outline:hover,
a.btn.btn-primary-outline:hover,
.btn.btn-skin-primary-outline:hover,
.el-btn a.btn.btn-skin-primary-outline:hover,
.el-btn button.btn.btn-skin-primary-outline:hover,
a.btn.btn-skin-primary-outline:hover,
.btn.btn-skin-primary-ghost:hover,
.el-btn a.btn.btn-skin-primary-ghost:hover,
.el-btn button.btn.btn-skin-primary-ghost:hover,
a.btn.btn-skin-primary-ghost:hover,
.btn.btn-primary-outline:focus,
.el-btn a.btn.btn-primary-outline:focus,
.el-btn button.btn.btn-primary-outline:focus,
a.btn.btn-primary-outline:focus,
.btn.btn-skin-primary-outline:focus,
.el-btn a.btn.btn-skin-primary-outline:focus,
.el-btn button.btn.btn-skin-primary-outline:focus,
a.btn.btn-skin-primary-outline:focus,
.btn.btn-skin-primary-ghost:focus,
.el-btn a.btn.btn-skin-primary-ghost:focus,
.el-btn button.btn.btn-skin-primary-ghost:focus,
a.btn.btn-skin-primary-ghost:focus,
.btn.btn-secondary:hover,
.el-btn a.btn.btn-secondary:hover,
.el-btn button.btn.btn-secondary:hover,
a.btn.btn-secondary:hover,
.btn.btn-skin-secondary:hover,
.el-btn a.btn.btn-skin-secondary:hover,
.el-btn button.btn.btn-skin-secondary:hover,
a.btn.btn-skin-secondary:hover,
.btn.btn-secondary:focus,
.el-btn a.btn.btn-secondary:focus,
.el-btn button.btn.btn-secondary:focus,
a.btn.btn-secondary:focus,
.btn.btn-skin-secondary:focus,
.el-btn a.btn.btn-skin-secondary:focus,
.el-btn button.btn.btn-skin-secondary:focus,
a.btn.btn-skin-secondary:focus,
.btn.btn-thirdy:hover,
.el-btn a.btn.btn-thirdy:hover,
.el-btn button.btn.btn-thirdy:hover,
a.btn.btn-thirdy:hover,
.btn.btn-skin-thirdy:hover,
.el-btn a.btn.btn-skin-thirdy:hover,
.el-btn button.btn.btn-skin-thirdy:hover,
a.btn.btn-skin-thirdy:hover,
.btn.btn-thirdy:focus,
.el-btn a.btn.btn-thirdy:focus,
.el-btn button.btn.btn-thirdy:focus,
a.btn.btn-thirdy:focus,
.btn.btn-skin-thirdy:focus,
.el-btn a.btn.btn-skin-thirdy:focus,
.el-btn button.btn.btn-skin-thirdy:focus,
a.btn.btn-skin-thirdy:focus,
.author-profile,
.background-primary,
.woocommerce #respond input#submit, input.woocommerce-button,
input.woocommerce-Button, button.single_add_to_cart_button,
.button.product_type_grouped, .single_add_to_cart_button,
.add_to_cart_button, .button.add_to_cart_button,
.button.product_type_external, button.button.alt,
button.button.alt.disabled, a.woocommerce-button, a.woocommerce-Button,
.woocommerce-button, .woocommerce-Button, .button.wc-backward, .wc-backward,
.woocommerce-button[disabled], .woocommerce .wc-proceed-to-checkout a.checkout-button,
.woocommerce-button[disabled]:disabled, .woocommerce input.button:disabled,
.woocommerce input.button:disabled[disabled], .woocommerce #respond input#submit.button,
input.woocommerce-button.button, input.woocommerce-Button.button,
button.single_add_to_cart_button.button, .button.product_type_grouped.button,
.single_add_to_cart_button.button, .add_to_cart_button.button,
.button.add_to_cart_button.button, .button.product_type_external.button,
button.button.alt.button, button.button.alt.disabled.button,
a.woocommerce-button.button, a.woocommerce-Button.button,
.woocommerce-button.button, .woocommerce-Button.button,
.button.wc-backward.button, .wc-backward.button,
.woocommerce-button[disabled].button,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button,
.woocommerce-button[disabled]:disabled.button,
.woocommerce input.button:disabled.button,
.woocommerce input.button:disabled[disabled].button,
.comment-respond .comment-form .form-submit .button,
.woocommerce.widget_shopping_cart .wc-forward,
.woocommerce.widget_shopping_cart .button.wc-forward,
.woocommerce .widget_price_filter .price_slider_amount .button,
.widget_price_filter .price_slider_amount .button,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.widget_price_filter .ui-slider .ui-slider-range,
.pagination li .page-numbers:not(.current):hover,
.pagination li .page-numbers:not(.current):focus,
.page-pagination > a .page-numbers:hover,
.page-pagination > a .page-numbers:focus,
.page-pagination .page-numbers.current,
.page-pagination .page-numbers:hover,
.page-pagination .page-numbers:focus,
.page-pagination > .page-numbers,
.pagination li .page-numbers.current,
.pagination li .page-numbers:hover,
.pagination li .page-numbers:focus,
.pagination li .older-post,
.pagination li .newest-post,
.pagination li .older-post.disabled:hover,
.pagination li .newest-post.disabled:hover,
.pagination li .older-post[disabled]:hover,
.pagination li .newest-post[disabled]:hover,
fieldset[disabled] .pagination li .older-post:hover,
fieldset[disabled] .pagination li .newest-post:hover,
.pagination li .older-post.disabled:focus,
.pagination li .newest-post.disabled:focus,
.pagination li .older-post[disabled]:focus,
.pagination li .newest-post[disabled]:focus,
fieldset[disabled] .pagination li .older-post:focus,
fieldset[disabled] .pagination li .newest-post:focus,
.pagination li .older-post.disabled.focus,
.pagination li .newest-post.disabled.focus,
.pagination li .older-post[disabled].focus,
.pagination li .newest-post[disabled].focus,
fieldset[disabled] .pagination li .older-post.focus,
fieldset[disabled] .pagination li .newest-post.focus,
#toTop,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-primary-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-primary-ghost .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-primary-ghost .social-item:focus i,
form.search-form .search-ico,
.post-lists.blog-col-2 article .post-content:before,
.post-lists.blog-col-3 article .post-content:before,
.post-lists.blog-col-4 article .post-content:before,
.tagcloud a:hover,
.tagcloud a:focus,
.responsive_tab .panel.panel-default .panel-heading,
.responsive_tab .nav-tabs > li:not(.active) a,
.responsive_tab .nav-tabs > li:not(.active) a:hover,
.responsive_tab .nav-tabs > li:not(.active) a:focus,
.el_progress_bar .progress-bar-outer .progress-bar,
.price-block.layout-2 .price-footer .btn:hover,
.price-block.layout-2 .price-footer .btn:focus,
.youtube_popup .action-panel:hover,
.youtube_popup .action-panel:focus,
.top-heading .heading-module .search-form .navbar-form,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl,
.woocommerce.single-product .woocommerce-tabs ul.tabs.wc-tabs li.active{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.br-prime,
.border-primary,
.br-hover-prime:hover,
.border-hover-primary:hover,
.btn.btn-primary,
.el-btn a.btn.btn-primary,
.el-btn button.btn.btn-primary,
a.btn.btn-primary,
.btn.btn-primary-thirdy,
.el-btn a.btn.btn-primary-thirdy,
.el-btn button.btn.btn-primary-thirdy,
a.btn.btn-primary-thirdy,
.btn.btn-skin-primary,
.el-btn a.btn.btn-skin-primary,
.el-btn button.btn.btn-skin-primary,
a.btn.btn-skin-primary,
.btn.btn-skin-primary-thirdy,
.el-btn a.btn.btn-skin-primary-thirdy,
.el-btn button.btn.btn-skin-primary-thirdy,
a.btn.btn-skin-primary-thirdy,
.btn.btn-primary-outline,
.el-btn a.btn.btn-primary-outline,
.el-btn button.btn.btn-primary-outline,
a.btn.btn-primary-outline,
.btn.btn-skin-primary-outline,
.el-btn a.btn.btn-skin-primary-outline,
.el-btn button.btn.btn-skin-primary-outline,
a.btn.btn-skin-primary-outline,
.btn.btn-skin-primary-ghost,
.el-btn a.btn.btn-skin-primary-ghost,
.el-btn button.btn.btn-skin-primary-ghost,
a.btn.btn-skin-primary-ghost,
.btn.btn-secondary:hover,
.el-btn a.btn.btn-secondary:hover,
.el-btn button.btn.btn-secondary:hover,
a.btn.btn-secondary:hover,
.btn.btn-skin-secondary:hover,
.el-btn a.btn.btn-skin-secondary:hover,
.el-btn button.btn.btn-skin-secondary:hover,
a.btn.btn-skin-secondary:hover,
.btn.btn-secondary:focus,
.el-btn a.btn.btn-secondary:focus,
.el-btn button.btn.btn-secondary:focus,
a.btn.btn-secondary:focus,
.btn.btn-skin-secondary:focus,
.el-btn a.btn.btn-skin-secondary:focus,
.el-btn button.btn.btn-skin-secondary:focus,
a.btn.btn-skin-secondary:focus,
.btn.btn-thirdy:hover,
.el-btn a.btn.btn-thirdy:hover,
.el-btn button.btn.btn-thirdy:hover,
a.btn.btn-thirdy:hover,
.btn.btn-skin-thirdy:hover,
.el-btn a.btn.btn-skin-thirdy:hover,
.el-btn button.btn.btn-skin-thirdy:hover,
a.btn.btn-skin-thirdy:hover,
.btn.btn-thirdy:focus,
.el-btn a.btn.btn-thirdy:focus,
.el-btn button.btn.btn-thirdy:focus,
a.btn.btn-thirdy:focus,
.btn.btn-skin-thirdy:focus,
.el-btn a.btn.btn-skin-thirdy:focus,
.el-btn button.btn.btn-skin-thirdy:focus,
a.btn.btn-skin-thirdy:focus,
.woocommerce #respond input#submit, input.woocommerce-button,
input.woocommerce-Button, button.single_add_to_cart_button,
.button.product_type_grouped, .single_add_to_cart_button,
.add_to_cart_button, .button.add_to_cart_button,
.button.product_type_external, button.button.alt,
button.button.alt.disabled, a.woocommerce-button, a.woocommerce-Button,
.woocommerce-button, .woocommerce-Button, .button.wc-backward, .wc-backward,
.woocommerce-button[disabled], .woocommerce .wc-proceed-to-checkout a.checkout-button,
.woocommerce-button[disabled]:disabled, .woocommerce input.button:disabled,
.woocommerce input.button:disabled[disabled], .woocommerce #respond input#submit.button,
input.woocommerce-button.button, input.woocommerce-Button.button,
button.single_add_to_cart_button.button, .button.product_type_grouped.button,
.single_add_to_cart_button.button, .add_to_cart_button.button,
.button.add_to_cart_button.button, .button.product_type_external.button,
button.button.alt.button, button.button.alt.disabled.button,
a.woocommerce-button.button, a.woocommerce-Button.button,
.woocommerce-button.button, .woocommerce-Button.button,
.button.wc-backward.button, .wc-backward.button,
.woocommerce-button[disabled].button,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button,
.woocommerce-button[disabled]:disabled.button,
.woocommerce input.button:disabled.button,
.woocommerce input.button:disabled[disabled].button,
.comment-respond .comment-form .form-submit .button,
.woocommerce.widget_shopping_cart .wc-forward,
.woocommerce.widget_shopping_cart .button.wc-forward,
.woocommerce .widget_price_filter .price_slider_amount .button,
.widget_price_filter .price_slider_amount .button,
.woo-variation-swatches-stylesheet-enabled .variable-items-wrapper .variable-item:not(.radio-variable-item),
.tagcloud a:hover,
.tagcloud a:focus,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-primary-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-primary-ghost .social-item i,
form.search-form .search-ico,
.widget.superclean_nav_menu > ul > .menu-item:hover > a,
.widget.widget_superclean_pages > ul > .menu-item:hover > a,
.widget.superclean_nav_menu .menu > .menu-item:hover > a,
.widget.widget_superclean_pages .menu > .menu-item:hover > a,
.widget.superclean_nav_menu > ul > .page_item:hover > a,
.widget.widget_superclean_pages > ul > .page_item:hover > a,
.widget.superclean_nav_menu .menu > .page_item:hover > a,
.widget.widget_superclean_pages .menu > .page_item:hover > a,
.widget.superclean_nav_menu > ul > li:hover > a,
.widget.widget_superclean_pages > ul > li:hover > a,
.widget.superclean_nav_menu .menu > li:hover > a,
.widget.widget_superclean_pages .menu > li:hover > a,
.widget.superclean_nav_menu > ul > .menu-item:focus > a,
.widget.widget_superclean_pages > ul > .menu-item:focus > a,
.widget.superclean_nav_menu .menu > .menu-item:focus > a,
.widget.widget_superclean_pages .menu > .menu-item:focus > a,
.widget.superclean_nav_menu > ul > .page_item:focus > a,
.widget.widget_superclean_pages > ul > .page_item:focus > a,
.widget.superclean_nav_menu .menu > .page_item:focus > a,
.widget.widget_superclean_pages .menu > .page_item:focus > a,
.widget.superclean_nav_menu > ul > li:focus > a,
.widget.widget_superclean_pages > ul > li:focus > a,
.widget.superclean_nav_menu .menu > li:focus > a,
.widget.widget_superclean_pages .menu > li:focus > a,
.widget.superclean_nav_menu > ul > .menu-item.active > a,
.widget.widget_superclean_pages > ul > .menu-item.active > a,
.widget.superclean_nav_menu .menu > .menu-item.active > a,
.widget.widget_superclean_pages .menu > .menu-item.active > a,
.widget.superclean_nav_menu > ul > .page_item.active > a,
.widget.widget_superclean_pages > ul > .page_item.active > a,
.widget.superclean_nav_menu .menu > .page_item.active > a,
.widget.widget_superclean_pages .menu > .page_item.active > a,
.widget.superclean_nav_menu > ul > li.active > a,
.widget.widget_superclean_pages > ul > li.active > a,
.widget.superclean_nav_menu .menu > li.active > a,
.widget.widget_superclean_pages .menu > li.active > a,
.widget.widget_categories > ul > li:hover > a,
.widget.widget_product_categories > ul > li:hover > a,
.widget.widget_categories > ul > li:focus > a,
.widget.widget_product_categories > ul > li:focus > a,
.widget.widget_categories > ul > li.active > a,
.widget.widget_product_categories > ul > li.active > a,
.widget.widget_nav_menu > ul > .menu-item:hover > a,
.widget.widget_pages > ul > .menu-item:hover > a,
.widget.widget_nav_menu .menu > .menu-item:hover > a,
.widget.widget_pages .menu > .menu-item:hover > a,
.widget.widget_nav_menu > ul > .page_item:hover > a,
.widget.widget_pages > ul > .page_item:hover > a,
.widget.widget_nav_menu .menu > .page_item:hover > a,
.widget.widget_pages .menu > .page_item:hover > a,
.widget.widget_nav_menu > ul > li:hover > a,
.widget.widget_pages > ul > li:hover > a,
.widget.widget_nav_menu .menu > li:hover > a,
.widget.widget_pages .menu > li:hover > a,
.widget.widget_nav_menu > ul > .menu-item:focus > a,
.widget.widget_pages > ul > .menu-item:focus > a,
.widget.widget_nav_menu .menu > .menu-item:focus > a,
.widget.widget_pages .menu > .menu-item:focus > a,
.widget.widget_nav_menu > ul > .page_item:focus > a,
.widget.widget_pages > ul > .page_item:focus > a,
.widget.widget_nav_menu .menu > .page_item:focus > a,
.widget.widget_pages .menu > .page_item:focus > a,
.widget.widget_nav_menu > ul > li:focus > a,
.widget.widget_pages > ul > li:focus > a,
.widget.widget_nav_menu .menu > li:focus > a,
.widget.widget_pages .menu > li:focus > a,
.widget.widget_nav_menu > ul > .menu-item.active > a,
.widget.widget_pages > ul > .menu-item.active > a,
.widget.widget_nav_menu .menu > .menu-item.active > a,
.widget.widget_pages .menu > .menu-item.active > a,
.widget.widget_nav_menu > ul > .page_item.active > a,
.widget.widget_pages > ul > .page_item.active > a,
.widget.widget_nav_menu .menu > .page_item.active > a,
.widget.widget_pages .menu > .page_item.active > a,
.widget.widget_nav_menu > ul > li.active > a,
.widget.widget_pages > ul > li.active > a,
.widget.widget_nav_menu .menu > li.active > a,
.widget.widget_pages .menu > li.active > a,
.widget.widget_meta > ul > li:hover > a, .widget.widget_archive > ul > li:hover > a,
.widget.widget_categories > ul > li:hover > a, .widget.widget_product_categories > ul > li:hover > a,
.widget.widget_meta > ul > li:focus > a, .widget.widget_archive > ul > li:focus > a,
.widget.widget_categories > ul > li:focus > a, .widget.widget_product_categories > ul > li:focus > a,
.widget.widget_meta > ul > li.active > a, .widget.widget_archive > ul > li.active > a,
.widget.widget_categories > ul > li.active > a,
.widget.widget_product_categories > ul > li.active > a,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl,
.woocommerce-account .woocommerce-MyAccount-navigation > ul > li:hover,
.woocommerce-account .woocommerce-MyAccount-navigation > ul > li:focus,
.woocommerce-account .woocommerce-MyAccount-navigation > ul > li.active
{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.section-heading:before,
.single-tg_custom_post .post-content h2:before,
.single-superclean_service .post-content h2:before,
.team_custom hr:after,
.post-lists article.sticky:before,
.section-head.layout-petro:before{
  border-top-color: <?php print sanitize_hex_color($color);?>;
}

blockquote{
  border-left-color: <?php print sanitize_hex_color($color);?>;  
}

@media(max-width: 768px){
  .heading-module .search-form .navbar-form .search-field {
      color: <?php print sanitize_hex_color($color);?>;
  }
}
<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_primary_color');


/* secondary color */

function lapindos_change_secondary_color($config=array()){

  $color= isset($config['secondary_color']) ? trim($config['secondary_color']) :  "";

  if(empty($color) || '#fde428'== strtolower($color)) return;

  ?>

.text-secondary,
.secondary-color,
.color-secondary,
.section-heading,
.btn.btn-secondary-outline,
.el-btn a.btn.btn-secondary-outline,
.el-btn button.btn.btn-secondary-outline,
a.btn.btn-secondary-outline,
.btn.btn-skin-secondary-ghost,
.el-btn a.btn.btn-skin-secondary-ghost,
.el-btn button.btn.btn-skin-secondary-ghost,
a.btn.btn-skin-secondary-ghost,
.comment-respond .comment-notes,
.content-comments .heading,
.content-comments .comment-list .comment-body .comment-author,
.content-comments .comment-list .comment-body .comment-author a,
.author-profile .itemAuthorName a,
.pagination li .older-post .badge,
.pagination li .newest-post .badge,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item i,
.btn-secondary .badge,
a.btn-secondary .badge,
.single-tg_custom_post .post-content h2,
.single-superclean_service .post-content h2,
.module-iconboxes .more-link,
.module-iconboxes.style-7:hover .box-heading,
.responsive_tab .panel-title .accordion-toggle[aria-expanded=true],
.responsive_tab .panel-title .accordion-toggle[aria-expanded=true]:hover,
.responsive_tab .nav-tabs li.active > a,
.responsive_tab .nav-tabs li.active > a:focus,
.widget.widget_calendar #wp-calendar td a:hover,
.widget.widget_calendar table td a:hover,
.widget.widget_calendar #wp-calendar #today a:hover,
.widget.widget_calendar table #today a:hover,
.widget.widget_calendar a:hover,
.widget.widget_calendar a:focus,
.widget.widget_calendar #wp-calendar #prev:hover a,
.widget.widget_calendar table #prev:hover a,
.widget.widget_calendar #wp-calendar #next:hover a,
.widget.widget_calendar table #next:hover a,
.footer-widget .widget.widget_calendar #wp-calendar #today,
.footer-widget .widget.widget_calendar table #today,
.footer-widget .widget.widget_calendar #wp-calendar #today a,
.footer-widget .widget.widget_calendar table #today a,
.footer-widget .widget.widget_calendar #wp-calendar td a,
.footer-widget .widget.widget_calendar table td a,
.el_progress_bar .progress-bar-label,
.team_custom.petro .profile-scocial a,
.team_custom.petro:hover,
.team_custom.petro:focus,
.team_custom.petro:hover .profile-subheading,
.team_custom.petro:focus .profile-subheading,
.price-block .price-footer .btn:hover,
.price-block .price-footer .btn:focus,
.footer-widget .widget.widget_rss li a:hover,
.footer-widget .widget.widget_meta li a:hover,
.footer-widget .widget.widget_archive li:hover,
.footer-widget .widget.widget_archive li:hover a,
.footer-widget .widget.widget_archive li a:hover,
.footer-widget .widget.widget_recent_comments li a:hover,
.footer-widget .widget.widget_categories ul li .sub-menu li:hover,
.footer-widget .widget.widget_product_categories ul li .sub-menu li:hover,
.footer-widget .widget.widget_categories ul li .children li:hover,
.footer-widget .widget.widget_product_categories ul li .children li:hover,
.footer-widget .widget.widget_categories ul li .sub-menu li:hover > a,
.footer-widget .widget.widget_product_categories ul li .sub-menu li:hover > a,
.footer-widget .widget.widget_categories ul li .children li:hover > a,
.footer-widget .widget.widget_product_categories ul li .children li:hover > a,
.footer-widget .widget.widget_categories ul li .sub-menu li > a:hover,
.footer-widget .widget.widget_product_categories ul li .sub-menu li > a:hover,
.footer-widget .widget.widget_categories ul li .children li > a:hover,
.footer-widget .widget.widget_product_categories ul li .children li > a:hover,
.footer-widget .widget.widget_categories ul li .sub-menu li > a:focus,
.footer-widget .widget.widget_product_categories ul li .sub-menu li > a:focus,
.footer-widget .widget.widget_categories ul li .children li > a:focus,
.footer-widget .widget.widget_product_categories ul li .children li > a:focus,
.footer-widget .widget.widget_nav_menu ul li.menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_pages ul li.menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_pages ul li.page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_pages ul li.menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_pages ul li.page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_pages ul li.menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_pages ul li.page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_pages ul li.menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_nav_menu ul li.page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_pages ul li.page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .menu-item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .page_item.menu-item-has-children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .menu-item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .page_item.page_item_has_children .menu-item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .menu-item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .page_item.menu-item-has-children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .menu-item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu > ul .page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages > ul .page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.superclean_nav_menu .menu .page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_superclean_pages .menu .page_item.page_item_has_children .page_item > a:hover,
.footer-widget .widget.widget_recent_entries ul > li > a:hover,
.footer-widget .widget.widget_recent_entries ul > li > a:focus,
.author-profile .itemAuthorName
 {
  color: <?php print sanitize_hex_color($color);?>;
}

input::-moz-placeholder,
textarea::-moz-placeholder,
.button::-moz-placeholder,
input:-ms-input-placeholder,
textarea:-ms-input-placeholder,
.button:-ms-input-placeholder,
input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder,
.button::-webkit-input-placeholder{
  color: <?php print sanitize_hex_color($color);?>;
}

.background-secondary,
.btn.btn-primary:hover,
.el-btn a.btn.btn-primary:hover,
.el-btn button.btn.btn-primary:hover,
a.btn.btn-primary:hover,
.btn.btn-skin-primary:hover,
.el-btn a.btn.btn-skin-primary:hover,
.el-btn button.btn.btn-skin-primary:hover,
a.btn.btn-skin-primary:hover,
.btn.btn-primary:focus,
.el-btn a.btn.btn-primary:focus,
.el-btn button.btn.btn-primary:focus,
a.btn.btn-primary:focus,
.btn.btn-skin-primary:focus,
.el-btn a.btn.btn-skin-primary:focus,
.el-btn button.btn.btn-skin-primary:focus,
a.btn.btn-skin-primary:focus,
.btn.btn-secondary,
.el-btn a.btn.btn-secondary,
.el-btn button.btn.btn-secondary,
a.btn.btn-secondary,
.btn.btn-skin-secondary,
.el-btn a.btn.btn-skin-secondary,
.el-btn button.btn.btn-skin-secondary,
a.btn.btn-skin-secondary,
.btn.btn-secondary-thirdy,
.el-btn a.btn.btn-secondary-thirdy,
.el-btn button.btn.btn-secondary-thirdy,
a.btn.btn-secondary-thirdy,
.btn.btn-skin-secondary-thirdy,
.el-btn a.btn.btn-skin-secondary-thirdy,
.el-btn button.btn.btn-skin-secondary-thirdy,
a.btn.btn-skin-secondary-thirdy,
.btn.btn-secondary-outline:hover,
.el-btn a.btn.btn-secondary-outline:hover,
.el-btn button.btn.btn-secondary-outline:hover,
a.btn.btn-secondary-outline:hover,
.btn.btn-skin-secondary-ghost:hover,
.el-btn a.btn.btn-skin-secondary-ghost:hover,
.el-btn button.btn.btn-skin-secondary-ghost:hover,
a.btn.btn-skin-secondary-ghost:hover,
.btn.btn-secondary-outline:focus,
.el-btn a.btn.btn-secondary-outline:focus,
.el-btn button.btn.btn-secondary-outline:focus,
a.btn.btn-secondary-outline:focus,
.btn.btn-skin-secondary-ghost:focus,
.el-btn a.btn.btn-skin-secondary-ghost:focus,
.el-btn button.btn.btn-skin-secondary-ghost:focus,
a.btn.btn-skin-secondary-ghost:focus,
.btn.btn-thirdy-secondary:hover,
.el-btn a.btn.btn-thirdy-secondary:hover,
.el-btn button.btn.btn-thirdy-secondary:hover,
a.btn.btn-thirdy-secondary:hover,
.btn.btn-skin-thirdy-secondary:hover,
.el-btn a.btn.btn-skin-thirdy-secondary:hover,
.el-btn button.btn.btn-skin-thirdy-secondary:hover,
a.btn.btn-skin-thirdy-secondary:hover,
.btn.btn-thirdy-secondary:focus,
.el-btn a.btn.btn-thirdy-secondary:focus,
.el-btn button.btn.btn-thirdy-secondary:focus,
a.btn.btn-thirdy-secondary:focus,
.btn.btn-skin-thirdy-secondary:focus,
.el-btn a.btn.btn-skin-thirdy-secondary:focus,
.el-btn button.btn.btn-skin-thirdy-secondary:focus,
a.btn.btn-skin-thirdy-secondary:focus,
.comment-respond .comment-form .form-submit .button:hover,
.comment-respond .comment-form .form-submit .button:focus,
.woocommerce #respond input#submit:hover, input.woocommerce-button:hover,
input.woocommerce-Button:hover, button.single_add_to_cart_button:hover,
.button.product_type_grouped:hover, .single_add_to_cart_button:hover,
.add_to_cart_button:hover, .button.add_to_cart_button:hover,
.button.product_type_external:hover, button.button.alt:hover,
button.button.alt.disabled:hover, a.woocommerce-button:hover,
a.woocommerce-Button:hover, .woocommerce-button:hover, .woocommerce-Button:hover,
.button.wc-backward:hover, .wc-backward:hover, 
.woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:hover,
.woocommerce #respond input#submit.button:hover, input.woocommerce-button.button:hover,
input.woocommerce-Button.button:hover, button.single_add_to_cart_button.button:hover,
.button.product_type_grouped.button:hover, .single_add_to_cart_button.button:hover,
.add_to_cart_button.button:hover, .button.add_to_cart_button.button:hover,
.button.product_type_external.button:hover, button.button.alt.button:hover,
button.button.alt.disabled.button:hover, a.woocommerce-button.button:hover,
a.woocommerce-Button.button:hover, .woocommerce-button.button:hover,
.woocommerce-Button.button:hover, .button.wc-backward.button:hover,
.wc-backward.button:hover,
.woocommerce #respond input#submit:focus, input.woocommerce-button:focus,
input.woocommerce-Button:focus, button.single_add_to_cart_button:focus,
.button.product_type_grouped:focus, .single_add_to_cart_button:focus,
.add_to_cart_button:focus, .button.add_to_cart_button:focus,
.button.product_type_external:focus, button.button.alt:focus,
button.button.alt.disabled:focus, a.woocommerce-button:focus,
a.woocommerce-Button:focus, .woocommerce-button:focus, .woocommerce-Button:focus,
.button.wc-backward:focus, .wc-backward:focus, 
.woocommerce .wc-proceed-to-checkout a.checkout-button:focus,
.woocommerce #respond input#submit.button:focus,
input.woocommerce-button.button:focus, input.woocommerce-Button.button:focus,
button.single_add_to_cart_button.button:focus, .button.product_type_grouped.button:focus,
.single_add_to_cart_button.button:focus, .add_to_cart_button.button:focus,
.button.add_to_cart_button.button:focus, .button.product_type_external.button:focus,
button.button.alt.button:focus, button.button.alt.disabled.button:focus,
a.woocommerce-button.button:focus, a.woocommerce-Button.button:focus,
.woocommerce-button.button:focus, .woocommerce-Button.button:focus,
.button.wc-backward.button:focus, .wc-backward.button:focus,
.woocommerce-button[disabled].button:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:focus,
.woocommerce-button[disabled]:disabled.button:focus,
.woocommerce input.button:disabled.button:focus,
.woocommerce input.button:disabled[disabled].button:focus,
.woocommerce.widget_shopping_cart .wc-forward:hover,
.woocommerce.widget_shopping_cart .button.wc-forward:hover,
.woocommerce .widget_price_filter .price_slider_amount .button:hover,
.widget_price_filter .price_slider_amount .button:hover,
.post-lists article .blog-image .img-wrapper,
.widget ul > li:before,
.footer-widget .widget .widget-title:after,
.footer-widget .widget .widgettitle:after,
.owl-carousel-container .owl-controls .owl-pagination .owl-page:hover > span,
.owl-carousel-container .owl-controls .owl-pagination .owl-page:focus > span,
.owl-carousel-container .owl-controls .owl-pagination .owl-page.active > span,
.owl-carousel-container .owl-dots .owl-page:hover > span,
.owl-carousel-container .owl-dots .owl-dot:hover > span,
.owl-carousel-container .owl-dots .owl-page:focus > span,
.owl-carousel-container .owl-dots .owl-dot:focus > span,
.owl-carousel-container .owl-dots .owl-page.active > span,
.owl-carousel-container .owl-dots .owl-dot.active > span,
.module-iconboxes.style-6 .line-top:before,
.module-iconboxes.style-6 .line-bottom:before,
.module-iconboxes.style-6 .line-top:after,
.module-iconboxes.style-6 .line-bottom:after,
.module-iconboxes.style-7 .iconboxes-wrap,
.module-iconboxes.style-7 .icon-body .box,
.team_custom .profile figure .top-image:before,
.team_custom .profile-scocial a,
.team_custom.petro,
.widget .widget-title:after,
.widget .widgettitle:after,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.widget_price_filter .ui-slider .ui-slider-handle,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item:focus i,
.gum_portfolio .portfolio-content .portfolio .portfolio-image,
.price-block .price-heading,
.price-block .price-footer,
.price-block.layout-2 .price-footer .btn,
form.search-form .search-ico:hover,
form.search-form .search-ico:focus,
.footer-widget .widget.widget_search form .search-ico,
.footer-widget .widget .tagcloud a:hover, .footer-widget .widget .tagcloud a:focus,
.section-head.heading-decoration .section-main-title:before,
.heading-module .search-form.nav .cart-count,
.youtube_popup .action-panel,
.post-lists.blog-col-2 article .post-meta-info:before,
.post-lists.blog-col-3 article .post-meta-info:before,
.post-lists.blog-col-4 article .post-meta-info:before
{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.woocommerce-button[disabled]:hover,
.woocommerce-button[disabled]:disabled:hover,
.woocommerce input.button:disabled:hover,
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce-button[disabled].button:hover,
.woocommerce-button[disabled]:disabled.button:hover,
.woocommerce input.button:disabled.button:hover,
.woocommerce input.button:disabled[disabled].button:hover,
.woocommerce-button[disabled]:focus,
.woocommerce-button[disabled]:disabled:focus,
.woocommerce input.button:disabled:focus,
.woocommerce input.button:disabled[disabled]:focus
{
  background-color: <?php print sanitize_hex_color($color);?>!important;
}

.border-secondary,
.btn.btn-primary:hover,
.el-btn a.btn.btn-primary:hover,
.el-btn button.btn.btn-primary:hover,
a.btn.btn-primary:hover,
.btn.btn-skin-primary:hover,
.el-btn a.btn.btn-skin-primary:hover,
.el-btn button.btn.btn-skin-primary:hover,
a.btn.btn-skin-primary:hover,
.btn.btn-primary:focus,
.el-btn a.btn.btn-primary:focus,
.el-btn button.btn.btn-primary:focus,
a.btn.btn-primary:focus,
.btn.btn-skin-primary:focus,
.el-btn a.btn.btn-skin-primary:focus,
.el-btn button.btn.btn-skin-primary:focus,
a.btn.btn-skin-primary:focus,
.btn.btn-secondary,
.el-btn a.btn.btn-secondary,
.el-btn button.btn.btn-secondary,
a.btn.btn-secondary,
.btn.btn-skin-secondary,
.el-btn a.btn.btn-skin-secondary,
.el-btn button.btn.btn-skin-secondary,
a.btn.btn-skin-secondary,
.btn.btn-secondary-thirdy,
.el-btn a.btn.btn-secondary-thirdy,
.el-btn button.btn.btn-secondary-thirdy,
a.btn.btn-secondary-thirdy,
.btn.btn-skin-secondary-thirdy,
.el-btn a.btn.btn-skin-secondary-thirdy,
.el-btn button.btn.btn-skin-secondary-thirdy,
a.btn.btn-skin-secondary-thirdy,
.btn.btn-secondary-outline,
.el-btn a.btn.btn-secondary-outline,
.el-btn button.btn.btn-secondary-outline,
a.btn.btn-secondary-outline,
.btn.btn-skin-secondary-ghost,
.el-btn a.btn.btn-skin-secondary-ghost,
.el-btn button.btn.btn-skin-secondary-ghost,
a.btn.btn-skin-secondary-ghost,
.btn.btn-secondary-outline:hover,
.el-btn a.btn.btn-secondary-outline:hover,
.el-btn button.btn.btn-secondary-outline:hover,
a.btn.btn-secondary-outline:hover,
.btn.btn-skin-secondary-ghost:hover,
.el-btn a.btn.btn-skin-secondary-ghost:hover,
.el-btn button.btn.btn-skin-secondary-ghost:hover,
a.btn.btn-skin-secondary-ghost:hover,
.btn.btn-secondary-outline:focus,
.el-btn a.btn.btn-secondary-outline:focus,
.el-btn button.btn.btn-secondary-outline:focus,
a.btn.btn-secondary-outline:focus,
.btn.btn-skin-secondary-ghost:focus,
.el-btn a.btn.btn-skin-secondary-ghost:focus,
.el-btn button.btn.btn-skin-secondary-ghost:focus,
a.btn.btn-skin-secondary-ghost:focus,
.btn.btn-thirdy-secondary:hover,
.el-btn a.btn.btn-thirdy-secondary:hover,
.el-btn button.btn.btn-thirdy-secondary:hover,
a.btn.btn-thirdy-secondary:hover,
.btn.btn-skin-thirdy-secondary:hover,
.el-btn a.btn.btn-skin-thirdy-secondary:hover,
.el-btn button.btn.btn-skin-thirdy-secondary:hover,
a.btn.btn-skin-thirdy-secondary:hover,
.btn.btn-thirdy-secondary:focus,
.el-btn a.btn.btn-thirdy-secondary:focus,
.el-btn button.btn.btn-thirdy-secondary:focus,
a.btn.btn-thirdy-secondary:focus,
.btn.btn-skin-thirdy-secondary:focus,
.el-btn a.btn.btn-skin-thirdy-secondary:focus,
.el-btn button.btn.btn-skin-thirdy-secondary:focus,
a.btn.btn-skin-thirdy-secondary:focus,
.woocommerce #respond input#submit:hover, input.woocommerce-button:hover,
input.woocommerce-Button:hover, button.single_add_to_cart_button:hover,
.button.product_type_grouped:hover, .single_add_to_cart_button:hover,
.add_to_cart_button:hover, .button.add_to_cart_button:hover,
.button.product_type_external:hover, button.button.alt:hover,
button.button.alt.disabled:hover, a.woocommerce-button:hover,
a.woocommerce-Button:hover, .woocommerce-button:hover, .woocommerce-Button:hover,
.button.wc-backward:hover, .wc-backward:hover,
.woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce #respond input#submit.button:hover, input.woocommerce-button.button:hover,
input.woocommerce-Button.button:hover, button.single_add_to_cart_button.button:hover,
.button.product_type_grouped.button:hover, .single_add_to_cart_button.button:hover,
.add_to_cart_button.button:hover, .button.add_to_cart_button.button:hover,
.button.product_type_external.button:hover, button.button.alt.button:hover,
button.button.alt.disabled.button:hover, a.woocommerce-button.button:hover,
a.woocommerce-Button.button:hover, .woocommerce-button.button:hover,
.woocommerce-Button.button:hover, .button.wc-backward.button:hover,
.wc-backward.button:hover, 
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:hover,
.woocommerce #respond input#submit:focus, input.woocommerce-button:focus,
input.woocommerce-Button:focus, button.single_add_to_cart_button:focus,
.button.product_type_grouped:focus, .single_add_to_cart_button:focus,
.add_to_cart_button:focus, .button.add_to_cart_button:focus,
.button.product_type_external:focus, button.button.alt:focus,
button.button.alt.disabled:focus, a.woocommerce-button:focus,
a.woocommerce-Button:focus, .woocommerce-button:focus, .woocommerce-Button:focus,
.button.wc-backward:focus, .wc-backward:focus, 
.woocommerce .wc-proceed-to-checkout a.checkout-button:focus,
.woocommerce #respond input#submit.button:focus,
input.woocommerce-button.button:focus, input.woocommerce-Button.button:focus,
button.single_add_to_cart_button.button:focus, .button.product_type_grouped.button:focus,
.single_add_to_cart_button.button:focus, .add_to_cart_button.button:focus,
.button.add_to_cart_button.button:focus, .button.product_type_external.button:focus,
button.button.alt.button:focus, button.button.alt.disabled.button:focus,
a.woocommerce-button.button:focus, a.woocommerce-Button.button:focus,
.woocommerce-button.button:focus, .woocommerce-Button.button:focus,
.button.wc-backward.button:focus, .wc-backward.button:focus,
.woocommerce .wc-proceed-to-checkout a.checkout-button.button:focus,
.woocommerce.widget_shopping_cart .wc-forward:hover,
.woocommerce.widget_shopping_cart .button.wc-forward:hover,
.woocommerce .widget_price_filter .price_slider_amount .button:hover,
.widget_price_filter .price_slider_amount .button:hover,
.woo-variation-swatches-stylesheet-enabled .variable-items-wrapper .variable-item:not(.radio-variable-item).selected,
.woo-variation-swatches-stylesheet-enabled .variable-items-wrapper .variable-item:not(.radio-variable-item):hover,
.widget.soclean_widget_social .social-icon-lists.skin-secondary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-primary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item:focus i,
.widget.soclean_widget_social .social-icon-lists.skin-secondary-ghost .social-item i,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:hover,
.owl-carousel-container .owl-custom-pagination.navigation .btn-owl:focus,
form.search-form .search-ico:hover,
form.search-form .search-ico:focus,
.footer-widget .widget.widget_search form .search-ico,
.footer-widget .widget .tagcloud a:hover, .footer-widget .widget .tagcloud a:focus,
.footer-widget .widget.superclean_nav_menu > ul > li:hover > a,
.footer-widget .widget.widget_superclean_pages > ul > li:hover > a,
.footer-widget .widget.superclean_nav_menu .menu > li:hover > a,
.footer-widget .widget.widget_superclean_pages .menu > li:hover > a,
.footer-widget .widget.superclean_nav_menu > ul > li:focus > a,
.footer-widget .widget.widget_superclean_pages > ul > li:focus > a,
.footer-widget .widget.superclean_nav_menu .menu > li:focus > a,
.footer-widget .widget.widget_superclean_pages .menu > li:focus > a,
.footer-widget .widget.superclean_nav_menu > ul > li.active > a,
.footer-widget .widget.widget_superclean_pages > ul > li.active > a,
.footer-widget .widget.superclean_nav_menu .menu > li.active > a,
.footer-widget .widget.widget_superclean_pages .menu > li.active > a,
.footer-widget .widget.widget_nav_menu > ul > .menu-item:hover > a,
.footer-widget .widget.widget_pages > ul > .menu-item:hover > a,
.footer-widget .widget.widget_nav_menu .menu > .menu-item:hover > a,
.footer-widget .widget.widget_pages .menu > .menu-item:hover > a,
.footer-widget .widget.widget_nav_menu > ul > .page_item:hover > a,
.footer-widget .widget.widget_pages > ul > .page_item:hover > a,
.footer-widget .widget.widget_nav_menu .menu > .page_item:hover > a,
.footer-widget .widget.widget_pages .menu > .page_item:hover > a,
.footer-widget .widget.widget_nav_menu > ul > li:hover > a,
.footer-widget .widget.widget_pages > ul > li:hover > a,
.footer-widget .widget.widget_nav_menu .menu > li:hover > a,
.footer-widget .widget.widget_pages .menu > li:hover > a,
.footer-widget .widget.widget_nav_menu > ul > .menu-item:focus > a,
.footer-widget .widget.widget_pages > ul > .menu-item:focus > a,
.footer-widget .widget.widget_nav_menu .menu > .menu-item:focus > a,
.footer-widget .widget.widget_pages .menu > .menu-item:focus > a,
.footer-widget .widget.widget_nav_menu > ul > .page_item:focus > a,
.footer-widget .widget.widget_pages > ul > .page_item:focus > a,
.footer-widget .widget.widget_nav_menu .menu > .page_item:focus > a,
.footer-widget .widget.widget_pages .menu > .page_item:focus > a,
.footer-widget .widget.widget_nav_menu > ul > li:focus > a,
.footer-widget .widget.widget_pages > ul > li:focus > a,
.footer-widget .widget.widget_nav_menu .menu > li:focus > a,
.footer-widget .widget.widget_pages .menu > li:focus > a,
.footer-widget .widget.widget_nav_menu > ul > .menu-item.active > a,
.footer-widget .widget.widget_pages > ul > .menu-item.active > a,
.footer-widget .widget.widget_nav_menu .menu > .menu-item.active > a,
.footer-widget .widget.widget_pages .menu > .menu-item.active > a,
.footer-widget .widget.widget_nav_menu > ul > .page_item.active > a,
.footer-widget .widget.widget_pages > ul > .page_item.active > a,
.footer-widget .widget.widget_nav_menu .menu > .page_item.active > a,
.footer-widget .widget.widget_pages .menu > .page_item.active > a,
.footer-widget .widget.widget_nav_menu > ul > li.active > a,
.footer-widget .widget.widget_pages > ul > li.active > a,
.footer-widget .widget.widget_nav_menu .menu > li.active > a,
.footer-widget .widget.widget_pages .menu > li.active > a,
.footer-widget .widget.widget_meta > ul > li:hover > a,
.footer-widget .widget.widget_archive > ul > li:hover > a,
.footer-widget .widget.widget_categories > ul > li:hover > a,
.footer-widget .widget.widget_product_categories > ul > li:hover > a,
.footer-widget .widget.widget_meta > ul > li:focus > a,
.footer-widget .widget.widget_archive > ul > li:focus > a,
.footer-widget .widget.widget_categories > ul > li:focus > a,
.footer-widget .widget.widget_product_categories > ul > li:focus > a,
.footer-widget .widget.widget_meta > ul > li.active > a,
.footer-widget .widget.widget_archive > ul > li.active > a,
.footer-widget .widget.widget_categories > ul > li.active > a,
.footer-widget .widget.widget_product_categories > ul > li.active > a
{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.form-control:focus {
    -webkit-box-shadow: 0 0 0 2px <?php print sanitize_hex_color($color);?>;
    box-shadow: 0 0 0 2px <?php print sanitize_hex_color($color);?>;
    border-color: <?php print sanitize_hex_color($color);?>;
}


.woocommerce-button[disabled]:hover,
.woocommerce-button[disabled]:disabled:hover,
.woocommerce input.button:disabled:hover,
.woocommerce input.button:disabled[disabled]:hover,
.woocommerce-button[disabled].button:hover,
.woocommerce-button[disabled]:disabled.button:hover,
.woocommerce input.button:disabled.button:hover,
.woocommerce input.button:disabled[disabled].button:hover,
.woocommerce-button[disabled]:focus,
.woocommerce-button[disabled]:disabled:focus,
.woocommerce input.button:disabled:focus,
.woocommerce input.button:disabled[disabled]:focus
{
  border-color: <?php print sanitize_hex_color($color);?>!important;
}

.team_custom.petro{
  border-bottom-color: <?php print sanitize_hex_color($color);?>;
}

@media (max-width: 768px){
  .heading-module .search-form .navbar-form .search-field {
      border-color: <?php print sanitize_hex_color($color);?>;
  }
}
<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_secondary_color');


function lapindos_change_third_color($config=array()){

  $color= isset($config['third_color']) ? trim($config['third_color']) :  "";

  if(empty($color) || '#eeeeee'== strtolower($color)) return;

  ?>
.text-third,
.color-third,
.btn.btn-thirdy-ghost,
.el-btn a.btn.btn-thirdy-ghost,
.el-btn button.btn.btn-thirdy-ghost,
a.btn.btn-thirdy-ghost,
.btn.btn-skin-thirdy-ghost,
.el-btn a.btn.btn-skin-thirdy-ghost,
.el-btn button.btn.btn-skin-thirdy-ghost,
a.btn.btn-skin-thirdy-ghost,
.social-icons .search-btn:hover,
.post-meta-info dd > i,
.widget.widget_recent_entries > ul > li .post-date,
.btn-info .badge,
a.btn-info .badge,
.nuno-slide .slides-navigation a:hover,
.nuno-slide .slides-navigation a:focus,
.module-iconboxes .box i,
.module-iconboxes.style-7 .box-heading,
.team_custom .profile-subheading,
.team_custom.petro .profile-scocial a:hover,
.team_custom.petro .profile-scocial a:focus,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item i,
.price-block.popular .price-footer .btn:hover,
.price-block.popular .price-footer .btn:focus  {
  color: <?php print sanitize_hex_color($color);?>;
}

.responsive_tab .panel-heading:hover,
.responsive_tab .panel-heading:hover a,
.responsive_tab .nav-tabs li:hover > a {
  color: <?php print sanitize_hex_color($color);?> !important;
}

.background-third,
.btn.btn-primary-thirdy:hover,
.el-btn a.btn.btn-primary-thirdy:hover,
.el-btn button.btn.btn-primary-thirdy:hover,
a.btn.btn-primary-thirdy:hover,
.btn.btn-skin-primary-thirdy:hover,
.el-btn a.btn.btn-skin-primary-thirdy:hover,
.el-btn button.btn.btn-skin-primary-thirdy:hover,
a.btn.btn-skin-primary-thirdy:hover,
.btn.btn-primary-thirdy:focus,
.el-btn a.btn.btn-primary-thirdy:focus,
.el-btn button.btn.btn-primary-thirdy:focus,
a.btn.btn-primary-thirdy:focus,
.btn.btn-skin-primary-thirdy:focus,
.el-btn a.btn.btn-skin-primary-thirdy:focus,
.el-btn button.btn.btn-skin-primary-thirdy:focus,
a.btn.btn-skin-primary-thirdy:focus,
.btn.btn-thirdy,
.el-btn a.btn.btn-thirdy,
.el-btn button.btn.btn-thirdy,
a.btn.btn-thirdy,
.btn.btn-skin-thirdy,
.el-btn a.btn.btn-skin-thirdy,
.el-btn button.btn.btn-skin-thirdy,
a.btn.btn-skin-thirdy,
.btn.btn-thirdy-secondary,
.el-btn a.btn.btn-thirdy-secondary,
.el-btn button.btn.btn-thirdy-secondary,
a.btn.btn-thirdy-secondary,
.btn.btn-skin-thirdy-secondary,
.el-btn a.btn.btn-skin-thirdy-secondary,
.el-btn button.btn.btn-skin-thirdy-secondary,
a.btn.btn-skin-thirdy-secondary,
.btn.btn-thirdy-ghost:hover,
.el-btn a.btn.btn-thirdy-ghost:hover,
.el-btn button.btn.btn-thirdy-ghost:hover,
a.btn.btn-thirdy-ghost:hover,
.btn.btn-skin-thirdy-ghost:hover,
.el-btn a.btn.btn-skin-thirdy-ghost:hover,
.el-btn button.btn.btn-skin-thirdy-ghost:hover,
a.btn.btn-skin-thirdy-ghost:hover,
.btn.btn-thirdy-ghost:focus,
.el-btn a.btn.btn-thirdy-ghost:focus,
.el-btn button.btn.btn-thirdy-ghost:focus,
a.btn.btn-thirdy-ghost:focus,
.btn.btn-skin-thirdy-ghost:focus,
.el-btn a.btn.btn-skin-thirdy-ghost:focus,
.el-btn button.btn.btn-skin-thirdy-ghost:focus,
a.btn.btn-skin-thirdy-ghost:focus,
.module-iconboxes:hover .iconboxes-wrap,
.module-iconboxes.style-7:hover,
.module-iconboxes.style-7:hover .box,
.module-iconboxes.style-7:hover .iconboxes-wrap,
.team_custom .profile-scocial a:hover,
.team_custom.nuno-lite .profile figure figcaption .profile-heading,
.team_custom.petro:hover,
.team_custom.petro:focus,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item:focus i,
.price-block.popular .price-heading,
.price-block.popular .price-footer{
  background-color: <?php print sanitize_hex_color($color);?>;
}

.border-third,
.btn.btn-primary-thirdy:hover,
.el-btn a.btn.btn-primary-thirdy:hover,
.el-btn button.btn.btn-primary-thirdy:hover,
a.btn.btn-primary-thirdy:hover,
.btn.btn-skin-primary-thirdy:hover,
.el-btn a.btn.btn-skin-primary-thirdy:hover,
.el-btn button.btn.btn-skin-primary-thirdy:hover,
a.btn.btn-skin-primary-thirdy:hover,
.btn.btn-primary-thirdy:focus,
.el-btn a.btn.btn-primary-thirdy:focus,
.el-btn button.btn.btn-primary-thirdy:focus,
a.btn.btn-primary-thirdy:focus,
.btn.btn-skin-primary-thirdy:focus,
.el-btn a.btn.btn-skin-primary-thirdy:focus,
.el-btn button.btn.btn-skin-primary-thirdy:focus,
a.btn.btn-skin-primary-thirdy:focus,
.btn.btn-thirdy,
.el-btn a.btn.btn-thirdy,
.el-btn button.btn.btn-thirdy,
a.btn.btn-thirdy,
.btn.btn-skin-thirdy,
.el-btn a.btn.btn-skin-thirdy,
.el-btn button.btn.btn-skin-thirdy,
a.btn.btn-skin-thirdy,
.btn.btn-thirdy-secondary,
.el-btn a.btn.btn-thirdy-secondary,
.el-btn button.btn.btn-thirdy-secondary,
a.btn.btn-thirdy-secondary,
.btn.btn-skin-thirdy-secondary,
.el-btn a.btn.btn-skin-thirdy-secondary,
.el-btn button.btn.btn-skin-thirdy-secondary,
a.btn.btn-skin-thirdy-secondary,
.btn.btn-thirdy-ghost,
.el-btn a.btn.btn-thirdy-ghost,
.el-btn button.btn.btn-thirdy-ghost,
a.btn.btn-thirdy-ghost,
.btn.btn-skin-thirdy-ghost,
.el-btn a.btn.btn-skin-thirdy-ghost,
.el-btn button.btn.btn-skin-thirdy-ghost,
a.btn.btn-skin-thirdy-ghost,
.btn.btn-thirdy-ghost:hover,
.el-btn a.btn.btn-thirdy-ghost:hover,
.el-btn button.btn.btn-thirdy-ghost:hover,
a.btn.btn-thirdy-ghost:hover,
.btn.btn-skin-thirdy-ghost:hover,
.el-btn a.btn.btn-skin-thirdy-ghost:hover,
.el-btn button.btn.btn-skin-thirdy-ghost:hover,
a.btn.btn-skin-thirdy-ghost:hover,
.btn.btn-thirdy-ghost:focus,
.el-btn a.btn.btn-thirdy-ghost:focus,
.el-btn button.btn.btn-thirdy-ghost:focus,
a.btn.btn-thirdy-ghost:focus,
.btn.btn-skin-thirdy-ghost:focus,
.el-btn a.btn.btn-skin-thirdy-ghost:focus,
.el-btn button.btn.btn-skin-thirdy-ghost:focus,
a.btn.btn-skin-thirdy-ghost:focus,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-secondary .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item:hover i,
.widget.soclean_widget_social .social-icon-lists.skin-thirdy-ghost .social-item:focus i,
.nuno-slide .slides-navigation a:hover,
.nuno-slide .slides-navigation a:focus,
.gum_portfolio .portfolio-content .portfolio .image-overlay-container
{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.team_custom.petro:hover,
.team_custom.petro:focus{
  border-bottom-color: <?php print sanitize_hex_color($color);?>;  
}


<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_third_color');

/* heading color */
function lapindos_change_heading_color($config=array()){

  $color= isset($config['heading_color']) ? trim($config['heading_color']) :  "";

  if(empty($color) || '#333333'== strtolower($color)) return;
  ?>
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6,.heading-color
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_heading_color');

/* link color */
function lapindos_change_link_color($config=array()){

  $color= isset($config['link-color']) ? trim($config['link-color']) :  "";

  if($color=='' || '#2e96db'== strtolower($color)) return;
  ?>
.link-color,
.woocommerce.single-product .product_meta .sku,
.page-pagination .page-numbers,
.pagination li .page-numbers,
.pagination li .page-numbers:visited,
.pagination li .page-numbers:active,
.lb-details .lb-title,
.woocommerce .products li.product .price,
.woocommerce ul.products li.product .price,
.products li.product .price,
.woocommerce.single-product div.product .price,
.woocommerce.single-product div.product p.price,
.woocommerce.single-product div.product span.price,
a,
.btn-link{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_link_color');

/* link hover color */
function lapindos_change_link_hover_color($config=array()){

  $color= isset($config['link-hover-color']) ? trim($config['link-hover-color']) :  "";

  if($color=='' || '#1f7ab7'== strtolower($color)) return;
  ?>
a:hover,
.btn-link:hover
{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
}

add_action( 'lapindos_change_style', 'lapindos_change_link_hover_color');

/*  page heading color */
function lapindos_change_page_heading_color($config=array()){

  $color= isset($config['heading-background-color']) ? $config['heading-background-color'] :  array();

  $bgcolor = wp_parse_args($color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor_rgba!='' && ('#212635' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '0.1')){?>
.page-heading,
.page-heading .top-heading{
  background-color: <?php print $bgcolor_rgba;?>;
}
<?php
  }

  $color = isset($config['page-title-color']) ? trim($config['page-title-color']) :  "";

  if($color!='' && '#333333' != strtolower($color)) {
  ?>
.page-heading,
.page-heading .custom-page-title .page-title,
.page-heading .custom-page-title .category-label,
.page-heading .custom-page-title .search-name{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  }

  $breadcrumb_color= isset($config['breadcrumb-color']) ? trim($config['breadcrumb-color']) :  "";
  $breadcrumb_link_color= isset($config['breadcrumb-link-color']) ? trim($config['breadcrumb-link-color']) :  "";

  if($breadcrumb_color !='' && '#333333'!= strtolower($breadcrumb_color)) {
?>
  .page-heading .breadcrumb > li{
    color: <?php print sanitize_hex_color($breadcrumb_color);?>;
  }
<?php
  }

  if($breadcrumb_link_color !='' && '#333333'!= strtolower($breadcrumb_link_color)) {
?>
  .page-heading .breadcrumb > li a{
    color: <?php print sanitize_hex_color($breadcrumb_link_color);?>;
  }
<?php
  }

}

add_action( 'lapindos_change_style', 'lapindos_change_page_heading_color');


/* background color */
function lapindos_background_change_bgcolor($config=array()){

  $bg_bgcolor= isset($config['background-color']) ? $config['background-color'] :  "";
  $bg_bgcolor = wp_parse_args($bg_bgcolor,array('color'=>'','alpha'=>'','rgba'=>''));

  $content_bgcolor_rgba = !empty($bg_bgcolor['rgba']) ? $bg_bgcolor['rgba'] : "";
  $content_bgcolor_hex = !empty($bg_bgcolor['color']) ? $bg_bgcolor['color'] : "";

  if(!empty($content_bgcolor_hex) && ('#ffffff' != strtolower($content_bgcolor_hex) || $bg_bgcolor['alpha']!='1')):
  
  ?>
  body{
    background-color: <?php print $content_bgcolor_rgba;?>;
  }
<?php
  endif;

  $bg_bgcolor= isset($config['content-background']) ? $config['content-background'] :  "";
  $bg_bgcolor = wp_parse_args($bg_bgcolor,array('color'=>'','alpha'=>'','rgba'=>''));


  $content_bgcolor_rgba = !empty($bg_bgcolor['rgba']) ? $bg_bgcolor['rgba'] : "";
  $content_bgcolor_hex = !empty($bg_bgcolor['color']) ? $bg_bgcolor['color'] : "";

  if(!empty($content_bgcolor_hex) && ('#ffffff' != strtolower($content_bgcolor_hex) || $bg_bgcolor['alpha']!='1')):?>
  .page-heading.fixed + .main-content,
  .page-heading.fixed + .footer-text,
  .page-heading.fixed + .footer-widget,
  .page-heading.fixed + .footer-copyright,
  .main-container,
  .form-control{
    background-color: <?php print $content_bgcolor_rgba;?>;
  }

  .btn.btn-default:hover,
  .el-btn a.btn.btn-default:hover,
  .el-btn button.btn.btn-default:hover,
  a.btn.btn-default:hover,
  .btn.btn-skin-default:hover,
  .el-btn a.btn.btn-skin-default:hover,
  .el-btn button.btn.btn-skin-default:hover,
  a.btn.btn-skin-default:hover,
  .btn.btn-default:focus,
  .el-btn a.btn.btn-default:focus,
  .el-btn button.btn.btn-default:focus,
  a.btn.btn-default:focus,
  .btn.btn-skin-default:focus,
  .el-btn a.btn.btn-skin-default:focus,
  .el-btn button.btn.btn-skin-default:focus,
  a.btn.btn-skin-default:focus,
  .btn.btn-default-outline,
  .el-btn a.btn.btn-default-outline,
  .el-btn button.btn.btn-default-outline,
  a.btn.btn-default-outline,
  .btn.btn-skin-default-ghost,
  .el-btn a.btn.btn-skin-default-ghost,
  .el-btn button.btn.btn-skin-default-ghost,
  a.btn.btn-skin-default-ghost{
    background-color: <?php print $content_bgcolor_hex;?>;
  }

  .btn.btn-default,
  .el-btn a.btn.btn-default,
  .el-btn button.btn.btn-default,
  a.btn.btn-default,
  .btn.btn-skin-default,
  .el-btn a.btn.btn-skin-default,
  .el-btn button.btn.btn-skin-default,
  a.btn.btn-skin-default,
  .btn.btn-primary,
  .el-btn a.btn.btn-primary,
  .el-btn button.btn.btn-primary,
  a.btn.btn-primary,
  .btn.btn-primary-thirdy,
  .el-btn a.btn.btn-primary-thirdy,
  .el-btn button.btn.btn-primary-thirdy,
  a.btn.btn-primary-thirdy,
  .btn.btn-skin-primary,
  .el-btn a.btn.btn-skin-primary,
  .el-btn button.btn.btn-skin-primary,
  a.btn.btn-skin-primary,
  .btn.btn-skin-primary-thirdy,
  .el-btn a.btn.btn-skin-primary-thirdy,
  .el-btn button.btn.btn-skin-primary-thirdy,
  a.btn.btn-skin-primary-thirdy,
  .btn.btn-secondary:hover,
  .el-btn a.btn.btn-secondary:hover,
  .el-btn button.btn.btn-secondary:hover,
  a.btn.btn-secondary:hover,
  .btn.btn-skin-secondary:hover,
  .el-btn a.btn.btn-skin-secondary:hover,
  .el-btn button.btn.btn-skin-secondary:hover,
  a.btn.btn-skin-secondary:hover,
  .btn.btn-secondary:focus,
  .el-btn a.btn.btn-secondary:focus,
  .el-btn button.btn.btn-secondary:focus,
  a.btn.btn-secondary:focus,
  .btn.btn-skin-secondary:focus,
  .el-btn a.btn.btn-skin-secondary:focus,
  .el-btn button.btn.btn-skin-secondary:focus,
  a.btn.btn-skin-secondary:focus,
  .btn.btn-thirdy:hover,
  .el-btn a.btn.btn-thirdy:hover,
  .el-btn button.btn.btn-thirdy:hover,
  a.btn.btn-thirdy:hover,
  .btn.btn-skin-thirdy:hover,
  .el-btn a.btn.btn-skin-thirdy:hover,
  .el-btn button.btn.btn-skin-thirdy:hover,
  a.btn.btn-skin-thirdy:hover,
  .btn.btn-thirdy:focus,
  .el-btn a.btn.btn-thirdy:focus,
  .el-btn button.btn.btn-thirdy:focus,
  a.btn.btn-thirdy:focus,
  .btn.btn-skin-thirdy:focus,
  .el-btn a.btn.btn-skin-thirdy:focus,
  .el-btn button.btn.btn-skin-thirdy:focus,
  a.btn.btn-skin-thirdy:focus{
    color: <?php print $content_bgcolor_hex;?>;
  }

  .btn.btn-default-outline:hover,
  .el-btn a.btn.btn-default-outline:hover,
  .el-btn button.btn.btn-default-outline:hover,
  a.btn.btn-default-outline:hover,
  .btn.btn-skin-default-ghost:hover,
  .el-btn a.btn.btn-skin-default-ghost:hover,
  .el-btn button.btn.btn-skin-default-ghost:hover,
  a.btn.btn-skin-default-ghost:hover,
  .btn.btn-default-outline:focus,
  .el-btn a.btn.btn-default-outline:focus,
  .el-btn button.btn.btn-default-outline:focus,
  a.btn.btn-default-outline:focus,
  .btn.btn-skin-default-ghost:focus,
  .el-btn a.btn.btn-skin-default-ghost:focus,
  .el-btn button.btn.btn-skin-default-ghost:focus,
  a.btn.btn-skin-default-ghost:focus,
  .btn.btn-primary-outline:hover,
  .el-btn a.btn.btn-primary-outline:hover,
  .el-btn button.btn.btn-primary-outline:hover,
  a.btn.btn-primary-outline:hover,
  .btn.btn-skin-primary-outline:hover,
  .el-btn a.btn.btn-skin-primary-outline:hover,
  .el-btn button.btn.btn-skin-primary-outline:hover,
  a.btn.btn-skin-primary-outline:hover,
  .btn.btn-skin-primary-ghost:hover,
  .el-btn a.btn.btn-skin-primary-ghost:hover,
  .el-btn button.btn.btn-skin-primary-ghost:hover,
  a.btn.btn-skin-primary-ghost:hover,
  .btn.btn-primary-outline:focus,
  .el-btn a.btn.btn-primary-outline:focus,
  .el-btn button.btn.btn-primary-outline:focus,
  a.btn.btn-primary-outline:focus,
  .btn.btn-skin-primary-outline:focus,
  .el-btn a.btn.btn-skin-primary-outline:focus,
  .el-btn button.btn.btn-skin-primary-outline:focus,
  a.btn.btn-skin-primary-outline:focus,
  .btn.btn-skin-primary-ghost:focus,
  .el-btn a.btn.btn-skin-primary-ghost:focus,
  .el-btn button.btn.btn-skin-primary-ghost:focus,
  a.btn.btn-skin-primary-ghost:focus{
    color: <?php print $content_bgcolor_hex;?>!important;
  }

  blockquote{
    background-color: <?php print lapindos_darken($content_bgcolor_hex,5);?>;
  }
<?php
  endif;  
}

add_action( 'lapindos_change_style', 'lapindos_background_change_bgcolor');


// widget area bottom-widget-bgcolor
function lapindos_widgetarea_change_color($config=array()){

  $bg_color= isset($config['bottom-widget-bgcolor']) ? $config['bottom-widget-bgcolor'] :  array();
  $color= isset($config['bottom-widget-color']) ? trim($config['bottom-widget-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-widget,
.footer-widget a,
.footer-widget .widget ul > li a,
.footer-widget .widget.widget_recent_entries ul > li > a,
.footer-widget .widget.widget_nav_menu ul li.menu-item > a,
.footer-widget .widget.widget_calendar #wp-calendar #today,
.footer-widget .widget.widget_calendar table #today,
.footer-widget .widget.widget_calendar #wp-calendar #today a,
.footer-widget .widget.widget_calendar table #today a,
.footer-widget .widget.widget_calendar #wp-calendar caption,
.footer-widget .widget.widget_calendar table caption,
.footer-widget .widget .widget-title,
.footer-widget .widget .widgettitle
{
  color: <?php print sanitize_hex_color($color);?>;
}

.footer-widget .widget.widget_calendar #wp-calendar #today,
.footer-widget .widget.widget_calendar table #today{
  border-color: <?php print sanitize_hex_color($color);?>;
}

.footer-widget .widget ul > li::before {
  background-color: <?php print sanitize_hex_color($color);?>;  
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));

  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if($bgcolor_rgba!='' && ('#2e96db' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-widget:not(.no-padding),
  .footer-widget .widget.widget_calendar #wp-calendar #today,
  .footer-widget .widget.widget_calendar table #today{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-text + .footer-widget{
    border-top-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-widget hr,.footer-widget .widget-title, .footer-widget .widgettitle{
    border-top-color: <?php print lapindos_lighten($bgcolor_hex, 10);?>;
  }
<?php endif;
}

add_action( 'lapindos_change_style', 'lapindos_widgetarea_change_color');


// pree footer

function lapindos_pree_footer_change_color($config=array()){

  $bg_color= isset($config['prefooter-bgcolor']) ? $config['prefooter-bgcolor'] :  array();
  $color= isset($config['prefooter-color']) ? trim($config['prefooter-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-text, .footer-text a{
  color: <?php print sanitize_hex_color($color);?>;
}

.footer-text .widget .tagcloud a{
  border-color: <?php print sanitize_hex_color($color);?>;
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));
  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#2e96db' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-text{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-text .widget.trainer_widget_social .social-item i{
    background-color: <?php print lapindos_lighten($bgcolor_hex, 20);?>;
  }

  .footer-text,
  .footer-text hr{
    border-top-color: <?php print lapindos_lighten($bgcolor_hex, 10);?>;
  } 

  <?php endif;
}


add_action( 'lapindos_change_style', 'lapindos_pree_footer_change_color');

// footer copyright

function lapindos_footer_change_color($config=array()){

  $bg_color= isset($config['footer-bgcolor']) ? $config['footer-bgcolor'] :  array();
  $color= isset($config['footer-text-color']) ? trim($config['footer-text-color']) : "";

  if(!empty($color) && '#ffffff'!= strtolower($color)):?>
.footer-copyright, .footer-copyright a{
  color: <?php print sanitize_hex_color($color);?>;
}
<?php
  endif;

  $bgcolor = wp_parse_args($bg_color,array('color'=>'','alpha'=>'','rgba'=>''));
  $bgcolor_rgba = !empty($bgcolor['rgba']) ? $bgcolor['rgba'] : "";
  $bgcolor_hex = !empty($bgcolor['color']) ? $bgcolor['color'] : "transparent";

  if(!empty($bgcolor['color']) && ('#356a9c' != strtolower($bgcolor_hex) || $bgcolor['alpha'] != '1')):?>
  .footer-copyright{
    background-color: <?php print $bgcolor_rgba;?>;
  }

  .footer-copyright,
  .footer-copyright hr{
    border-top-color: <?php print lapindos_lighten($bgcolor_hex, 10);?>;
  } 

  <?php endif;
}


add_action( 'lapindos_change_style', 'lapindos_footer_change_color');


// slidingbar

function lapindos_slidingbar_style($config=array()){

  $bg_color= isset($config['slidingbar_bg']) ? $config['slidingbar_bg'] :  array();

  if($bg_color!='' && '#ffffff'!= strtolower($bg_color)):?>
.slide-sidebar-container{
  background-color: <?php print sanitize_hex_color($bg_color);?>;
}

<?php
  endif;

  $overlay = isset($config['sliding_overlay']) ? $config['sliding_overlay'] :  '';

  if($overlay!=''){?>
.slide-sidebar-overlay{background: rgba(0, 0, 0, <?php print absint($overlay)/20;?>);}
<?php
  }

  $toggle_styles = array();


  $color = isset($config['toggle-slide-color']) ? $config['toggle-slide-color'] : array();
  $color = wp_parse_args($color,array('regular'=>'','hover'=>''));
  $size= isset($config['sliding_size']) ? trim($config['sliding_size']) : "";

  if($color['regular']!=''){
    $toggle_styles['color'] = 'color:'.sanitize_hex_color($color['regular']);
  }

  if($size!=''){
    $toggle_styles['size'] = 'font-size:'.absint($size)."px";
  }

  if(count($toggle_styles)){?>
.heading-module .slide-bar{<?php print join(';', $toggle_styles); ?>}
<?php }

  if($color['hover']!=''){?>
.heading-module .slide-bar:hover{ color:<?php print sanitize_hex_color($color['hover']);?>}
<?php  }


}


add_action( 'lapindos_change_style', 'lapindos_slidingbar_style');

/* body font family */
function lapindos_body_font_family($config=array()){

  $font_family= isset($config['body-font']['font-family']) ? $config['body-font']['font-family'] :  "";
  $font_size= isset($config['body-font']['font-size']) ? intval($config['body-font']['font-size']) :  "";
  $line_height= isset($config['body-font']['line-height']) ? trim($config['body-font']['line-height']) :  "";
  $letter_spacing= isset($config['body-font']['letter-spacing']) ? trim($config['body-font']['letter-spacing']) :  "";
  $font_weight= isset($config['body-font']['font-weight']) ? trim($config['body-font']['font-weight']) :  "";

  $style = "";

  if(!empty($font_family) && !preg_match('/poppins/i', $font_family ) ) {
    print 'html, body,body.single,.body-font,.section-main-title.body-font,.sub-title.body-font,.sub-heading.body-font{font-family: '.$font_family.';}';
  }
  if($font_size!='') {
    $style .= 'font-size: '.absint($font_size).'px;';
  }
  if(!empty($letter_spacing) && $letter_spacing!='px' && $letter_spacing!='pt') {
    $style .= 'letter-spacing: '.absint($letter_spacing).'px;';
  }

  if($font_weight!='') {
    $style .= 'font-weight: '.absint($font_weight).';';
  }

  if($line_height!=''):

        $font_size = $font_size!='' ? $font_size : 15;
        $line_height= absint($line_height) / $font_size;

    $style .= 'line-height: '.$line_height.';';

  endif;

  if($style !=''){
    print 'body,body.single{'.esc_js($style).'}';
  }

}

add_action( 'lapindos_change_style', 'lapindos_body_font_family');

/* heading font family */
function lapindos_heading_font_family($config=array()){

  $font_family= isset($config['heading-font']['font-family']) ? $config['heading-font']['font-family'] :  "";

  $line_height= isset($config['heading-font']['line-height']) ? absint($config['heading-font']['line-height']) :  "";
  $letter_spacing= isset($config['heading-font']['letter-spacing']) ? trim($config['heading-font']['letter-spacing']) :  "";
  $font_weight= isset($config['heading-font']['font-weight']) ? trim($config['heading-font']['font-weight']) :  "";
  $font_size= isset($config['body-font']['font-size']) ? intval($config['body-font']['font-size']) :  "";

  $style="";

  if(!empty($font_family) && !preg_match('/poppins/i', $font_family ) ) {?>
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6,
.heading-font,.sub-title.heading-font,
.sub-heading.heading-font,
.content-comments .comment-list .comment-body .comment-author,
.widget .widget-title,
.widget .widgettitle,
.single-tg_custom_post .portfolio-meta-info .meta label,
.single-superclean_service .portfolio-meta-info .meta label{
  font-family: <?php print $font_family;?>;
}
<?php  }


  if(!empty($letter_spacing) && $letter_spacing!='px' && $letter_spacing!='pt') {
    $style.= 'letter-spacing: '.absint($letter_spacing).'px;';
  }


  if($font_weight!='') {
    $style .= 'font-weight: '.absint($font_weight).';';
  }

  if($line_height!=''):
        $font_size = $font_size!='' ? $font_size : 15;
        $line_height= absint($line_height) / $font_size;


    $style .= 'line-height: '.$line_height.';';
  endif;


  if($style !=''){
    print 'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6 {'.esc_js($style).'}';
  }

}


add_action( 'lapindos_change_style', 'lapindos_heading_font_family');


/* sub heading font family */
function lapindos_subheading_font_family($config=array()){

  $font_family= isset($config['sub-heading-font']['font-family']) ? $config['sub-heading-font']['font-family'] :  "";

  $line_height= isset($config['sub-heading-font']['line-height']) ? absint($config['sub-heading-font']['line-height']) :  "";
  $letter_spacing= isset($config['sub-heading-font']['letter-spacing']) ? trim($config['sub-heading-font']['letter-spacing']) :  "";
  $font_weight= isset($config['sub-heading-font']['font-weight']) ? trim($config['sub-heading-font']['font-weight']) :  "";
  $font_size= isset($config['body-font']['font-size']) ? intval($config['body-font']['font-size']) :  "";

  $style="";

  if(!empty($font_family) && !preg_match('/poppins/i', $font_family ) ) {?>
.section-font,h1.section-font,h2.section-font,h3.section-font,h4.section-font,
h5.section-font,h6.section-font,.section-main-title.section-font{
  font-family: <?php print $font_family;?>;
}
<?php  }

  if($font_weight!='') {
    $style .= 'font-weight: '.absint($font_weight).';';
  }

  if(!empty($letter_spacing) && $letter_spacing!='px' && $letter_spacing!='pt') {
    $style.= 'letter-spacing: '.absint($letter_spacing).'px;';
  }

  if($line_height!=''):
        $font_size = $font_size!='' ? $font_size : 15;
        $line_height= absint($line_height) / $font_size;


    $style .= 'line-height: '.$line_height.';';
  endif;


  if($style !=''){
    print '.section-font {'.esc_js($style).'}';
  }
}


add_action( 'lapindos_change_style', 'lapindos_subheading_font_family');


function lapindos_heading_module_order($config=array()){

  $ordering = isset($config['icon-bars-module']) ? (array)$config['icon-bars-module'] : array();
  if(!count($ordering)) return;

  $i = 0;
  $logo_first = false;
  $logo_latest = false;

  foreach ($ordering as $key => $value) {

    if($i==0 && $key == 'logo' ){
      $logo_first = true;
    }

    print '.'.sanitize_html_class($key).'{order: '.$i.';}';
    $i++;

   if($i == 4 && $key == 'logo' ){
      $logo_latest = true;
    }

  }

  if($logo_latest){
    print '.icon-bar #logo{padding-left: 30px;padding-right: 0;}';
  }
  elseif(!$logo_first){
    print '.icon-bar #logo{padding-left: 30px;padding-right: 30px;}';
  }


}

add_action( 'lapindos_change_style', 'lapindos_heading_module_order');

// gallery style
add_filter('use_default_gallery_style','__return_false');


/*
 * soundcloud embed
 * parameter https://developers.soundcloud.com/docs/widget
 */

function lapindos_soundcloud_code($atts){

  $atts = wp_parse_args($atts, array(
    'url'=>'',
    'params'=>'',
    'width'=>'',
    'height'=>'166'
    ));

  if(empty($atts['url'])) return;

  $content ='<div class="soundcloud-media"><iframe src="https://w.soundcloud.com/player/?url='.esc_url($atts['url']).'&'.$atts['params'].'&download=false&color=transparent"  height="'.$atts['height'].'"></iframe></div>';
  return $content;
}

function lapindos_soundcloud_tag($content){

  $pattern = get_shortcode_regex(array('soundcloud'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
    $atts = shortcode_parse_atts( $matches[3] );
    return lapindos_soundcloud_code($atts);
')
  , 
  $content);


  return $content;
}

function lapindos_socials($content){

  $pattern = get_shortcode_regex(array('socials'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
      $atts = shortcode_parse_atts( $matches[3] );
      if(!is_array($atts)) $atts = array();

      $atts[\'show_label\'] = false;

      $type = \'soclean_Social\';
      $args = array(
        \'before_widget\' => \'<div class="widget soclean_widget_social">\',
        \'after_widget\' => \'</div>\',
        \'before_title\' => \'<div class="widget-title">\',
        \'after_title\' => \'</div>\'
        );

      ob_start();
      the_widget( $type, $atts, $args );
      $content = ob_get_clean();

      return $content;


  ')
  , 
  $content);


  return $content;



}


add_filter( 'lapindos_render_footer_text' , 'lapindos_calendar_widget');
add_filter( 'lapindos_render_footer_text' , 'lapindos_socials');
add_filter( 'lapindos_render_footer_text' , 'do_shortcode');
add_filter( 'lapindos_render_footer_text' , 'lapindos_tag_cloud');
add_filter( 'lapindos_render_footer_text' , 'wpautop');

add_filter( 'the_content' , 'lapindos_soundcloud_tag',1);


function lapindos_check_theme_switches(){

    global $wp_post_types;

     if ( $stylesheet = get_option( 'theme_switched' ) ) {

            $mods = get_option( "theme_mods_$stylesheet" );
            $custom_logo_id = isset($mods['custom_logo']) ? $mods['custom_logo'] : "";

            set_theme_mod( 'custom_logo', $custom_logo_id );

            $header_image = isset($mods['header_image_data']) ? $mods['header_image_data'] : "";
            set_theme_mod( 'header_image_data' , $header_image);

     }

     if( !is_admin() && ($exclude_post_types = lapindos_get_config('search_hide_post_types')) && count($exclude_post_types) ){

        foreach ($exclude_post_types as $post_type => $exclude) {

          if( array_key_exists($post_type, $wp_post_types) && (bool)$exclude ){
            $wp_post_types[$post_type]->exclude_from_search = true;
          }
        }
     }
}

// get logo from previous theme
add_action( 'init','lapindos_check_theme_switches');

function lapindos_get_post_featured_image_tag($post_id=null, $args=array()){

  if(! $post_id) $post_id = get_the_ID();

  $args = wp_parse_args($args, array('size'=>'full','css'=>'blog-image clearfix'));

  $thumb_id = get_post_thumbnail_id($post_id);
  $image="";
  $thumb_image = wp_get_attachment_image_src($thumb_id, $args['size'], false); 

  if(isset($thumb_image[0])) {
    $image_url = $thumb_image[0];
    $alt_image = get_post_meta(absint($thumb_id), '_wp_attachment_image_alt', true);

     if(function_exists('icl_t')){
        $alt_image = icl_t('lapindos', sanitize_key( $alt_image ), $alt_image );
     }


    $image='<div class="'.esc_attr($args['css']).'"><div class="img-wrapper"><img  class="img-responsive" src="'.esc_url($image_url).'" alt="'.esc_attr($alt_image).'" /></div></div>';
  }

  return $image;

}

function lapindos_glyphicon_list(){
  $icons = array();

  return apply_filters('themegum_glyphicon_list',$icons);
}


function lapindos_get_sociallinks($args=array()){

    $social_fb = lapindos_get_config('social_fb');
    $social_twitter = lapindos_get_config('social_twitter');
    $social_gplus = lapindos_get_config('social_gplus');
    $social_linkedin = lapindos_get_config('social_linkedin');
    $social_pinterest = lapindos_get_config('social_pinterest');
    $social_instagram = lapindos_get_config('social_instagram');

    $default_args= array('array'=>false,'show_label'=>true,'target'=>'','skin'=>'');

    $args = wp_parse_args($args, $default_args);

    $rows=array();

  if(!empty($social_fb)){
    $rows['facebook'] = array( 
      'label' => esc_html__( 'facebook','lapindos'),
      'link' => $social_fb,
      'icon' => 'fa-facebook',
      );
  }

 if(!empty($social_gplus)){
    $rows['google'] = array( 
      'label' => esc_html__( 'google +','lapindos'),
      'link' => $social_gplus,
      'icon' => 'fa-google',
      );
  }

 if(!empty($social_twitter)){
    $rows['twitter'] = array( 
      'label' => esc_html__( 'twitter','lapindos'),
      'link' => $social_twitter,
      'icon' => 'fa-twitter',
      );
  }

 if(!empty($social_instagram)){
    $rows['instagram'] = array( 
      'label' => esc_html__( 'instagram','lapindos'),
      'link' => $social_instagram,
      'icon' => 'fa-instagram',
      );
  }

  if(!empty($social_pinterest)){
    $rows['pinterest'] = array( 
      'label' => esc_html__( 'pinterest','lapindos'),
      'link' => $social_pinterest,
      'icon' => 'fa-pinterest',
      );
   }


  if(!empty($social_linkedin)){
    $rows['linkedin'] = array( 
      'label' => esc_html__( 'linkedin','lapindos'),
      'link' => $social_linkedin,
      'icon' => 'fa-linkedin',
      );
   }


  $custom_socials=lapindos_get_config('custom_socials');

  if(is_array($custom_socials) && count($custom_socials)){

    foreach ($custom_socials as $custom_social) {

      if(isset($custom_social['icon']) && !empty($custom_social['icon'])) {

        if(function_exists('icl_t')){
          $custom_social['label'] = icl_t('lapindos', sanitize_key( $custom_social['label'] ), $custom_social['label'] );
        }

        $rows[ sanitize_key($custom_social['label'])] = $custom_social;
      }
    }
  }


   if($args['array']) return apply_filters('lapindos_social_icon_list', $rows);;

   $html = "";

   if(count($rows)){
     $html = '<ul class="social-icon-lists skin-'.sanitize_html_class($args['skin']).'">';
     foreach($rows as $row){
        $html .= '<li class="social-item"><a href="'.esc_url($row['link']).'"'.($args['target']!='' ? ' target="'.$args['target'].'"' : '').'><i class="fa '.esc_attr($row['icon']).'"></i>'.($args['show_label'] ? '<span>'.$row['label'].'</span>': '' ).'</a></li>';
     }
     $html .= '</ul>';
   }

   $html = apply_filters('lapindos_social_icon_list_html', $html, $rows, $args);

   return $html;
}


add_filter( 'woocommerce_add_to_cart_fragments', 'lapindos_woocommerce_header_add_to_cart_fragment' );

function lapindos_woocommerce_header_add_to_cart_fragment( $fragments ) {
  $fragments['cart_content_count'] = WC()->cart->get_cart_contents_count();
  return $fragments;
}

function lapindos_registration_url(){

 if( ($registration_page_id = get_option('woocommerce_registration_page_id'))){
   return get_the_permalink($registration_page_id);
 }

 return wp_registration_url();

}

function lapindos_get_portfolio_fields($fields=array()){

  $portfolio_fields=lapindos_get_config('portfolio_fields');

  if(!$portfolio_fields || !is_array($portfolio_fields))
    return $fields;

  $new_fields=array();

  foreach ($portfolio_fields as $k=>$field) {

    if(empty($field['name']))
      continue;

     $metaname=sanitize_key($field['name']);
     $new_fields[$metaname]=$field;


  }
  return $new_fields;
}

add_filter('tg_custom_post_fields','lapindos_get_portfolio_fields');

function lapindos_view_port() {

  $responsive_off = lapindos_get_config('mobile-responsive',false);

if(! $responsive_off){
?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php }else{

  $viewport_width = lapindos_get_config('viewport-with',1024);
  if(!$viewport_width || $viewport_width='') $viewport_width = 1024;

?>
<meta name="viewport" content="width=<?php print absint($viewport_width);?>">
<?php }

}

function lapindos_header_style() {

  $banner_height = lapindos_get_config('heading-height','');
  $page_title_off = lapindos_get_config('page-title-offset','');
?>
<style type="text/css">
@media (min-width: 992px) {
<?php if($banner_height !=''):?>
  .page-heading.fixed,
  .page-heading .wp-custom-header,
  .page-heading .custom-page-title{
    min-height:  <?php print absint($banner_height);?>px;
  }
  .page-heading .wp-custom-header{
    height: <?php print absint($banner_height);?>px;
  }
<?php endif;?>
<?php if($page_title_off !=''):?>
  .page-heading .wp-custom-header + .custom-page-title{
    bottom: <?php print floatval($page_title_off);?>px;
  }
<?php endif;?>


}
</style>
<?php 
}
?>