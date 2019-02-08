<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Multi_Text
 * @author      Atawai
 * @version     3.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
// Don't duplicate me!
if( !class_exists( 'ReduxFramework_icon_multi_text' ) ) {

    /**
     * Main ReduxFramework_multi_text class
     *
     * @since       1.0.0
     */
    class ReduxFramework_icon_multi_text {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            $this->add_text = ( isset($this->field['add_text']) ) ? $this->field['add_text'] : esc_html__( 'Add More', 'lapindos');
            
            $this->show_empty = ( isset($this->field['show_empty']) ) ? $this->field['show_empty'] : true;
            $sortable = (isset($this->field['sortable']) && $this->field['sortable']) ? (bool)$this->field['sortable'] : false;
            $fields= (isset($this->field['fields']) && is_array($this->field['fields'])) ? (array)$this->field['fields'] : array('label' => '');

            echo '<div';
            echo ( (bool)$sortable ) ? ' class="redux-container-sortable"' : '';
            echo '>';

            echo '<ul id="' . $this->field['id'] . '-ul" class="redux-icon-multi-text '.($sortable?'redux-sortable':'').'">';

                if( isset( $this->value ) && is_array( $this->value ) ) {

                    $i=0;
                    foreach( $this->value as $k => $value ) {

                        $value=wp_parse_args($value,array('icon'=>''));

                        echo '<li>'.($value['icon']!=''?'<div class="icon-selection-preview"><i class="'.esc_attr( $value['icon'] ).'"></i></div>':'');


                        foreach($fields as $field => $label){
                            echo "<div class=\"redux-icon-multi-text-field\">";
                            echo isset($label) ? "<label for=\"icon-".$field."\">".$label."</label>" : "";
                            echo '<input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'].'['.$i.']['.$field.']" value="' . esc_attr( isset($value[$field]) ? $value[$field] : '' ) . '" class="regular-text ' . $this->field['class'] . '" /> ';
                            echo "</div>";    
                        }

                        echo '<input type="hidden" name="' . $this->field['name']. '['.$i.'][icon]" value="'.esc_attr( $value['icon'] ).'" class="icon-field" />'.
                            '<a href="javascript:;" class="redux-icon-multi-text-edit">'.esc_html__('Edit Icon','lapindos').'</a> <a href="javascript:void(0);" class="deletion redux-icon-multi-text-remove">' . esc_html__( 'Remove', 'lapindos' ) . '</a>'.
                            ($sortable?' <span class="compact drag"><i class="el el-move icon-large"></i></span> ':'').'</li>';

                        $i++;

                    }
                } elseif($this->show_empty == true ) {
                   echo '<li><div class="icon-selection-preview"><i class=""></i></div>';

                        foreach($fields as $field => $label){
                            echo "<div class=\"redux-icon-multi-text-field\">";
                            echo isset($label) ? "<label for=\"icon-".$field."\">".$label."</label>" : "";
                            echo '<input type="text" id="' . $this->field['id'] .'" name="'.$this->field['name'].  '[0]['.$field.']" value="" class="regular-text ' . $this->field['class'] . '" /> ';
                            echo "</div>";    
                        }

                   echo '<input type="hidden" name="'  . $this->field['name']. '[0][icon]" value="" class="icon-field" /><a href="javascript:;" class="redux-icon-multi-text-edit">'.esc_html__('Edit Icon','lapindos').'</a> <a href="javascript:void(0);" class="deletion redux-icon-multi-text-remove">' . esc_html__( 'Remove', 'lapindos' ) . '</a>'.
                    ($sortable?' <span class="compact drag ui-sortable-handle"><i class="el el-move icon-large"></i></span> ':'').'</li>';
                }
            
                echo '<li style="display:none;">';


                foreach($fields as $field => $label){
                    echo "<div class=\"redux-icon-multi-text-field\">";
                    echo isset($label) ? "<label for=\"icon-".$field."\">".$label."</label>" : "";
                    echo '<input type="text" id="' . $this->field['id'] . '" data-field="' .$field.'" value="" class="regular-text ' . $this->field['class'] . '" /> ';
                    echo "</div>";    
                }


                echo '<input type="hidden" name="" value="" class="icon-field" />'.
                '<a href="javascript:;" class="redux-icon-multi-text-edit">'.esc_html__('Edit Icon','lapindos').'</a> <a href="javascript:void(0);" class="deletion redux-icon-multi-text-remove">' . esc_html__( 'Remove', 'lapindos') . '</a>'.
                ($sortable?' <span class="compact drag ui-sortable-handle"><i class="el el-move icon-large"></i></span> ':'').'</li>';

            echo '</ul>';
            $this->field['add_number'] = ( isset( $this->field['add_number'] ) && is_numeric( $this->field['add_number'] ) ) ? $this->field['add_number'] : 1;
            echo '<a href="javascript:void(0);" class="button button-primary redux-icon-multi-text-add" data-add_number="'.$this->field['add_number'].'" data-id="' . $this->field['id'] . '-ul" data-name="' . $this->field[ 'name' ] . '">' . $this->add_text . '</a><br/>';

            echo '</div>';

    wp_enqueue_style( "awesomeicon",get_template_directory_uri() . '/fonts/font-awesome/font-awesome.css', array(), '', 'all' );
    wp_enqueue_script('icon_picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.js',array('jquery'));
    wp_localize_script( 'icon_picker', 'picker_i18nLocale', array(
      'search_icon'=> esc_html__('Search Icon','lapindos'),
    ) );

    wp_enqueue_style('icon-picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.css','');
    do_action( 'themegum-glyph-icon-loaded');

            if(@function_exists('lapindos_glyphicon_list')):

            $icons= lapindos_glyphicon_list();
            if($icons){

            ob_start();
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    'use strict';

    var options={
            icons:new Array('<?php print @implode("','",$icons);?>'),
            onUpdate:function(e){

                var par=this.closest('li'),fieldinput=par.find('.icon-field'),preview=par.find('.icon-selection-preview i');
                fieldinput.val(e);
                if(!preview.length){
                    preview=$('<i/>');
                    preview.prependTo(par);
                    preview.wrap('<div class="icon-selection-preview"></div>');

                }
                preview.removeClass().addClass(e);
            }
        };

        try{
            $("#<?php print $this->field['id'];?>-ul li .redux-icon-multi-text-edit").iconPicker(options);
        }
        catch(err){
        }

});
</script>
<?php      print ob_get_clean();     
            }
            endif;

            $this->enqueue();

        }   

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            wp_enqueue_script( 'icon-picker',get_template_directory_uri() . '/lib/icon_picker/icon_picker.js', array('jquery'));
            wp_localize_script( 'icon-picker', 'picker_i18nLocale', array(
              'search_icon'=> esc_html__('Search Icon','lapindos'),
            ) );
     
             if ($this->parent->args['dev_mode']) {
                wp_enqueue_style(
                    'redux-field-sortable-css',
                    ThemegumReduxFramework::$_url . 'inc/fields/sortable/field_sortable.css',
                    array(),
                    time(),
                    'all'
                );
            }

            wp_enqueue_script(
                'redux-field-sortable-js',
                ThemegumReduxFramework::$_url . 'inc/fields/sortable/field_sortable'.ThemegumRedux_Functions::isMin().'.js',
                array( 'jquery', 'redux-js', 'jquery-ui-sortable' ),
                time(),
                true
            );


            wp_enqueue_script(
                'redux-field-icon-multitext-js',
                ThemegumReduxFramework::$_url . 'inc/fields/icon_multi_text/field_icon_multi_text.js',
                array( 'jquery', 'redux-js', 'redux-field-sortable-js' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-icon-multitext-css', 
                ThemegumReduxFramework::$_url  . 'inc/fields/icon_multi_text/field_icon_multi_text.css',
                time(),
                true
            );

            wp_enqueue_style('icon-picker',get_template_directory_uri().'/lib/icon_picker/icon_picker.css','');


        }

    }   
}