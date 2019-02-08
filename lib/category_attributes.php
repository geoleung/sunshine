<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

/**
 * category attributes
 * @since Lapindos 1.0.0
*/ 

if(!function_exists('lapindos_exctract_glyph_from_file')){

  function lapindos_exctract_glyph_from_file($file="",$pref=""){

    $wp_filesystem=new WP_Filesystem_Direct(array());

    if(!$wp_filesystem->is_file($file) || !$wp_filesystem->exists($file))
        return false;

     if ($buffers=$wp_filesystem->get_contents_array($file)) {
       $icons=array();

      foreach ($buffers as $line => $buffer) {

        if(preg_match("/^(\.".$pref.")([^:\]\"].*?):before/i",$buffer,$out)){

          if($out[2]!==""){
              $icons[$pref.$out[2]]=$pref.$out[2];
          }
        }
      }
      return $icons;

    }else{

      return false;
    }
  }
}


function lapindos_get_glyph_lists($path){

  $wp_filesystem=new WP_Filesystem_Direct(array());

  $icons=array();
  if($dirlist=$wp_filesystem->dirlist($path)){
    foreach ($dirlist as $dirname => $dirattr) {

       if($dirattr['type']=='d'){
          if($dirfont=$wp_filesystem->dirlist($path.$dirname)){
            foreach ($dirfont as $filename => $fileattr) {
              if(preg_match("/(\.css)$/", $filename)){
                if($icon=lapindos_exctract_glyph_from_file($path.$dirname."/".$filename)){

                  $icons=@array_merge($icon,$icons);
                }
                break;
              }
             
            }
          }
        }
        elseif($dirattr['type']=='f' && preg_match("/(\.css)$/", $dirname)){

          if($icon=lapindos_exctract_glyph_from_file($path.$dirname)){
              $icons=@array_merge($icon,$icons);
          }

      }

    }
  }
  return $icons;
}


function lapindos_add_category_image($taxonomy){
    wp_enqueue_media();

    $dummy_image=get_template_directory_uri()."/lib/placeholder.png";

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;


?>
    <div class="form-field">
        <label for="category_image"><?php printf(esc_html__( '%s Image', 'lapindos' ),$tax_name); ?></label>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $dummy_image ); ?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" />
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'lapindos' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'lapindos' ); ?></button>
        </div>
      <div class="clear"></div>
    </div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    'use strict';

    if ( ! $( '#category_image_id' ).val() ) {
        $( '.remove_image_button' ).hide();
    }

    var file_frame;

    $( document ).on( 'click', '.upload_image_button', function( event ) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: '<?php print esc_js( esc_html__( "Choose an image", "lapindos" )); ?>',
            button: {
                text: '<?php print esc_js( esc_html__( "Use image", "lapindos" )); ?>'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();

            $( '#category_image_id' ).val( attachment.id );
            $( '#category_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });
});

</script>

<?php
}

function lapindos_edit_category_image($tag, $taxonomy){
    wp_enqueue_media();

    $category_image=get_metadata('term', $tag->term_id, '_thumbnail_id', true);
    $image_url=get_template_directory_uri()."/lib/placeholder.png";

    if($category_image){
      $image = wp_get_attachment_image_src( $category_image, array( 266,266 ));
      if($image)
        $image_url=$image[0];
    }

    $tax = get_taxonomy($taxonomy);
    $tax_name = $tax->labels->singular_name;
?>
<table class="form-table">
    <tbody><tr class="form-field form-required term-name-wrap">
      <th scope="row"><label for="category_image"><?php printf(esc_html__( '%s Image', 'lapindos' ),$tax_name); ?></label></th>
      <td>
        <div id="category_image"><img class="btn btn-link upload_image_button" src="<?php echo esc_url( $image_url ); ?>" width="200px"  /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="category_image_id" name="category_image_id" value="<?php print ($category_image)? $category_image:"";?>"/>
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'lapindos' ); ?></button>
            <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'lapindos' ); ?></button>
        </div>
      </td>
    </tr>
    </tbody>
</table>
<script type="text/javascript">
jQuery(document).ready(function($) {
    'use strict';

    if ( ! $( '#category_image_id' ).val() ) {
        $( '.remove_image_button' ).hide();
    }

    var file_frame;

    $( document ).on( 'click', '.upload_image_button', function( event ) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.downloadable_file = wp.media({
            title: '<?php print esc_js( esc_html__( "Choose an image", "lapindos" )); ?>',
            button: {
                text: '<?php print esc_js( esc_html__( "Use image", "lapindos" )); ?>'
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            var attachment = file_frame.state().get( 'selection' ).first().toJSON();

            $( '#category_image_id' ).val( attachment.id );
            $( '#category_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
            $( '.remove_image_button' ).show();
        });

        // Finally, open the modal.
        file_frame.open();
    });
});

</script>

<?php
}

function lapindos_save_category_image($term_id,$tt_id="",$taxonomy=""){

    if($taxonomy=='category' || $taxonomy=='post_tag'){

       $old = get_metadata( 'term', $term_id, '_thumbnail_id', true );
       $new = (isset($_POST['category_image_id']))?absint($_POST['category_image_id']):'';
       $updated=update_metadata('term', $term_id, '_thumbnail_id', $new,$old );
    }
}

function lapindos_save_service_params($term_id,$tt_id="",$taxonomy=""){

    if($taxonomy=='service_cat'){

       $old = get_metadata( 'term', $term_id, '_hide_sidebar', true );
       $new = (isset($_POST['hide_sidebar']))? absint($_POST['hide_sidebar']):'';
       $updated=update_metadata('term', $term_id, '_hide_sidebar', $new,$old );

       $old = get_metadata( 'term', $term_id, '_service_layout', true );
       $new = (isset($_POST['service_layout']))? trim($_POST['service_layout']):'';
       $updated=update_metadata('term', $term_id, '_service_layout', $new,$old );

       $old = get_metadata( 'term', $term_id, '_rich_description', true );
       $rich_description = (isset($_POST['rich_description']))? trim($_POST['rich_description']):'';
       $updated=update_metadata('term', $term_id, '_rich_description', $rich_description, $old );
    }
}


function lapindos_edit_service_params($tag, $taxonomy){

    $hide_sidebar=get_metadata('term', $tag->term_id, '_hide_sidebar', true);
    $service_layout=get_metadata('term', $tag->term_id, '_service_layout', true);
    $rich_description=get_metadata('term', $tag->term_id, '_rich_description', true);
?>
<table class="form-table">
    <tbody>
      <tr class="form-field form-required">
      <th scope="row"><label for="rich-tag-description"><?php esc_html_e( 'Rich Description', 'lapindos' ); ?></label></th>
      <td style="position: relative;">
<?php

  wp_editor( $rich_description, 'rich_description', array(
  '_content_editor_dfw' => true,
  'drag_drop_upload' => true,
  'media_buttons'=>false,
  'editor_height' => 300,
  'tinymce' => array(
    'resize' => false,
    'wp_autoresize_on' => true,
    'add_unload_trigger' => false,
  ),
) ); 

        ?></td>
      </tr>
      <tr class="form-field form-required">
      <th scope="row"><label for="hide_sidebar"><?php esc_html_e( 'Sidebar', 'lapindos' ); ?></label></th>
      <td style="position: relative;"><input type="checkbox" id="hide_sidebar" name="hide_sidebar" value="1" <?php checked(1,$hide_sidebar);?>/><?php esc_html_e('Hide the sidebar','lapindos'); ?>
        <p class="description"><?php esc_html_e('This option will forcing hide the sidebar.','lapindos');?></p></td>
      </tr>
      <tr class="form-field form-required">
      <th scope="row"><label for="service_layout"><?php esc_html_e( 'Layout', 'lapindos' ); ?></label></th>
      <td style="position: relative;">
        <select id="service_layout" name="service_layout">
          <option value=""><?php esc_html_e('Default','lapindos');?></option>
          <option value="1" <?php selected('1',$service_layout );?>><?php esc_html_e('1 Column','lapindos');?></option>
          <option value="2" <?php selected('2',$service_layout );?>><?php esc_html_e('2 Columns','lapindos');?></option>
          <option value="3" <?php selected('3',$service_layout );?>><?php esc_html_e('3 Columns','lapindos');?></option>
          <option value="chess" <?php selected('chess',$service_layout );?>><?php esc_html_e('Chess','lapindos');?></option>
        </select>
        <p class="description"><?php esc_html_e('This option will overwrite theme option.','lapindos');?></p></td>
      </tr>
    </tbody>
</table>
<?php
}

function lapindos_add_service_params($taxonomy){

?>
<div class="form-field" style="position: relative;">
  <label for="rich-tag-description"><?php esc_html_e( 'Rich Description', 'lapindos' ); ?></label>
<?php

  wp_editor( '', 'rich_description', array(
  '_content_editor_dfw' => true,
  'drag_drop_upload' => true,
  'media_buttons'=>false,
  'editor_height' => 300,
  'tinymce' => array(
    'resize' => false,
    'wp_autoresize_on' => true,
    'add_unload_trigger' => false,
  ),
) ); 
?>
</div>
<div class="form-field" style="position: relative;">
    <label for="hide_sidebar"><?php esc_html_e( 'Sidebar', 'lapindos' ); ?></label>
     <input type="checkbox" id="hide_sidebar" name="hide_sidebar" value="1" /><?php esc_html_e('Hide the sidebar','lapindos'); ?>
        <p class="description"><?php esc_html_e('This option will forcing hide the sidebar.','lapindos');?></p>
  <div class="clear"></div>
</div>
<div class="form-field" style="position: relative;">
    <label for="service_layout"><?php esc_html_e( 'Layout', 'lapindos' ); ?></label>
     <select id="service_layout" name="service_layout">
          <option value=""><?php esc_html_e('Default','lapindos');?></option>
          <option value="1" ><?php esc_html_e('1 Column','lapindos');?></option>
          <option value="2" ><?php esc_html_e('2 Columns','lapindos');?></option>
          <option value="3" ><?php esc_html_e('3 Columns','lapindos');?></option>
          <option value="chess" ><?php esc_html_e('Chess','lapindos');?></option>
        </select>
        <p class="description"><?php esc_html_e('This option will overwrite theme option.','lapindos');?></p>
  <div class="clear"></div>
</div>
<?php
}



/* wp 4.4 >= */
if(get_option( 'db_version' ) >= 34370 ) {
    add_action( 'category_add_form_fields', 'lapindos_add_category_image');
    add_action( 'category_edit_form', 'lapindos_edit_category_image',10,2);
    add_action( 'edit_term', 'lapindos_save_category_image' , 10, 3 );
    add_action( 'created_term', 'lapindos_save_category_image' , 10, 3 );

    add_action( 'post_tag_add_form_fields', 'lapindos_add_category_image');
    add_action( 'post_tag_edit_form', 'lapindos_edit_category_image',10,2);
    add_action( 'edit_term', 'lapindos_save_category_image' , 10, 3 );
    add_action( 'created_term', 'lapindos_save_category_image' , 10, 3 );

    if (class_exists('petro_service')){

      add_action( 'service_cat_add_form_fields', 'lapindos_add_service_params');
      add_action( 'service_cat_edit_form', 'lapindos_edit_service_params',10,2);
      add_action( 'edit_term', 'lapindos_save_service_params', 10, 3 );
      add_action( 'created_term', 'lapindos_save_service_params', 10, 3 );
    }
}
