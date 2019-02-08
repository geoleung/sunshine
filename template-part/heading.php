<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */


$navigation_class = array('mainmenu-bar');

if(($layout_mode = lapindos_get_config('sticky-layout-mode')) ){
  array_push($navigation_class, $layout_mode);
}

if(lapindos_get_config('sticky_menu',false)){
  array_push($navigation_class, 'sticky');

  if(($stickymobile = lapindos_get_config('sticky-mobile')) ){

    array_push($navigation_class, 'mobile-sticky');
  }

} 


?>
<?php get_template_part( 'template-part/top-heading'); ?>
<div class="<?php print join(' ', $navigation_class);?>">
  <div class="container">
    <div class="mainmenu-bar-inner">
<?php
  $custom_logo_id = get_theme_mod( 'custom_logo_alt' );
  
  if($custom_logo_id==''){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
  }

  // We have a logo. Logo is go.
  if ( $custom_logo_id ) {
    
    printf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
      esc_url( home_url( '/' ) ),
      wp_get_attachment_image( $custom_logo_id, 'full', false, array(
        'class'    => 'custom-logo-alt',
      ) )
    );
  }
  else{

$blogtitle = get_bloginfo('name');?>
<p class="logo-text"><a  href="<?php esc_url(home_url('/'));?>" title="<?php print esc_attr($blogtitle);?>"><?php bloginfo('name');?></a></p>
<?php 

  }
?>
<button class="navbar-toggle toggle-main-menu" type="button" onclick="javascript:;" data-toggle="collapse" data-target=".mainmenu-bar-mobile">
    <span class="menu-bar">
      <span></span>
      <span></span>
      <span></span>
    </span>
  </button>
<?php
if(lapindos_get_config('sticky_menu',false)){
  get_template_part( 'template-part/sticky-bar'); 
}
?>
</div>
   <div class="mainmenu-bar-mobile collapse"></div>
  </div>
<?php if(lapindos_get_config('sticky_menu',false) && ($shape = lapindos_get_config('header-shape',false)) && lapindos_get_config('sticky_menu_shape',false)):?>
  <?php get_template_part( 'template-part/sticky-shape-'.$shape); ?>
<?php endif;?>

</div>
<?php 

if( !apply_filters( 'lapindos_hide_page_heading',  lapindos_get_config('hide_heading',false) )):


the_custom_header_markup();
$hide_heading_title = apply_filters( 'lapindos_hide_page_title',  lapindos_get_config('hide_heading_title',false) );

?>
<div class="custom-page-title align-<?php print lapindos_get_config('heading_align','center');?>">
  <div class="container">
    <?php 

    print ( !$hide_heading_title &&  lapindos_get_config('page_title' , true) && ($title_section = lapindos_get_config('the_title')) && $title_section!='') ? '<h1 class="h2 page-title">'.esc_html($title_section).'</h1>' : "";

      if(!is_archive() && is_search() && 'header' == lapindos_get_config( 'search_form_position', 'content')){
        get_search_form(); 
      }

      if(  apply_filters( 'lapindos_use_breadcrumb' ,lapindos_get_config('use_breadcrumb', true))):
          lapindos_breadcrumbs();
      endif;
    ?>
  </div>
</div>
<?php endif;?>