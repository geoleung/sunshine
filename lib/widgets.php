<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

/**
 * widget render
 * @since Lapindos 1.0.0
*/ 

// tag cloud
function lapindos_widget_tag_cloud_args($args=array()){

	$args['smallest']=13;
	$args['largest']=13;
	$args['unit']="px";
	$args['number']= isset($args['number']) ? $args['number'] : 10;
	$args['orderby']="rand";

	return $args;
}

add_filter( 'widget_tag_cloud_args','lapindos_widget_tag_cloud_args');


// calendar widget 
function lapindos_calendar_widget($content=""){
  $pattern = get_shortcode_regex(array('calendar'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
     
	    $atts = shortcode_parse_atts( $matches[3] );

		$type = \'WP_Widget_Calendar\';
		$args = array(
			\'before_widget\' => \'<div class="widget widget_calendar">\',
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


// add tag cloud function

function lapindos_tag_cloud($content=""){

  $pattern = get_shortcode_regex(array('tags'));
  $content = preg_replace_callback( '/' . $pattern . '/s',

  create_function('$matches', '
      
	    $atts = shortcode_parse_atts( $matches[3] );

		$type = \'WP_Widget_Tag_Cloud\';
		$args = array(
			\'before_widget\' => \'<div class="widget widget_tag_cloud">\',
			\'after_widget\' => \'</div>\',
			\'before_title\' => \'<div class="widget-title">\',
			\'after_title\' => \'</div>\'
			);

		ob_start();
		the_widget( $type, $atts, $args );
		$content = ob_get_clean();

	    return $content;
    '),
    $content);

  return $content;
}

/**  Optin **/

class soclean_Optin extends WP_Widget{

	function __construct() {
		$widget_ops = array('classname' => 'superclean_optin', 'description' => esc_html__( "Display optin form from newsletter engine like mailchimp",'lapindos') );
		parent::__construct('soclean_Optin', esc_html__('Optin Form','lapindos'), $widget_ops);

		$this->alt_option_name = 'soclean_Optin';

	}

	function widget($args, $instance){

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'soclean_Optin', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}
		
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : "";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$layout = array_key_exists('layout',$instance) ?  sanitize_text_field( $instance['layout'] ) : '';
		$show_name = array_key_exists('show_name',$instance) ?  absint( $instance['show_name'] ) : '';
		$before_form = array_key_exists('before_form',$instance) ?   $instance['before_form'] : '';
		$after_form = array_key_exists('after_form',$instance) ?   $instance['after_form'] : '';
		$optin_form = array_key_exists('optin_form',$instance) ?   $instance['optin_form'] : '';
		$button_skin = array_key_exists('button_skin',$instance) ?   $instance['button_skin'] : 'secondary';


		ob_start();
		
		echo wp_kses_post($before_widget); 
		if ( $title ) echo wp_kses_post($before_title . $title . $after_title);?>
<div class="optin-body">
	<?php print esc_js($before_form);?>

<form class="optin-form <?php print ($layout=='horizontal') ? "form-inline":"";?>" method="post">
  <div class="form-group">
    <input type="email" class="form-control"  name="optin_email" placeholder="<?php esc_attr_e( 'enter your email','lapindos' );?>" />
  </div><?php if($show_name):?><div class="form-group">
    <input type="text" class="form-control"  name="optin_name" placeholder="<?php esc_attr_e( 'enter your name','lapindos' );?>" />
  </div><?php endif;?><div class="form-group">
	  <button type="submit" class="btn optin-submit btn-skin-<?php print sanitize_html_class($button_skin);?>"><i class="fa fa-envelope"></i></button>
	</div>
</form>
		

	<?php print esc_js($after_form);?>
	<div class="optin-code">
		<?php print ent2ncr($optin_form);?>
	</div>
</div>
		<?php echo wp_kses_post($after_widget);

		


		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'soclean_Optin', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

 ?>
<?php
	}

	function form($instance){

		$title  = array_key_exists('title',$instance) ?  esc_attr( $instance['title'] ) : '';
		$layout = array_key_exists('layout',$instance) ?  sanitize_text_field( $instance['layout'] ) : '';
		$show_name = array_key_exists('show_name',$instance) ?  absint( $instance['show_name'] ) : '';
		$before_form = array_key_exists('before_form',$instance) ?   $instance['before_form'] : '';
		$after_form = array_key_exists('after_form',$instance) ?   $instance['after_form'] : '';
		$optin_form = array_key_exists('optin_form',$instance) ?   $instance['optin_form'] : '';
		$button_skin = array_key_exists('button_skin',$instance) ?   $instance['button_skin'] : '';

?>
		<p><label for="<?php print esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','lapindos'); ?></label>
		<input class="widefat" id="<?php print esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'layout' )); ?>"><?php esc_html_e( 'Layout:','lapindos'); ?></label>
			<select id="<?php print esc_attr($this->get_field_id( 'layout' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'layout' )); ?>" >
					<option value="vertical" <?php selected('vertical',$layout);?>><?php esc_html_e('Vertical','lapindos');?></option>
					<option value="horizontal" <?php selected('horizontal',$layout);?>><?php esc_html_e('Horizontal','lapindos');?></option>
			</select>
		</p>		
		<p><input id="<?php print esc_attr($this->get_field_id( 'show_name' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'show_name' )); ?>" type="checkbox" value="1" <?php checked(1,$show_name);?>/> 
		<label for="<?php print esc_attr($this->get_field_id( 'show_name' )); ?>"><?php esc_html_e( 'Show Name','lapindos'); ?></label>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'before_form' )); ?>"><?php esc_html_e( 'Text before form:','lapindos'); ?></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'before_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'before_form' )); ?>" rows="5"><?php echo esc_attr($before_form); ?></textarea>
		<?php esc_html_e('Simplae html allowed','lapindos');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'after_form' )); ?>"><?php esc_html_e( 'Text after form:','lapindos'); ?></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'after_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'after_form' )); ?>" rows="5"><?php echo esc_attr($after_form); ?></textarea>
		<?php esc_html_e('Simplae html allowed','lapindos');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'optin_form' )); ?>"><strong><?php esc_html_e( 'Optin code:','lapindos'); ?></strong></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'optin_form' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'optin_form' )); ?>" rows="5"><?php echo esc_attr($optin_form); ?></textarea>
		<?php esc_html_e('Put optin code from your provider, usualy strarting with form tag without javascript code.','lapindos');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'button_skin' )); ?>"><?php esc_html_e( 'Button Skin:','lapindos'); ?></label>
<?php $skins = lapindos_wp_landing_button_skin();?>			
			<select id="<?php print esc_attr($this->get_field_id( 'button_skin' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'button_skin' )); ?>" >
					<?php foreach ($skins as $skin => $label) {?>
					<option value="<?php print esc_attr($skin); ?>" <?php selected($skin,$button_skin);?>><?php print esc_html($label);?></option>
					<?php }?>
			</select>
		</p>			
		
<?php


	}


}

/** Social Widget **/
class soclean_Social extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'soclean_widget_social', 'description' => esc_html__( "Display social icon link.",'lapindos') );
		parent::__construct('soclean_social', esc_html__('Lapindos Social Icon','lapindos'), $widget_ops);
		$this->alt_option_name = 'soclean_social';
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$icon_skin = array_key_exists('icon_skin',$instance) ?   $instance['icon_skin'] : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','lapindos' ); ?></label>
		<input class="widefat" id="<?php echo sanitize_title($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><?php esc_html_e( 'Social link define on Appearance > Theme Options > Social Link','lapindos'); ?></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'icon_skin' )); ?>"><?php esc_html_e( 'Color Skin:','lapindos'); ?></label>
<?php $skins = lapindos_wp_landing_button_skin();?>			
			<select id="<?php print esc_attr($this->get_field_id( 'icon_skin' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'icon_skin' )); ?>" >
					<?php foreach ($skins as $skin => $label) {?>
					<option value="<?php print esc_attr($skin); ?>" <?php selected($skin,$icon_skin);?>><?php print esc_html($label);?></option>
					<?php }?>
			</select>
		</p>		
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		$instance['icon_skin'] = sanitize_html_class($new_instance['icon_skin']);

		return $instance;
	}



	public function widget( $args, $instance ) {


		extract($args);
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = $this->id;
		
	    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$widget_id = $args['widget_id'];
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$icon_skin = array_key_exists('icon_skin',$instance) ?   $instance['icon_skin'] : '';

	    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] :"";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		echo wp_kses_post($before_widget);
		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title);
		}


		echo lapindos_get_sociallinks(array('show_label'=>false,'skin'=>$icon_skin));
  
        echo wp_kses_post($after_widget);
	}
}


/** service category **/
class soclean_service_category extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_categories', 'description' => esc_html__( "A list or dropdown of service categories.",'lapindos') );
		parent::__construct('soclean_service_category', esc_html__('Service Categories','lapindos'), $widget_ops);
		$this->alt_option_name = 'soclean_service_category';
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','lapindos' ); ?></label>
		<input class="widefat" id="<?php echo sanitize_title($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}



	public function widget( $args, $instance ) {


		extract($args);
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = $this->id;
		
	    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$widget_id = $args['widget_id'];
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';


	    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] :"";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		echo wp_kses_post($before_widget);
		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title);
		}

		$cat_args = array(
			'title_li'=>'',
			'taxonomy'=> 'service_cat'
			);
?>
		<ul>
<?php
		wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
?>
		</ul>
<?php


  
        echo wp_kses_post($after_widget);
	}
}

/**  Optin **/

class soclean_cta extends WP_Widget{

	function __construct() {
		$widget_ops = array('classname' => 'superclean_cta', 'description' => esc_html__( "Display call to action widget",'lapindos') );
		parent::__construct('soclean_cta', esc_html__('Lapindos CTA','lapindos'), $widget_ops);

		$this->alt_option_name = 'soclean_cta';

	}

	function widget($args, $instance){

		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'soclean_cta', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}
		
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : "";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$text_content = array_key_exists('text_content',$instance) ?   $instance['text_content'] : '';
		$button_text = array_key_exists('button_text',$instance) ?   $instance['button_text'] : '';
		$button_link = array_key_exists('button_link',$instance) ?   $instance['button_link'] : '';
		$box_background = array_key_exists('box_background',$instance) ?   $instance['box_background'] : '';
		$button_skin = array_key_exists('button_skin',$instance) ?   $instance['button_skin'] : '';



		ob_start();
		
		echo wp_kses_post($before_widget); 
		?>
<div class="suclean-cta background-<?php print sanitize_html_class($box_background);?>">
<?php if ( $title ) echo '<h4 class="cta-title">'.esc_html($title).'</h4>';?>
<p class="cta-text">
	<?php print esc_js($text_content);?>
</p>
<a href="<?php print esc_url($button_link);?>" class="btn btn-<?php print sanitize_html_class($button_skin);?> shape-square"><?php print wp_kses_post($button_text);?></a>		
</div>
		<?php echo wp_kses_post($after_widget);

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'soclean_cta', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

 ?>
<?php
	}

	function form($instance){

		$title  = array_key_exists('title',$instance) ?  esc_attr( $instance['title'] ) : '';
		$text_content = array_key_exists('text_content',$instance) ?   $instance['text_content'] : '';
		$button_text = array_key_exists('button_text',$instance) ?   $instance['button_text'] : '';
		$box_background = array_key_exists('box_background',$instance) ?   $instance['box_background'] : '';
		$button_link = array_key_exists('button_link',$instance) ?   $instance['button_link'] : '';
		$button_skin = array_key_exists('button_skin',$instance) ?   $instance['button_skin'] : '';

?>
		<p><label for="<?php print esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','lapindos'); ?></label>
		<input class="widefat" id="<?php print esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'text_content' )); ?>"><?php esc_html_e( 'Text Content:','lapindos'); ?></label>
		<textarea class="widefat" id="<?php print esc_attr($this->get_field_id( 'text_content' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'text_content' )); ?>" rows="5"><?php echo esc_attr($text_content); ?></textarea>
		<?php esc_html_e('Simple html allowed','lapindos');?>
		</p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'box_background' )); ?>"><?php esc_html_e( 'Box Background:','lapindos'); ?></label>
			<select id="<?php print esc_attr($this->get_field_id( 'box_background' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'box_background' )); ?>" >
					<option value="" <?php selected('',$box_background);?>><?php esc_html_e('None','lapindos');?></option>
					<option value="primary" <?php selected('primary',$box_background);?>><?php esc_html_e('Primary Color','lapindos');?></option>
					<option value="secondary" <?php selected('secondary',$box_background);?>><?php esc_html_e('Secondary Color','lapindos');?></option>
					<option value="third" <?php selected('third',$box_background);?>><?php esc_html_e('Thirdy Color','lapindos');?></option>
			</select><br/>
			<?php esc_html_e('The color defined on Theme Options.','lapindos');?>
		</p>		

		<p><label for="<?php print esc_attr($this->get_field_id( 'button_link' )); ?>"><strong><?php esc_html_e( 'Button URL:','lapindos'); ?></strong></label>
		<input class="widefat" id="<?php print esc_attr($this->get_field_id( 'button_link' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'button_link' )); ?>" type="text" value="<?php echo esc_attr($button_link); ?>"/></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'button_text' )); ?>"><strong><?php esc_html_e( 'Button Text:','lapindos'); ?></strong></label>
		<input class="widefat" id="<?php print esc_attr($this->get_field_id( 'button_text' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'button_text' )); ?>" type="text" value="<?php echo esc_attr($button_text); ?>"/></p>
		<p><label for="<?php print esc_attr($this->get_field_id( 'button_skin' )); ?>"><?php esc_html_e( 'Button Skin:','lapindos'); ?></label>
<?php $skins = lapindos_wp_landing_button_skin();?>			
			<select id="<?php print esc_attr($this->get_field_id( 'button_skin' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'button_skin' )); ?>" >
					<?php foreach ($skins as $skin => $label) {?>
					<option value="<?php print esc_attr($skin); ?>" <?php selected($skin,$button_skin);?>><?php print esc_html($label);?></option>
					<?php }?>
			</select>
		</p>			
<?php


	}


}


/**  Optin **/

class soclean_wp_menu extends WP_Widget{

	function __construct() {
		$widget_ops = array('classname' => 'superclean_nav_menu', 'description' => esc_html__( "Add a navigation menu to your sidebar.",'lapindos') );
		parent::__construct('soclean_wp_menu', esc_html__('Lapindos Menu','lapindos'), $widget_ops);

		$this->alt_option_name = 'soclean_wp_menu';

	}

	function widget($args, $instance){

		$cache = array();

		$nav_menu = ( ! empty( $instance['nav_menu'] ) ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( ! $nav_menu ) {
			return;
		}

		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'soclean_wp_menu', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}
		
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : "";
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );


		ob_start();
		
		echo wp_kses_post($before_widget); 

		if ( $title ) {
			echo wp_kses_post($before_title . $title . $after_title);
		}

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu
		);

		wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

		echo wp_kses_post($after_widget);

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'soclean_wp_menu', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

 ?>
<?php
	}

	function form($instance){

		global $wp_customize;

		$title  = array_key_exists('title',$instance) ?  esc_attr( $instance['title'] ) : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		// Get menus
		$menus = wp_get_nav_menus();

		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<?php
			if ( $wp_customize instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}
			?>
			<?php echo sprintf( esc_html__( 'No menus have been created yet. <a href="%s">Create some</a>.' ,'lapindos'), esc_attr( $url ) ); ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ,'lapindos') ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>"><?php esc_html_e( 'Select Menu:' ,'lapindos'); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>" name="<?php echo wp_strip_all_tags($this->get_field_name( 'nav_menu' )); ?>">
					<option value="0"><?php esc_html_e( '&mdash; Select &mdash;' ,'lapindos'); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
				<p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) { echo 'display: none;'; } ?>">
					<button type="button" class="button"><?php esc_html_e( 'Edit Menu','lapindos' ) ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}
		return $instance;
	}


}

add_filter( 'widget_text' ,'lapindos_calendar_widget');
add_filter( 'widget_text' ,'lapindos_tag_cloud');
add_filter( 'widget_text', 'do_shortcode' );


function lapindos_widget_title_empty($title='', $instance=array() ){

	if(isset($instance['title']) && $instance['title']=='') return '';

	return $title;
}

add_filter( 'widget_title', 'lapindos_widget_title_empty',999,2);


// image caption

function lapindos_shortcode_atts_caption($atts){

	$atts['caption'] = "<span class=\"caption-wrapper\">".$atts['caption']."</span>";
	return $atts;
}

add_filter('shortcode_atts_caption','lapindos_shortcode_atts_caption');


function lapindos_register_widgets(){
	 register_widget('soclean_Social');
	 register_widget('soclean_Optin');
	 register_widget('soclean_cta');
 	 register_widget('soclean_wp_menu');


    if (class_exists('petro_service')){
	 register_widget('soclean_service_category');
	}
}

// widget init
add_action('widgets_init', 'lapindos_register_widgets',1);

?>
