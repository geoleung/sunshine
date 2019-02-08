<?php
defined('ABSPATH') or die();
/** @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

function lapindos_wc_body_class( $classes ) {
  $classes = (array) $classes;

  $col="";

  if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) {

    $col=lapindos_get_config('shop_column',3);
  }
  elseif(is_product()){

    $col=lapindos_get_config('loop_related_columns',3);
  }

  if($col!='') {
    $classes[] = 'columns-'.$col;
  }

  return array_unique( $classes );
}


function lapindos_related_products_args($args){

  $col=lapindos_get_config('loop_related_columns',3);

  if($related_per_page=lapindos_get_config('loop_related_per_page')){
    $args['posts_per_page']=$related_per_page;  
  }

  $args['columns']=$col;
  return $args;

}

function lapindos_woocommerce_account_settings($settings=array()){

  if(is_array($settings) && count($settings)){

    $newsettings=array();

    foreach ($settings as $key => $setting) {

      if(isset($setting['id']) && 'woocommerce_enable_myaccount_registration'==$setting['id']){

                array_push($newsettings,
                    array(
                      'title'    => esc_html__( 'Registration page', 'lapindos' ),
                      'desc'     => sprintf( __( 'Page contents: [%s]', 'lapindos' ), apply_filters( 'lapindos_woocommerce_registration_shortcode_tag', 'lapindos_woocommerce_registration' ) ),
                      'id'       => 'woocommerce_registration_page_id',
                      'type'     => 'single_select_page',
                      'default'  => '',
                      'class'    => 'wc-enhanced-select',
                      'css'      => 'min-width:300px;',
                      'desc_tip' => true,
                    )
                );

                continue;

      }

      array_push($newsettings, $setting);


    }

    return $newsettings;

  }

  return $settings;
}


function lapindos_woocommerce_order_button_html(){
  $order_button_text  = apply_filters( 'woocommerce_order_button_text', esc_html__( 'Place order', 'lapindos' ));
  $button_html='<input type="submit" class="button woocommerce-button" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />';
  return $button_html;

}

function lapindos_woocommerce_product_review_comment_form_args($comment_form=array()){

  $comment_form['class_submit']='btn btn-inline btn-primary';
  return $comment_form;
}

function lapindos_woocommerce_product_additional_information_tab_title(){

    $tab_title=esc_html__('Specification','lapindos');

    return $tab_title;
}

function lapindos_woocommerce_product_additional_information_heading(){

  return esc_html__('Specification','lapindos');
}

function lapindos_woocommerce_product_description_heading(){

  return esc_html__('Description','lapindos');
}


/* hide page title */
add_filter('woocommerce_show_page_title',create_function('','return false;'));



function lapindos_registration_form($content){

  $pattern = get_shortcode_regex(array('lapindos_woocommerce_registration'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
      ob_start();
      wc_get_template( \'myaccount/form-registration.php\' );
      $content = ob_get_clean();

      return $content;
    ')
  , 
  $content);


  return $content;

}

function lapindos_woocommerce_review_order_before_payment_title(){
?>
<h3 id="review_order_payment_heading"><?php esc_html_e('Payment Method','lapindos');?></h3>
<?php
}

function lapindos_woocommerce_is_account_page($account_page){

  $page_id = get_the_ID();

  if(! $page_id) return $account_page;

  if($page_id == get_option('woocommerce_registration_page_id')) return true;

  return $account_page;
}

function lapindos_shop_set_posts_per_page($query) {

  if(  $query->get( 'post_type' ) !='product'  || $query->is_home() || is_admin()) return;

    if ( !$query->is_main_query() || !($posts_per_page = lapindos_get_config('shop_per_page'))) {
      return;
    }

    $query->set( 'posts_per_page', $posts_per_page );
}

if(function_exists('is_shop')){

add_action( 'pre_get_posts' , 'lapindos_shop_set_posts_per_page');
add_action( 'woocommerce_review_order_before_payment', 'lapindos_woocommerce_review_order_before_payment_title');

add_filter( 'woocommerce_product_description_heading', create_function('$heading','return "";'));
add_filter( 'woocommerce_product_additional_information_heading', create_function('$heading','return "";'));
add_filter( 'the_content' , 'lapindos_registration_form');
add_filter( 'woocommerce_product_description_heading', 'lapindos_woocommerce_product_description_heading' );
add_filter( 'woocommerce_product_additional_information_heading', 'lapindos_woocommerce_product_additional_information_heading' );
add_filter( 'woocommerce_product_additional_information_tab_title', 'lapindos_woocommerce_product_additional_information_tab_title' );
add_filter( 'woocommerce_output_related_products_args', 'lapindos_related_products_args' );
add_filter( 'body_class', 'lapindos_wc_body_class' );
add_filter( 'loop_shop_columns',create_function('$column','return max(2, lapindos_get_config(\'shop_column\',$column));'));
add_filter( 'woocommerce_account_settings','lapindos_woocommerce_account_settings');
add_filter( 'woocommerce_order_button_html', 'lapindos_woocommerce_order_button_html');
add_filter( 'woocommerce_product_review_comment_form_args', 'lapindos_woocommerce_product_review_comment_form_args' );
add_filter( 'woocommerce_is_account_page', 'lapindos_woocommerce_is_account_page');

}
?>