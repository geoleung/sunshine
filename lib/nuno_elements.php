<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

/**
 * nuno builder element
 * @since Lapindos 1.0.0
*/ 

function lapindos_load_main_style(){
  wp_enqueue_style( "nuno-builder-style",get_template_directory_uri() . '/css/nuno_blocks.css', array(), '', 'all' );
}

add_action('themegum-glyph-icon-loaded','lapindos_load_main_style');

function lapindos_view_landing_block($post_type = ''){

  lapindos_load_main_style();
  lapindos_load_service_glyph();
  lapindos_enqueue_scripts();
}

add_action( 'wp_landing_view_landing-block', 'lapindos_view_landing_block');
add_action( 'wp_landing_view_landing-element', 'lapindos_view_landing_block');

/**
 * SLides show
 *
 */

class LandingBuilderElement_superclean_slides extends LandingBuilderElement {

    function render($atts, $content = null, $base = ''){

        extract(shortcode_atts(array(
            'el_id'=>'',
            'el_class'=>'',
            'width_desktop'=>'',
            'width_tablet'=>'',
            'width_mobile'=>'',
            'height_desktop'=>'',
            'height_tablet'=>'',
            'height_mobile'=>'',
            'container_width'=>'',
            'container_height'=>''
        ), $atts,'superclean_slides'));


        $atts['class'] = $el_class;

        if(''==$el_id){
            $el_id="element-".wp_landing_getElementTagID();
            $atts['el_id'] = $el_id;
        }

        $desktop_size = $tablet_size = $mobile_size = array();

        ob_start();

        lapindos_slides_show($atts);

        $compile = ob_get_clean();

        wp_landing_add_element_margin_style("#$el_id",$atts);

        if($container_height == 'no' && $height_desktop!=''){
          $height_desktop = strpos($height_desktop, '%') ? $height_desktop : (int)$height_desktop."px";
          $desktop_size['height'] = 'height:'.$height_desktop;

        } 

        if($container_width == 'no' && $width_desktop!=''){
          $width_desktop = strpos($width_desktop, '%') ? $width_desktop : (int)$width_desktop."px";
          $desktop_size['width'] = 'width:'.$width_desktop.'!important';
          $desktop_size['margin-left'] = 'margin-left:auto';
          $desktop_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($desktop_size)){
              wp_landing_add_page_css_style("#$el_id".'{'.@implode(";",$desktop_size).'}');
        }

        if($container_height == 'no' && $height_tablet!=''){
          $height_tablet = strpos($height_tablet, '%') ? $height_tablet : (int)$height_tablet."px";
          $tablet_size['height'] = 'height:'.$height_tablet.'!important';

        } 

        if($container_width == 'no' && $width_tablet!=''){
          $width_tablet = strpos($width_tablet, '%') ? $width_tablet : (int)$width_tablet."px";
          $tablet_size['width'] = 'width:'.$width_tablet.'!important';
          $tablet_size['margin-left'] = 'margin-left:auto';
          $tablet_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($tablet_size)){
              wp_landing_add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$tablet_size).'}');
        }

        if($container_height == 'no' && $height_mobile!=''){
          $height_mobile = strpos($height_mobile, '%') ? $height_mobile : (int)$height_mobile."px";
          $mobile_size['height'] = 'height:'.$height_mobile;

        } 

        if($container_width == 'no' && $width_mobile!=''){
          $width_mobile = strpos($width_mobile, '%') ? $width_mobile : (int)$width_mobile."px";
          $mobile_size['width'] = 'width:'.$width_mobile;
          $mobile_size['margin-left'] = 'margin-left:auto';
          $mobile_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($mobile_size)){
              wp_landing_add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$mobile_size).'}');
        }
         
        return $compile;
    }
}

wp_landing_add_element('superclean_slides',
  array(
    'title'=>esc_html__('Lapindos Slides','lapindos'),
    'icon'=>'fa fa-film',
    'color'=>'#2e96db',
    'order'=>30,
    'priority'=>'medium',
    'options'=>array(
         array( 
          'heading' => esc_html__( 'Slide Interval', 'lapindos' ),
          'param_name' => 'play',
          'description'=> array( esc_html__('Milliseconds before progressing to next slide automatically.','lapindos'),'','info'),
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Slide Speed', 'lapindos' ),
          'param_name' => 'slide_speed',
          "description" => esc_html__("Slide speed in milisecond.", "lapindos"),
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Background Animation', 'lapindos' ),
          'param_name' => 'animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation the slider.','lapindos'),
          'value'=>array(
              'slide' => esc_html__('Slide','lapindos'),
              'fade' => esc_html__('Fade','lapindos'),
              ),
          'default'=>'slide'
        ),
        array( 
          'heading' => esc_html__( 'Animation Easing', 'lapindos' ),
          'param_name' => 'easing',
          'type' => 'radio',
          'description'=> esc_html__('Select animation easing the slider.','lapindos'),
          'value'=>array(
              'linear' => esc_html__('Linear','lapindos'),
              'swing' => esc_html__('Swing','lapindos'),
              ),
          'default'=>'swing'
        ),
        array( 
          'heading' => esc_html__( 'Content Animation', 'lapindos' ),
          'param_name' => 'slide_animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation for slide content.','lapindos'),
          'value'=>array(
              '' => esc_html__('None','lapindos'),
              'fromTop' => esc_html__('From Top','lapindos'),
              'fromBottom' => esc_html__('From Bottom','lapindos'),
              'scale' => esc_html__('Scale','lapindos'),
              'fade' => esc_html__('Fade','lapindos'),
              'fadeScale' => esc_html__('Scale and Fade','lapindos'),
              ),
          'default'=>''
        ),
        array( 
          'heading' => esc_html__( 'Pagination', 'lapindos' ),
          'param_name' => 'pagination',
          'type' => 'switch',
        ),
        array( 
          'heading' => esc_html__( 'Width', 'lapindos' ),
          'param_name' => 'container_width',
          'default' =>'yes',
          'value'=>array(
              'yes' => esc_html__('Full Screen','lapindos'),
              'no' => esc_html__('Custom','lapindos')
              ),
          'description' => array( esc_html__( 'Slide container full width. If select no, you mus define as well. ', 'lapindos' ),'','warning'),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for large screen from 992px.', 'lapindos' ),'','info'),
          'param_name' => 'width_desktop',
          'type' => 'textfield',
          'holder_class'=> array( 'desktop'),
          'indent' => true,
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 992px.', 'lapindos' ),'','info'),
          'param_name' => 'width_tablet',
          'indent' => true,
          'type' => 'textfield',
          'holder_class'=> array( 'tablet_portrait'),
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 480px.', 'lapindos' ),'','info'),
          'param_name' => 'width_mobile',
          'holder_class'=> array( 'mobile'),
          'indent' => true,
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Height', 'lapindos' ),
          'param_name' => 'container_height',
          'value'=>array(
              'yes' => esc_html__('Full Screen','lapindos'),
              'no' => esc_html__('Custom','lapindos')
              ),
          'default' =>'yes',
          'description' => array( esc_html__( 'Slide container full height. If select no, you mus define as well. ', 'lapindos' ),'','warning'),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for large screen from 992px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_desktop',
          'type' => 'textfield',
          'holder_class'=> array( 'desktop'),
          'class'=>'small',
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 992px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_tablet',
          'type' => 'textfield',
          'class'=>'small',
          'holder_class'=> array( 'tablet_portrait'),
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 480px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_mobile',
          'type' => 'textfield',
          'class'=>'small',
          'holder_class'=> array( 'mobile'),
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
       array( 
          'labels'=>array( esc_html__( 'Any Screen', 'lapindos' ),'inline','large'),
          'param_name' => 'margin_desktop',
          'holder_class'=> array( 'desktop'),
          'type' => 'heading',
          'description' => array( esc_html__( '( Above 1366px )', 'lapindos' ),'inline'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),

        array( 
          'labels'=>array( esc_html__( 'Notebook', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1366px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_notebook',
          'holder_class'=> array('notebook'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_notebook_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_nb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_nb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_nb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_nb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Tablet Landscape', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1024px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet_landscape',
          'holder_class'=> array('tablet_landscape'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_tablet_landscape_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_tb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_tb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_tb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_tb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),              
        array( 
          'labels'=>array( esc_html__( 'Tablet Portrait', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 768px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet',
          'type' => 'switch',
          'holder_class'=> array( 'tablet_portrait' ),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_tablet_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Mobile', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 480px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_mobile',
          'type' => 'switch',
          'holder_class'=> array('mobile'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_mobile_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
         array( 
          'heading' => esc_html__( 'Anchor ID', 'lapindos' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          'group'=>esc_html__('Advanced', 'lapindos'),
          "description" => array( esc_html__("Enter anchor ID without pound '#' sign. This filed required id Popup Content activated.", "lapindos"),'','info')
        ),
        array( 
          'heading' => esc_html__( 'Extra CSS class', 'lapindos' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'skin'=>'light',
          'value'=>"",
          'group'=>esc_html__('Advanced', 'lapindos'),
          ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'lapindos' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => array(esc_html__("Enter z-index for adjust z position", "lapindos"),'inline','info'),
          'group'=>esc_html__('Advanced', 'lapindos'),
        ),

        )    
    )
);

/**
 * Super Slide
 *
 */

class LandingBuilderElement_superslide_item extends LandingBuilderElement {

    function render($atts, $content = null, $base = '') {

        extract( shortcode_atts( array(
          'attachment_id'=>'',
          'title'=>'',
          'align'=>'',
          'btn'=>'',
          'url'=>'',
          'btn2'=>'',
          'url2'=>'',
          'btn_skin'=>'primary',
          'btn2_skin'=>'secondary',
          'slide_animation'=>''             

        ), $atts , 'superslide_item') );

ob_start();
?>
<li>
<?php
if($attachment_id){

    $slide_image = wp_get_attachment_image_src($attachment_id,'full',false); 

    if($slide_image){
       $alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
       if(function_exists('icl_t')){
          $alt_image = icl_t('lapindos', sanitize_key( $alt_image ), $alt_image );
       }

      print '<img src="'.esc_url($slide_image[0]).'" alt="'.esc_attr($alt_image).'" />';

    }
}

?>
<div class="overlay-bg"></div>
<div class="container">
  <div class="wrap-caption <?php print sanitize_html_class($align);?> <?php print ($slide_animation !='') ? 'animated-'.sanitize_html_class($slide_animation) : '';?>">
    <?php 
    print ($title!='') ? '<h2 class="caption-heading">'.esc_html($title).'</h2>': '';
    print ($content!='') ? '<p class="excerpt">'.esc_html($content).'</p>': '';
    print ($btn!='') ? '<a href="'.esc_url($url).'" class="btn btn-skin-'.sanitize_html_class($btn_skin).'">'.esc_html($btn).'</a>': '';
    print ($btn2!='') ? '<a href="'.esc_url($url2).'" class="btn btn-skin-'.sanitize_html_class($btn2_skin).'">'.esc_html($btn2).'</a>': '';
    ?>    
  </div>
</div>
</li>
<?php
$compile = ob_get_clean();
      return $compile;

    }
} 


class LandingBuilderElement_superslide extends LandingBuilderElement {

    function render($atts, $content = null, $base = ''){

        extract(shortcode_atts(array(
            'el_id'=>'',
            'el_class'=>'',
            'width_desktop'=>'',
            'width_tablet'=>'',
            'width_mobile'=>'',
            'height_desktop'=>'',
            'height_tablet'=>'',
            'height_mobile'=>'',
            'container_width'=>'',
            'container_height'=>'',
            'pagination'=>'',
            'play'=>5000,
            'slide_speed'=>800,            
            'animation'=>'slide',
            'easing'=>'swing',
            'slide_animation'=>'',
        ), $atts,'superslide'));

        $pattern = get_shortcode_regex(array('superslide_item'));

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";

      wp_enqueue_script( 'easing' , get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), '1.3', true );
      wp_enqueue_script( 'superslides' , get_template_directory_uri() . '/js/jquery.superslides.js', array('jquery','easing'), '1.0', true );

        $atts['class'] = $el_class;

        if(''==$el_id){
            $el_id="element-".wp_landing_getElementTagID();
            $atts['el_id'] = $el_id;
        }

        $desktop_size = $tablet_size = $mobile_size = array();
        $slide_id =  $el_id;

        $slide_width = $slide_height = 'window';

        if($container_width == 'no'){
          $slide_width ='\'#'.$slide_id.'\'';
        }

        if($container_height == 'no'){
          $slide_height ='\'#'.$slide_id.'\'';
        }


        ob_start();
?>
<div id="<?php print esc_attr($slide_id);?>" class="<?php print esc_attr($el_class);?> nuno-slide"  dir="ltr">
    <ul class="slides-container">
    <?php 

  foreach ($matches as $slide) {

    $code = "[superslide_item slide_animation=\"".$slide_animation."\" ".$slide[3]."]".$slide[5]."[/superslide_item]";

     print do_shortcode($code);

  }

?>
    </ul>
<?php if($pagination):?>
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
      play: <?php print absint($play);?>,
      animation_speed: <?php print absint($slide_speed);?>,
      inherit_height_from: <?php print $slide_height;?>,
      inherit_width_from: <?php print $slide_width;?>,
      pagination: <?php print ($pagination) ? 'true':'false';?>,
      hashchange: false,
      scrollable: true,
<?php print ($easing !='' ) ? 'animation_easing:\''. sanitize_html_class($easing).'\',' : '';?>
      animation: '<?php print ($animation =='fade') ? 'fade':'slide';?>'
    });
  });
</script>
<?php
        $compile = ob_get_clean();

        wp_landing_add_element_margin_style("#$el_id",$atts);

        if($container_height == 'no' && $height_desktop!=''){
          $height_desktop = strpos($height_desktop, '%') ? $height_desktop : (int)$height_desktop."px";
          $desktop_size['height'] = 'height:'.$height_desktop;

        } 

        if($width_desktop!='' && $container_width == 'no'){
          $width_desktop = strpos($width_desktop, '%') ? $width_desktop : (int)$width_desktop."px";
          $desktop_size['width'] = 'width:'.$width_desktop.'!important';
          $desktop_size['margin-left'] = 'margin-left:auto';
          $desktop_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($desktop_size)){
              wp_landing_add_page_css_style("#$el_id".'{'.@implode(";",$desktop_size).'}');
        }

        if($container_height == 'no' && $height_tablet!=''){
          $height_tablet = strpos($height_tablet, '%') ? $height_tablet : (int)$height_tablet."px";
          $tablet_size['height'] = 'height:'.$height_tablet.'!important';

        } 

        if($width_tablet!='' && $container_width == 'no'){
          $width_tablet = strpos($width_tablet, '%') ? $width_tablet : (int)$width_tablet."px";
          $tablet_size['width'] = 'width:'.$width_tablet.'!important';
          $tablet_size['margin-left'] = 'margin-left:auto';
          $tablet_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($tablet_size)){
              wp_landing_add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$tablet_size).'}');
        }

        if($container_height == 'no' && $height_mobile!=''){
          $height_mobile = strpos($height_mobile, '%') ? $height_mobile : (int)$height_mobile."px";
          $mobile_size['height'] = 'height:'.$height_mobile;

        } 

        if($width_mobile!='' && $container_width == 'no'){
          $width_mobile = strpos($width_mobile, '%') ? $width_mobile : (int)$width_mobile."px";
          $mobile_size['width'] = 'width:'.$width_mobile;
          $mobile_size['margin-left'] = 'margin-left:auto';
          $mobile_size['margin-right'] = 'margin-right:auto';

        } 

        if(count($mobile_size)){
              wp_landing_add_page_css_style('tablet',"#$el_id".'{'.@implode(";",$mobile_size).'}');
        }
         
        return $compile;
    }
}

wp_landing_add_element('superslide_item',
 array( 
    'title' => esc_html__( 'Slide', 'lapindos' ),
    'as_child' => 'superslide',
    'color'=>'#2e96db',
    'options' => array(
        array( 
          'heading' => esc_html__( 'Image', 'lapindos' ),
          'param_name' => 'attachment_id',
          'description' => array( esc_html__( 'Slide image', 'lapindos' ),'','warning'),
          'type' => 'image',
        ),              
        array( 
          'heading' => esc_html__( 'Title Text', 'lapindos' ),
          'param_name' => 'title',
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Long Text', 'lapindos' ),
          'param_name' => 'content',
          'class' => '',
          'value' => '',
          'type' => 'textarea'
         ),        
        array( 
          'heading' => esc_html__( 'Content Align', 'lapindos' ),
          'param_name' => 'align',
          'type' => 'radiobutton',
          'value' => array(
                      'left'=>esc_html__('Left','lapindos'),
                      'center'=>esc_html__('Center','lapindos'),
                      'right'=>esc_html__('Right','lapindos'),
                    ),
        ),
       array( 
          'labels'=>array( esc_html__( 'LEFT BUTTON', 'lapindos' ),'','large'),
          'param_name' => 'btn1_heading',
          'type' => 'heading',
          'noborder'=> true,
          'skin' => 'grey',
        ),
        array( 
          'heading' => esc_html__( 'Button Text', 'lapindos' ),
          'param_name' => 'btn',
          'value' => '',
          'noborder'=> true,
          'description' => array( esc_html__( 'Leave blank if not using button', 'lapindos' ),'inline','info'),
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Button Link', 'lapindos' ),
          'param_name' => 'url',
          'value' => '',
          'noborder'=> true,
          'type' => 'textfield'
         ),
        array(
            'heading' => esc_html__( 'Button Skin', 'lapindos' ),
            'param_name' => 'btn_skin',
            'type' => 'radiobutton',
            'default'=>'primary',
            'value' => lapindos_wp_landing_button_skin(),
            "description" => array( esc_html__("Skin color overwritten at color settings", "lapindos"),'label','info'),
        ),
       array( 
          'labels'=>array( esc_html__( 'RIGHT BUTTON', 'lapindos' ),'','large'),
          'param_name' => 'btn2_heading',
          'type' => 'heading',
          'skin' => 'grey',
        ),
        array( 
          'heading' => esc_html__( 'Button Text', 'lapindos' ),
          'param_name' => 'btn2',
          'value' => '',
          'noborder'=> true,
          'description' => array( esc_html__( 'Leave blank if not using button', 'lapindos' ),'inline','info'),
          'type' => 'textfield'
         ),
        array( 
          'heading' => esc_html__( 'Button Link', 'lapindos' ),
          'param_name' => 'url2',
          'value' => '',
          'noborder'=> true,
          'type' => 'textfield'
         ),
        array(
            'heading' => esc_html__( 'Button Skin', 'lapindos' ),
            'param_name' => 'btn2_skin',
            'type' => 'radiobutton',
            'default'=>'secondary',
            'value' => lapindos_wp_landing_button_skin(),
            "description" => array( esc_html__("Skin color overwritten at color settings", "lapindos"),'label','info'),
        ),

    )
   ) 
 );


wp_landing_add_element('superslide',
  array(
    'title'=>esc_html__('Superslide','lapindos'),
    'icon'=>'fa fa-sliders',
    'color'=>'#2e96db',
    'order'=>31,
    'as_parent' => 'superslide_item',
    'child_list'=>'vertical',
    'priority'=>'medium',
    'options'=>array(
         array( 
          'heading' => esc_html__( 'Play Interval', 'lapindos' ),
          'param_name' => 'play',
          'description'=> array( esc_html__('Milliseconds before progressing to next slide automatically.','lapindos'),'','info'),
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Slide Speed', 'lapindos' ),
          'param_name' => 'slide_speed',
          "description" => esc_html__("Slide speed in milisecond.", "lapindos"),
          'type' => 'textfield',
        ),
        array( 
          'heading' => esc_html__( 'Background Animation', 'lapindos' ),
          'param_name' => 'animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation the slider.','lapindos'),
          'value'=>array(
              'slide' => esc_html__('Slide','lapindos'),
              'fade' => esc_html__('Fade','lapindos'),
              ),
          'default'=>'slide'
        ),
        array( 
          'heading' => esc_html__( 'Animation Easing', 'lapindos' ),
          'param_name' => 'easing',
          'type' => 'radio',
          'description'=> esc_html__('Select animation easing the slider.','lapindos'),
          'value'=>array(
              'linear' => esc_html__('Linear','lapindos'),
              'swing' => esc_html__('Swing','lapindos'),
              ),
          'default'=>'swing'
        ),
        array( 
          'heading' => esc_html__( 'Content Animation', 'lapindos' ),
          'param_name' => 'slide_animation',
          'type' => 'radio',
          'description'=> esc_html__('Select animation for slide content.','lapindos'),
          'value'=>array(
              '' => esc_html__('None','lapindos'),
              'fromTop' => esc_html__('From Top','lapindos'),
              'fromBottom' => esc_html__('From Bottom','lapindos'),
              'scale' => esc_html__('Scale','lapindos'),
              'fade' => esc_html__('Fade','lapindos'),
              'fadeScale' => esc_html__('Scale and Fade','lapindos'),
              ),
          'default'=>''
        ),
        array( 
          'heading' => esc_html__( 'Pagination', 'lapindos' ),
          'param_name' => 'pagination',
          'type' => 'switch',
        ),
        array( 
          'heading' => esc_html__( 'Width', 'lapindos' ),
          'param_name' => 'container_width',
          'default' =>'yes',
          'value'=>array(
              'yes' => esc_html__('Full Screen','lapindos'),
              'no' => esc_html__('Custom','lapindos')
              ),
          'description' => array( esc_html__( 'Slide container full width. If select no, you mus define as well. ', 'lapindos' ),'','warning'),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for large screen from 992px.', 'lapindos' ),'','info'),
          'param_name' => 'width_desktop',
          'type' => 'textfield',
          'holder_class'=> array( 'desktop'),
          'indent' => true,
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 992px.', 'lapindos' ),'','info'),
          'param_name' => 'width_tablet',
          'indent' => true,
          'type' => 'textfield',
          'holder_class'=> array( 'tablet_portrait'),
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 480px.', 'lapindos' ),'','info'),
          'param_name' => 'width_mobile',
          'holder_class'=> array( 'mobile'),
          'indent' => true,
          'type' => 'textfield',
          'class'=>'small',
          'dependency' => array( 'element' => 'container_width', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Height', 'lapindos' ),
          'param_name' => 'container_height',
          'value'=>array(
              'yes' => esc_html__('Full Screen','lapindos'),
              'no' => esc_html__('Custom','lapindos')
              ),
          'default' =>'yes',
          'description' => array( esc_html__( 'Slide container full height. If select no, you mus define as well. ', 'lapindos' ),'','warning'),
          'type' => 'radio',
        ),
        array( 
          'heading' => esc_html__( 'Desktop', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for large screen from 992px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_desktop',
          'type' => 'textfield',
          'holder_class'=> array( 'desktop'),
          'class'=>'small',
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Tablet', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 992px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_tablet',
          'type' => 'textfield',
          'class'=>'small',
          'holder_class'=> array( 'tablet_portrait'),
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
        array( 
          'heading' => esc_html__( 'Mobile', 'lapindos' ),
          'description' => array( esc_html__( 'This optional for screen up to 480px.', 'lapindos' ),'','info'),
          'indent' => true,
          'param_name' => 'height_mobile',
          'type' => 'textfield',
          'class'=>'small',
          'holder_class'=> array( 'mobile'),
          'dependency' => array( 'element' => 'container_height', 'value' => array('no') )
        ),
       array( 
          'labels'=>array( esc_html__( 'Any Screen', 'lapindos' ),'inline','large'),
          'param_name' => 'margin_desktop',
          'holder_class'=> array( 'desktop'),
          'type' => 'heading',
          'description' => array( esc_html__( '( Above 1366px )', 'lapindos' ),'inline'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),

        array( 
          'labels'=>array( esc_html__( 'Notebook', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1366px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_notebook',
          'holder_class'=> array('notebook'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_notebook_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_nb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_nb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_nb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_nb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Tablet Landscape', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1024px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet_landscape',
          'holder_class'=> array('tablet_landscape'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_tablet_landscape_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_tb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_tb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_tb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_tb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),              
        array( 
          'labels'=>array( esc_html__( 'Tablet Portrait', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 768px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet',
          'type' => 'switch',
          'holder_class'=> array( 'tablet_portrait' ),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_tablet_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Mobile', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 480px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_mobile',
          'type' => 'switch',
          'holder_class'=> array('mobile'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_mobile_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
         array( 
          'heading' => esc_html__( 'Anchor ID', 'lapindos' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          'group'=>esc_html__('Advanced', 'lapindos'),
          "description" => array( esc_html__("Enter anchor ID without pound '#' sign. This filed required id Popup Content activated.", "lapindos"),'','info')
        ),
        array( 
          'heading' => esc_html__( 'Extra CSS class', 'lapindos' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'skin'=>'light',
          'value'=>"",
          'group'=>esc_html__('Advanced', 'lapindos'),
          ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'lapindos' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => array(esc_html__("Enter z-index for adjust z position", "lapindos"),'inline','info'),
          'group'=>esc_html__('Advanced', 'lapindos'),
        ),

        )    
    )
);

class LandingBuilderElement_superclean_post extends LandingBuilderElement{

    function preview($atts, $content = null) {

      $blog_layout = isset($atts['blog_layout']) ? trim($atts['blog_layout']) : 1;
      $layout_thumbs =array(
                      '1'=> get_template_directory_uri().'/lib/images/post_1.png',
                      '2'=> get_template_directory_uri().'/lib/images/post_2.png',
                      '3'=> get_template_directory_uri().'/lib/images/post_3.png',
                      '4'=> get_template_directory_uri().'/lib/images/post_4.png',
                      '5'=> get_template_directory_uri().'/lib/images/post_5.png',
                      ); 
      
      return '<img src="'.esc_url($layout_thumbs[$blog_layout]).'" />';
    }

    function render($atts, $content = null, $base=''){

        if (!isset($compile)) {$compile='';}

        extract(shortcode_atts(array(
            'posts_per_page'=> get_option('posts_per_page'),
            'el_id'=>'',
            'el_class'=>'',
            'size'=>'medium',
            'blog_layout'=>'',
            'column'=>12,
            'excerpt_length'=>'',
        ), $atts, 'superclean_post'));

        $query_params= array(
          'posts_per_page' => $posts_per_page,
          'no_found_rows' => true,
          'post_status' => 'publish',
          'post_type'=>'post',
          'ignore_sticky_posts' => true
        );

        $lite = absint($column) > 1 ? '-lite':'';

        $grid_css= array('grid-column',"col-xs-12");
        $lg = 12 / $column;
        $grid_css[] = "col-lg-".$lg;
        if($lg < 12 ) $grid_css[] = 'col-md-6';
        $grid_class = join(' ',array_unique($grid_css));

        $query = new WP_Query($query_params);

        if (is_wp_error($query) || !$query->have_posts()) {

          return '';
        }

        $rows  = array();

        while ( $query->have_posts() ) : 

          $query->the_post();
          $post_id = get_the_ID();

          $rows[] = lapindos_get_blog_layout($atts);
        endwhile;
        wp_reset_postdata();

        $css_class=array('superclean_post','post-lists','blog-col-'.sanitize_html_class($column),'clearfix');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=wp_landing_getElementStyle($atts);

        if(''==$el_id){
            $el_id="element_".wp_landing_getElementTagID();
        }


        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(""!=$css_style){
          wp_landing_add_page_css_style("#$el_id {".$css_style."}");
        }

        wp_landing_add_element_margin_style("#$el_id",$atts);

        $compile.='class="'.@implode(" ",$css_class).'">';


        $compile .= '<div class="'.esc_attr($grid_class).'">'.join('</div><div class="'.esc_attr($grid_class).'">',$rows).'</div>';
        $compile.='</div>';


        return  $compile;

    }

}

wp_landing_add_element('superclean_post',
 array( 
    'title' => esc_html__( 'Latest Posts', 'lapindos' ),
    'icon'  =>'fa fa-newspaper-o',
    'color' =>'#2e96db',
    'order'=>33,
    'priority'=>'medium',
    'class' => '',
    'options' => array(
         array( 
          'heading' => esc_html__( 'Anchor ID', 'lapindos' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => array( esc_html__("Enter anchor ID without pound '#' sign. This filed required id Popup Content activated.", "lapindos"),'','info')
        ),
        array( 
          'heading' => esc_html__( 'Extra CSS class', 'lapindos' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'skin'=>'light',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'lapindos' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => array(esc_html__("Enter z-index for adjust z position", "lapindos"),'inline','info'),
        ),
         array( 
          'heading' => esc_html__( 'Post Layout', 'lapindos' ),
          'param_name' => 'blog_layout',
          'type' => 'select_layout',
          'value' => array(
                      '1'=> array( 'label'=> esc_html__('Default','lapindos'),'thumb'=> get_template_directory_uri().'/lib/images/post_1.png'),
                      '2'=> array( 'label'=> esc_html__('Image Bottom','lapindos'),'thumb'=> get_template_directory_uri().'/lib/images/post_2.png'),
                      '3'=> array( 'label'=> esc_html__('Hide Image','lapindos'),'thumb'=> get_template_directory_uri().'/lib/images/post_3.png'),
                      '4'=> array( 'label'=> esc_html__('Hide Excerpt','lapindos'),'thumb'=> get_template_directory_uri().'/lib/images/post_4.png'),
                      '5'=> array( 'label'=> esc_html__('Image Only','lapindos'),'thumb'=> get_template_directory_uri().'/lib/images/post_5.png'),
                    ),
        ),
        array( 
          'heading' => esc_html__('Number of posts to show:','lapindos' ),
          'param_name' => 'posts_per_page',
          'class' => 'small',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Number of Columns', 'lapindos' ),
          'param_name' => 'column',
          'description' => array( esc_html__( 'Number of columns on screen larger than 1200px screen resolution', 'lapindos' ),'','info'),
          'class' => '',
          'value'=>array(
              '1' => esc_html__('One Column','lapindos'),
              '2' => esc_html__('Two Columns','lapindos'),
              '3' => esc_html__('Three Columns','lapindos'),
              '4' => esc_html__('Four Columns','lapindos'),
              ),
          'type' => 'radiobutton',
         ),     
        array( 
          'heading' => esc_html__( 'Image Size', 'lapindos' ),
          'param_name' => 'size',
          'type' => 'textfield',
          'value'=>"",
          'description' => array( esc_html__( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'lapindos' ),'','info'),
          ),
        array( 
        'labels'=> array(esc_html__( 'Title Text Transform', 'lapindos' )),
        'param_name' => 'text_transform',
        'default' => "",
        'class'=>'thin',
        'inline'=>true,
        'value'=>array(
              ''  => esc_html__('None','lapindos'),
              'upc' => esc_html__('UPPERCASE','lapindos'),
              'lwc' => esc_html__('lowercase','lapindos'),
              'cplz'  => esc_html__('Capitalize','lapindos'),
              'fwidth'  => esc_html__('Fullwidth','lapindos'),
              ),
        'type' => 'radio'
         ),
        array( 
        'labels'=> array(esc_html__( 'Title Tag', 'lapindos' )),
        'param_name' => 'title_tag',
        'default' => "",
        'class'=>'thin',
        'value'=>array(
              '' => esc_html__('Default','lapindos'),
              'h2'  => 'H2',
              'h3'  => 'H3',
              'h4'  => 'H4',
              'h5'  => 'H5',
              'h6'  => 'H6',
              ),
        'description' => array( esc_html__( 'The tag will representing title size.', 'lapindos' ),'','info'),
        'inline'=>true,
        'type' => 'radiobutton'
         ),
        array( 
        'heading' => esc_html__( 'Title Font Family', 'lapindos' ),
        'param_name' => 'font_family',
        'default' => "",
        'value'=>array(
              ''  => esc_html__('Default','lapindos'),
              'body-font' => esc_html__('Like Body','lapindos'),
              'section-font'  => esc_html__('Like Sub Heading','lapindos'),
              ),
        'inline'=>true,
        'type' => 'radiobutton'
         ),
        array( 
          'heading' => esc_html__('Post title length','lapindos' ),
          'param_name' => 'title_length',
          'class' => 'small',
          'value' => '',
          'type' => 'textfield',
          'description' => array(esc_html__( 'Num words post title displayed.', 'lapindos' ),'','info')
         ), 
        array( 
          'heading' => esc_html__('Post excerpt length','lapindos' ),
          'param_name' => 'excerpt_length',
          'class' => 'small',
          'value' => '',
          'type' => 'textfield',
          'description' => array(esc_html__( 'Num words post content displayed.', 'lapindos' ),'','info')
         ), 

       array( 
          'labels'=>array( esc_html__( 'Any Screen', 'lapindos' ),'inline','large'),
          'param_name' => 'margin_desktop',
          'holder_class'=> array( 'desktop'),
          'type' => 'heading',
          'description' => array( esc_html__( '( Above 1366px )', 'lapindos' ),'inline'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),

        array( 
          'labels'=>array( esc_html__( 'Notebook', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1366px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_notebook',
          'holder_class'=> array('notebook'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_notebook_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_nb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_nb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_nb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_nb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Tablet Landscape', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1024px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet_landscape',
          'holder_class'=> array('tablet_landscape'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_tablet_landscape_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_tb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_tb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_tb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_tb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),              
        array( 
          'labels'=>array( esc_html__( 'Tablet Portrait', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 768px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet',
          'type' => 'switch',
          'holder_class'=> array( 'tablet_portrait' ),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_tablet_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Mobile', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 480px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_mobile',
          'type' => 'switch',
          'holder_class'=> array('mobile'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_mobile_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),

        )
 ) );


class LandingBuilderElement_soclean_optin extends LandingBuilderElement {

    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'title_align'=>'',
        'tag'=>'h4',
        'spy'=>'',
        'scroll_delay'=>300

      ), $atts , 'soclean_optin'));

    $class=array('superclean_optin');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

    if($tag=='') $tag= 'h5';

    if('' != $title_align){
      $before_title = '<'.$tag.' class="widgettitle widget-title-'.$title_align.'">';
    }
    else{
      $before_title = '<'.$tag.' class="widgettitle">';
    }

     $atts['title'] = $title;

     $css_style=wp_landing_getElementStyle($atts);

     if(''==$el_id){
            $el_id="element_".wp_landing_getElementTagID();
     }
     
     if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
      }

      wp_landing_add_element_margin_style("#$el_id",$atts);

      $scollspy="";


      if('none'!=$spy && $spy!=''){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'soclean_Optin', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title , 'after_title'  => '</'.$tag.'>') );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

wp_landing_add_element('soclean_optin',
 array( 
    'title' => esc_html__('Lapindos Optin Form','lapindos'),
    'icon'  =>'fa fa-envelope-o',
    'color' =>'#2e96db',
    'description'=> esc_html__( "Display optin form from newsletter engine like mailchimp",'lapindos'),
    'order'=>50,
    'priority'=>'medium',
    'class' => '',
    'options' => array(
      array( 
          'heading' => esc_html__('Title','lapindos' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
      array( 
          'heading' => esc_html__( 'Title Alignment', 'lapindos' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=> array( 'label' => esc_html__('Default','lapindos') ,'position'=>'inline','icon'=> 'fa-align-justify'),
            'left'=> array('label'=>esc_html__( 'Left', 'lapindos' ),'position'=>'inline','icon'=> 'fa-align-left'),
            'center'=> array('label'=>esc_html__( 'Center', 'lapindos' ),'position'=>'inline','icon'=> 'fa-align-center'),
            'right'=>array( 'label'=> esc_html__('Right','lapindos'),'position'=>'inline','icon'=> 'fa-align-right')
            ),
          'type' => 'radiobutton',
          'default'=>'center'
         ), 
        array( 
        'heading' => esc_html__( 'Title Tag', 'lapindos' ),
        'param_name' => 'tag',
        'default' => "",
        'class'=>'thin',
        'value'=>array(
              '' => esc_html__('Default','lapindos'),
              'h1'  => 'H1',
              'h2'  => 'H2',
              'h3'  => 'H3',
              'h4'  => 'H4',
              'h5'  => 'H5',
              'h6'  => 'H6',
              'div' => 'DIV',
              ),
        'inline'=>true,
        'type' => 'radiobutton'
         ),
      array( 
          'heading' => esc_html__( 'Choose Layout', 'lapindos' ),
          'param_name' => 'layout',
          'type' => 'select_layout',
           'value'=>array(
            'vertical'  => array( 'label'=> esc_html__('Vertical','lapindos'), 'thumb' => wp_landing_get_dir_url().'lib/assets/images/form-vertical.png'),
            'horizontal'  => array( 'label'=> esc_html__('Horizontal','lapindos'), 'thumb' => wp_landing_get_dir_url().'lib/assets/images/form-horizontal.png')
              ),
          'default'=>'vertical',
         ), 
        array(
          'heading' => esc_html__( 'Button Skin', 'lapindos' ),
          'param_name' => 'button_skin',
          'type' => 'radiobutton',
          'default'=>'',
          'value' => lapindos_wp_landing_button_skin(),
          "description" => array( esc_html__("Skin color overwritten at color settings", "lapindos"),'label','info'),
        ),

      array( 
          'heading' => esc_html__( 'Field Name', 'lapindos' ),
          'param_name' => 'show_name',
          'param_holder_class'=>'show-label',
          'value' => array( '1' => esc_html__( 'Show', 'lapindos' ),'0' => esc_html__( 'Hide', 'lapindos' )),
          'type' => 'radiobutton',
          'default'=>'1',
         ),
      array( 
          'heading' => esc_html__( 'Text before form:', 'lapindos' ),
          'param_name' => 'before_form',
          'value' => '',
          'css'=>'optin-code',
          'type' => 'textarea',
         ),
      array( 
          'heading' => esc_html__( 'Text after form:', 'lapindos' ),
          'param_name' => 'after_form',
          'value' => '',
          'css'=>'optin-code',
          'type' => 'textarea',
         ),
      array( 
          'heading' => esc_html__( 'Optin Code', 'lapindos' ),
          'param_name' => 'content',
          'description' => array( esc_html__( 'Put your optin form code here. No any script allowed', 'lapindos' ),'','warning'),
          'value' => '',
          'css'=>'optin-code',
          'type' => 'textarea',
         ),
       array( 
          'labels'=>array( esc_html__( 'Any Screen', 'lapindos' ),'inline','large'),
          'param_name' => 'margin_desktop',
          'holder_class'=> array( 'desktop'),
          'type' => 'heading',
          'description' => array( esc_html__( '( Above 1366px )', 'lapindos' ),'inline'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),

        array( 
          'labels'=>array( esc_html__( 'Notebook', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1366px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_notebook',
          'holder_class'=> array('notebook'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_notebook_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_nb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_nb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_nb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_nb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Tablet Landscape', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1024px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet_landscape',
          'holder_class'=> array('tablet_landscape'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_tablet_landscape_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_tb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_tb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_tb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_tb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),              
        array( 
          'labels'=>array( esc_html__( 'Tablet Portrait', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 768px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet',
          'type' => 'switch',
          'holder_class'=> array( 'tablet_portrait' ),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_tablet_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Mobile', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 480px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_mobile',
          'type' => 'switch',
          'holder_class'=> array('mobile'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_mobile_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
         array( 
          'heading' => esc_html__( 'Anchor ID', 'lapindos' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          'group'=>esc_html__('Advanced', 'lapindos'),
          "description" => array( esc_html__("Enter anchor ID without pound '#' sign. This filed required id Popup Content activated.", "lapindos"),'','info')
        ),
        array( 
          'heading' => esc_html__( 'Extra CSS class', 'lapindos' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'skin'=>'light',
          'value'=>"",
          'group'=>esc_html__('Advanced', 'lapindos'),
          ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'lapindos' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => array(esc_html__("Enter z-index for adjust z position", "lapindos"),'inline','info'),
          'group'=>esc_html__('Advanced', 'lapindos'),
        ),

      array( 
      'heading' => esc_html__( 'Scroll Spy', 'lapindos' ),
      'param_name' => 'spy',
      'skin'=>'grey',
      'noborder'=> true,
      'class' => '',
      'value' => wp_landing_spy_options(),
      'description' => array(esc_html__( 'Animation when element focused.', 'lapindos' ),'label','info'),
      'type' => 'dropdown',
      'group'=>esc_html__('Advanced', 'lapindos'),
       ),     
      array( 
        'heading' => esc_html__( 'Animation Delay', 'lapindos' ),
        'param_name' => 'scroll_delay',
        'class' => '',
        'default' => '300',
        'description' => esc_html__( 'The number of delay the animation effect of the element. in milisecond', 'lapindos' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'not_empty' => true ),
        'group'=>esc_html__('Advanced', 'lapindos'),       
       ),

        )
 ) );

class LandingBuilderElement_soclean_social extends LandingBuilderElement {

    function render($atts, $content = null, $base = '') {

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'tag'=>'h4',
        'title_align'=>'',
        'spy'=>'',
        'scroll_delay'=>300

      ), $atts , 'soclean_social'));

    $class=array('superclean_social');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

    if($tag=='') $tag= 'h5';
    if('' != $title_align){
      $before_title = '<'.$tag.' class="widgettitle widget-title-'.$title_align.'">';
    }
    else{
      $before_title = '<'.$tag.' class="widgettitle">';
    }

     $atts['title'] = $title;

     $css_style=wp_landing_getElementStyle($atts);

     if(''==$el_id){
            $el_id="element_".wp_landing_getElementTagID();
     }
     
     if(''!=$css_style){
          add_page_css_style("#$el_id {".$css_style."}");
      }

      wp_landing_add_element_margin_style("#$el_id",$atts);

      $scollspy="";
      if('none'!=$spy && $spy!=''){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'soclean_Social', $atts, array( 'widget_id'=>"widget-".$el_id, 'before_title'  => $before_title, 'after_title'  => '</'.$tag.'>' ) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


wp_landing_add_element('soclean_social',
 array( 
    'title' => esc_html__('Lapindos Social Icon','lapindos'),
    'icon'  =>'fa fa-share-alt',
    'color' =>'#2e96db',
    'description'=> esc_html__( "Display social icon link from theme option.",'lapindos'),
    'order'=>51,
    'priority'=>'medium',
    'class' => '',
    'options' => array(
        array( 
          'heading' => esc_html__('Title','lapindos' ),
          'param_name' => 'title',
          'admin_label' => true,
          'class' => '',
          'value' => '',
          'type' => 'textfield'
         ), 
        array( 
          'heading' => esc_html__( 'Title Alignment', 'lapindos' ),
          'param_name' => 'title_align',
          'class' => '',
          'value' => array(
            ''=> array( 'label' => esc_html__('Default','lapindos') ,'position'=>'inline','icon'=> 'fa-align-justify'),
            'left'=> array('label'=>esc_html__( 'Left', 'lapindos' ),'position'=>'inline','icon'=> 'fa-align-left'),
            'center'=> array('label'=>esc_html__( 'Center', 'lapindos' ),'position'=>'inline','icon'=> 'fa-align-center'),
            'right'=>array( 'label'=> esc_html__('Right','lapindos'),'position'=>'inline','icon'=> 'fa-align-right')
            ),
          'type' => 'radiobutton',
          'default'=>'center'
         ), 
        array( 
        'heading' => esc_html__( 'Title Tag', 'lapindos' ),
        'param_name' => 'tag',
        'default' => "",
        'class'=>'thin',
        'value'=>array(
              '' => esc_html__('Default','lapindos'),
              'h1'  => 'H1',
              'h2'  => 'H2',
              'h3'  => 'H3',
              'h4'  => 'H4',
              'h5'  => 'H5',
              'h6'  => 'H6',
              'div' => 'DIV',
              ),
        'inline'=>true,
        'type' => 'radiobutton'
         ),
        array(
          'heading' => esc_html__( 'Icon Skin', 'lapindos' ),
          'param_name' => 'icon_skin',
          'type' => 'radiobutton',
          'default'=>'',
          'value' => lapindos_wp_landing_button_skin(),
          "description" => array( esc_html__("Skin color overwritten at color settings", "lapindos"),'label','info'),
        ),

        array( 
          'heading' => esc_html__( 'Anchor ID', 'lapindos' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => array( esc_html__("Enter anchor ID without pound '#' sign. This filed required id Popup Content activated.", "lapindos"),'','info')
        ),
        array( 
          'heading' => esc_html__( 'Extra CSS class', 'lapindos' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'skin'=>'light',
          'value'=>"",
          ),
        array( 
          'heading' => esc_html__( 'Z-Index', 'lapindos' ),
          'param_name' => 'z_index',
          'type' => 'textfield',
          "description" => array(esc_html__("Enter z-index for adjust z position", "lapindos"),'inline','info'),
        ),
       array( 
          'labels'=>array( esc_html__( 'Any Screen', 'lapindos' ),'inline','large'),
          'param_name' => 'margin_desktop',
          'holder_class'=> array( 'desktop'),
          'type' => 'heading',
          'description' => array( esc_html__( '( Above 1366px )', 'lapindos' ),'inline'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),

        array( 
          'labels'=>array( esc_html__( 'Notebook', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1366px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_notebook',
          'holder_class'=> array('notebook'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_notebook_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_nb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_nb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_nb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_nb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_notebook', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Tablet Landscape', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 1024px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet_landscape',
          'holder_class'=> array('tablet_landscape'),
          'type' => 'switch',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_tablet_landscape_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_tb_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_tb_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_tb_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_tb_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet_landscape', 'value' => '1' ),
        ),              
        array( 
          'labels'=>array( esc_html__( 'Tablet Portrait', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 768px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_tablet',
          'type' => 'switch',
          'holder_class'=> array( 'tablet_portrait' ),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
       array(
          'labels'=>false,
          'param_name' => 'margin_tablet_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_sm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_sm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_sm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_sm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_tablet', 'value' => '1' ),
        ),
        array( 
          'labels'=>array( esc_html__( 'Mobile', 'lapindos' ),'center','large'),
          'description' => array(esc_html__( '( Below 480px )', 'lapindos' ),'inline'),
          'param_name' => 'margin_mobile',
          'type' => 'switch',
          'holder_class'=> array('mobile'),
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
        array(
          'labels'=>false,
          'param_name' => 'margin_mobile_deprecator',
          'type' => 'deprecator',
          'group'=>esc_html__('Margin', 'lapindos'),
        ),
         array( 
          'heading' => esc_html__( 'Top', 'lapindos' ),
          'param_name' => 'm_xs_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Bottom', 'lapindos' ),
          'param_name' => 'm_xs_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Left', 'lapindos' ),
          'param_name' => 'm_xs_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),
        array( 
          'heading' => esc_html__( 'Right', 'lapindos' ),
          'param_name' => 'm_xs_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
          'group'=>esc_html__('Margin', 'lapindos'),
          'dependency' => array( 'element' => 'margin_mobile', 'value' => '1' ),
        ),

        array( 
        'heading' => esc_html__( 'Scroll Spy', 'lapindos' ),
        'param_name' => 'spy',
        'skin'=>'grey',
        'noborder'=> true,
        'class' => '',
        'value' => wp_landing_spy_options(),
        'description' => array(esc_html__( 'Animation when element focused.', 'lapindos' ),'label','info'),
        'type' => 'dropdown',
        'group'=>esc_html__('Advanced', 'lapindos'),
         ),     
        array( 
          'heading' => esc_html__( 'Animation Delay', 'lapindos' ),
          'param_name' => 'scroll_delay',
          'class' => '',
          'default' => '300',
          'description' => esc_html__( 'The number of delay the animation effect of the element. in milisecond', 'lapindos' ),
          'type' => 'textfield',
          'dependency' => array( 'element' => 'spy', 'not_empty' => true ),
          'group'=>esc_html__('Advanced', 'lapindos'),       
         ),


        )
 ) );


function lapindos_wl_section_header($html, $content,$atts){

     if(is_array($atts)){
        $atts['shadow'] = 'text';
      }

      extract(shortcode_atts(array(
          'main_heading' => esc_html__('Title Text Here','lapindos'),
          'text_align'=>'center',
          'color'=>'',
          'hover_color'=>'',
          'hover_shadow_color'=>'',
          'el_id'=>'',
          'el_class'=>'',
          'font_size'=>'',
          'mobile_font_size'=>'',
          'tablet_font_size'=>'',
          'mobile_custom_font_size'=>'',
          'tablet_custom_font_size'=>'',
          'notebook_font_size'=>'',
          'notebook_custom_font_size'=>'',
          'tablet_landscape_font_size'=>'',
          'tablet_landscape_custom_font_size'=>'',
          'font_family'=>'',
          'custom_font_size'=>'',
          'h_shadow'=>'',
          'v_shadow'=>'',
          'blur_shadow'=>'',
          'url'=>'',
          'target'=>'',            
          'tag'=>'h4',
          'text_transform'=>'',            
          'spy'=>'',
          'scroll_delay'=>300,
          'layout'=>'',
          'decoration_placement'=>'',
          'decoration_color'=>'',
          'decoration_custom_color'=>'',
          'hover_anim'=>''
      ), $atts,'wl_section_header'));



      $css_class=array('section-head',$text_align, 'dc-'.$decoration_placement, 'dc-color-'.$decoration_color );
      $heading_hover_style = array();

      if($layout=='border'){
        array_push($css_class, 'heading-decoration');
      }


      if(''==$el_id){
          $el_id="element-".wp_landing_getElementTagID();
      }


      if($url!=''){
          $main_heading = '<a id="link_'.$el_id.'" href="'.esc_url($url).'" class="'.($target=='popup' ? 'popup-link':'').'" target="'.esc_attr($target).'">'.$main_heading.'</a>';
      }

      if(''!=$el_class){
          array_push($css_class, $el_class);
      }

      if('' != $font_size){
        array_push($css_class," size-".$font_size);
        $atts['font_size'] = '';
      }


      $compile="<div ";
      if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
      }

      if($hover_anim!=''){
        $compile.='data-nuno-hover="'.sanitize_html_class($hover_anim).'" ';
      }


      if('none'!=$spy && $spy!=''){
          $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
      }

      if(!empty($custom_font_size) && $font_size=='custom'){

        $atts['font_size'] = $custom_font_size;
      }

      $heading_style=wp_landing_getElementStyle($atts, true);

      if(!empty($text_transform)){
          $heading_style['text-transform']="text-transform:".$text_transform;
      }


      if($hover_color!=''){
        $heading_hover_style['color'] = 'color:'.$hover_color.'!important';
      }

      if($hover_shadow_color!=''){

        $h_shadow = absint($h_shadow);
        $v_shadow = absint($v_shadow);
        $blur_shadow = absint($blur_shadow);

        $heading_hover_style['box-shadow']="text-shadow:".$h_shadow."px ".$v_shadow."px ".$blur_shadow."px ".$hover_shadow_color."!important";
      }


      if(count($heading_hover_style)){
       wp_landing_add_page_css_style("#$el_id .section-main-title:hover{".join(';',$heading_hover_style)."}");
      }

      if($tag=='') $tag= 'h2';

      $compile.='class="'.@implode(" ",$css_class).'"><div>'.
                ((!empty($main_heading))?'<'.$tag.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").' class="section-main-title '.sanitize_html_class($font_family).'">'.$main_heading.'</'.$tag.'>':'').
        '</div></div>';  

      if($mobile_custom_font_size!='' && $font_size=='custom'){
        wp_landing_add_page_css_style( 'mobile', "#$el_id .section-main-title".'{font-size:'.wp_landing_sanitize_font_size($mobile_custom_font_size).'!important;}');
      }

      if($tablet_custom_font_size!='' && $font_size=='custom'){
        wp_landing_add_page_css_style( 'tablet', "#$el_id .section-main-title".'{font-size:'.wp_landing_sanitize_font_size($tablet_custom_font_size).'!important;}');
      }

      if($notebook_custom_font_size!='' && $font_size=='custom'){
        wp_landing_add_page_css_style( 'notebook', "#$el_id .section-main-title".'{font-size:'.wp_landing_sanitize_font_size($notebook_custom_font_size).'!important;}');
      }

      if($tablet_landscape_custom_font_size!='' && $font_size=='custom'){
        wp_landing_add_page_css_style( 'tablet-wd', "#$el_id .section-main-title".'{font-size:'.wp_landing_sanitize_font_size($tablet_landscape_custom_font_size).'!important;}');
      }

      if($layout=='border' && $decoration_color=='custom' && $decoration_custom_color!=''){
        wp_landing_add_page_css_style("#$el_id .section-main-title:before{background:".sanitize_hex_color($decoration_custom_color).";}");
      }


      wp_landing_add_element_margin_style("#$el_id",$atts);

      return $compile;


}


add_filter('wp_landing_button_skin', 'lapindos_wp_landing_button_skin' );

function lapindos_register_nuno_elements(){


    wp_landing_add_element_render( 'wl_section_header','lapindos_wl_section_header');
    wp_landing_add_element_preview( 'wl_section_header','lapindos_wl_section_header');

    wp_landing_add_element_option( 'wl_section_header',
      array( 
        'labels'=> array(esc_html__( 'Decoration', 'lapindos' ),'inline','large'),
        'param_name' => 'heading-decoration',
        'noborder'=> true,
        'type' => 'switch',
        'skin'=>'grey'
      ));

    wp_landing_add_element_option( 'wl_section_header',
      array( 
          'heading' => esc_html__( 'Decoration Style', 'lapindos' ),
          'param_name' => 'layout',
          'default' => '',
          'value'=>array(
            ''=> esc_html__('Default','lapindos'),
            'border'=> esc_html__('Line Decoration','lapindos')
            ),
          'type' => 'radio',
          'inline'=>true,
          'dependency' => array( 'element' => 'heading-decoration', 'value' => '1' ) 
          )
      );


    wp_landing_add_element_option( 'wl_section_header',
      array( 
          'labels' => array( esc_html__( 'Placement', 'lapindos' )),
          'param_name' => 'decoration_placement',
          'default' => '',
          'type' => 'radio',
          'value'=>array(
              'top-left' => esc_html__('Top Left','lapindos'),
              'top-center' => esc_html__('Top Center','lapindos'),
              'top-right' => esc_html__('Top Right','lapindos'),
              'bottom-left' => esc_html__('Bottom Left','lapindos'),
              'bottom-center' => esc_html__('Bottom Center','lapindos'),
              'bottom-right' => esc_html__('Bottom Right','lapindos')
              ),
          'dependency' => array( 'element' => 'heading-decoration', 'value' => '1' ) 
        )
    );

    wp_landing_add_element_option( 'wl_section_header',
      array( 
          'heading' => esc_html__( 'Decoration Color', 'lapindos' ),
          'param_name' => 'decoration_color',
          'description' => array( esc_html__( 'Primary color and secondary color preset on theme option.', 'lapindos' ),'left','info'),
          'default' => 'secondary',
          'class'=>'thin',
          'value'=>array(
            'primary'=> esc_html__('Primary Color','lapindos'),
            'secondary'=> esc_html__('Secondary Color','lapindos'),
            'custom'=> esc_html__('Custom Color','lapindos')
            ),
          'type' => 'radio',
          'inline'=>true,
          'dependency' => array( 'element' => 'heading-decoration', 'value' => '1' ) 
        )
    );

    wp_landing_add_element_option( 'wl_section_header',
      array( 
          'heading' => esc_html__( 'Custom Color', 'lapindos' ),
          'param_name' => 'decoration_custom_color',
          'default' => '',
          'noborder'=>true,
          'type' => 'colorpicker',
          'dependency' => array( 'element' => 'heading-decoration', 'value' => '1' ) 
        )
    );

    wp_landing_add_element_option( 'wl_responsivetab',
      array( 
          'labels'=>array( esc_html__( 'Style', 'lapindos' ),'left'),
          'param_name' => 'panel_style',
          'type' => 'radio',
          'value' => array(
                    ''=>esc_html__('Default','lapindos'),
                    'top-rounded'=>esc_html__('Rounded Top','lapindos'),
                    'rounded'=>esc_html__('Rounded','lapindos'),
                    'capsule'=>esc_html__('Capsule','lapindos'),
                    'underline'=>esc_html__('Underline','lapindos'),
                    'faq'=>esc_html__('Su Clean FAQ','lapindos'),
                    ),
          'group'=>esc_html__('Styles', 'lapindos'),
        ), true
    );

    wp_landing_add_element_option( 'wl_row',
      array( 
          'heading' => esc_html__( 'Extra Function', 'lapindos' ),
          'param_name' => 'extra',
          'type' => 'radiobutton',
          'value' => array(
                    '' => esc_html__('None','lapindos'),
                    'popup-content'=> esc_html__( 'As Popup Content', 'lapindos' ) ,
                    'is_fixed'=> esc_html__( 'Sticky Row', 'lapindos' ),
                    'sticky_offset'=> esc_html__( 'Sticky Menu Offset', 'lapindos' )  
                    ),
          'group'=>esc_html__('Advanced', 'lapindos'),
          'description' => array(esc_html__( 'Extra function to this row.', 'lapindos' ),'label','warning'),
        ), true
    );

    wp_landing_add_element_option( 'wl_row',
      array( 
          'labels' => false,
          'heading' => esc_html__( 'Sticky Menu Offset', 'lapindos' ),
          'param_name' => 'sticky_offset',
          'type' => 'heading',
          'indent'=>true,
          'description' => array(esc_html__( 'The menu go appear after end this row. This option only work if your menu sticky mode.', 'lapindos' ),'','warning'),
          'group'=>esc_html__('Advanced', 'lapindos'),
          'dependency' => array( 'element' => 'extra', 'value' => 'sticky_offset' ),
        ), 'extra'
    );


}

add_action('init', 'lapindos_register_nuno_elements');

function lapindos_custom_breakpoint($grids){

  $desktop_lg = lapindos_get_config('screen-lg-desktop');
  if($desktop_lg!=''){
    $grids['desktop-lg'] = $desktop_lg;
  }

  $desktop = lapindos_get_config('screen-desktop');
  if($desktop!=''){
    $grids['desktop'] = $desktop;
  }

  $tablet = lapindos_get_config('screen-tablet');
  if($tablet!=''){
    $grids['tablet'] = $tablet;
  }

  return $grids;
}

add_filter( 'wp_landing_breakpoint', 'lapindos_custom_breakpoint');
?>