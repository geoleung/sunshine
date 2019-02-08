<?php

    /**
     * Options Sorter Field for Redux Options
     *
     * @author                      Yannis - Pastis Glaros <mrpc@pramnoshosting.gr>
     * @url                         http://www.pramhost.com
     * @license                     [http://www.gnu.org/copyleft/gpl.html GPLv3
     *                              This is actually based on:   [SMOF - Slightly Modded Options Framework](http://aquagraphite.com/2011/09/slightly-modded-options-framework/)
     *                              Original Credits:
     *                              Author:                      Syamil MJ
     *                              Author URI:                  http://aquagraphite.com
     *                              License:                     GPLv3 - http://www.gnu.org/copyleft/gpl.html
     *                              Credits:                     Thematic Options Panel - http://wptheming.com/2010/11/thematic-options-panel-v2/
     *                              KIA Thematic Options Panel:   https://github.com/helgatheviking/thematic-options-KIA
     *                              Woo Themes:                   http://woothemes.com/
     *                              Option Tree:                  http://wordpress.org/extend/plugins/option-tree/
     *                              Twitter:                     http://twitter.com/syamilmj
     *                              Website:                     http://aquagraphite.com
     */

/**
 * Change: added Block title
 * block params form single array data to multidemential array
 *                         'middle' => array(
 *                          'title'=> 'Middle Section',
 *                           'desc' => 'Drag module form modules box.',
 *                           'fields'=>array(
 *                               'menu1' => 'Menu 1',
 *                               'menu2' => 'Menu 2'
 *                           )
 *                          )
 *
 *
 * Modified:
 * Author: Atawai
 * Author URI: themegum.com
 * 
*/
// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    if ( ! class_exists( 'ReduxFramework_sorter' ) ) {
        class ReduxFramework_sorter {

            /**
             * Field Constructor.
             * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
             *
             * @since Redux_Options 1.0.0
             */
            function __construct( $field = array(), $value = '', $parent ) {
                $this->parent = $parent;
                $this->field  = $field;
                $this->value  = $value;
            }

            private function replace_id_with_slug( $arr ) {
                $new_arr = array();
                if ( ! empty( $arr ) ) {
                    foreach ( $arr as $id => $name ) {

                        if ( is_numeric( $id ) ) {
                            $slug = strtolower( $name );
                            $slug = str_replace( ' ', '-', $slug );

                            $new_arr[ $slug ] = $name;
                        } else {
                            $new_arr[ $id ] = $name;
                        }
                    }
                }

                return $new_arr;
            }

            private function is_value_empty( $val ) {
                if ( ! empty( $val ) ) {
                    foreach ( $val as $section => $arr ) {
                        if ( ! empty( $arr ) ) {
                            return false;
                        }
                    }
                }


                return true;
            }

            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since 1.0.0
             */
            function render() {

                if ( ! isset( $this->field['args'] ) ) {
                    $this->field['args'] = array();
                }

                if ( isset( $this->field['data'] ) ) {
                    $this->field['options'] = $this->parent->options_defaults[ $this->field['id'] ];
                }

                // Make sure to get list of all the default blocks first
                $all_blocks = ! empty( $this->field['options'] ) ? $this->field['options'] : array();
                $temp       = array(); // holds default blocks
                $temp2      = array(); // holds saved blocks

                foreach ( $all_blocks as $block_name => $blocks ) {
                    $temp = array_merge( $temp, $blocks['fields'] );

                    if(isset($this->value[$block_name]['fields'])){
                        $this->value[$block_name] = $this->value[$block_name]['fields'];
                    }
                }

                if ( $this->is_value_empty( $this->value ) ) {
                    if ( ! empty( $this->field['options'] ) ) {
                        $this->value = $this->field['options'];
                    }
                }

                $sortlists = $this->value;
                if ( ! empty( $sortlists ) ) {
                    foreach ( $sortlists as $section => $arr ) {
                        $sortlists[ $section ] = $this->replace_id_with_slug( $arr );
                    }
                }

                if ( is_array( $sortlists ) ) {
                    foreach ( $sortlists as $sortlist ) {
                        $temp2 = array_merge( $temp2, $sortlist );
                    }

                    // now let's compare if we have anything missing
                    foreach ( $temp as $k => $v ) {
                        // k = id/slug
                        // v = name

                        if ( ! empty( $temp2 ) ) {
                            if ( ! array_key_exists( $k, $temp2 ) ) {
                                $sortlists['Disabled'][ $k ] = $v;
                            }
                        }
                    }

                    // now check if saved blocks has blocks not registered under default blocks
                    foreach ( $sortlists as $key => $sortlist ) {
                        // key = enabled, disabled, backup
                        // sortlist = id => name

                        foreach ( $sortlist as $k => $v ) {
                            // k = id
                            // v = name
                            if ( ! array_key_exists( $k, $temp ) ) {
                                unset( $sortlist[ $k ] );
                            }
                        }
                        $sortlists[ $key ] = $sortlist;
                    }

                    // assuming all sync'ed, now get the correct naming for each block
                    foreach ( $sortlists as $key => $sortlist ) {
                        foreach ( $sortlist as $k => $v ) {
                            $sortlist[ $k ] = $temp[ $k ];
                        }
                        $sortlists[ $key ] = $sortlist;
                    }

                    if ( $sortlists ) {
                        echo '<fieldset id="' . $this->field['id'] . '" class="redux-sorter-container redux-sorter">';

                        foreach ( $sortlists as $group => $sortlist ) {
                            $filled = "";

                            $group_title = isset($all_blocks[$group]['title']) ? $all_blocks[$group]['title'] : $group;
                            $group_description = isset($all_blocks[$group]['desc']) ? $all_blocks[$group]['desc'] : '';
                            $vertical = isset($all_blocks[$group]['vertical']) ? (bool)$all_blocks[$group]['vertical'] : false;

                            if ( isset( $this->field['limits'][ $group ] ) && count( $sortlist ) >= $this->field['limits'][ $group ] ) {
                                $filled = " filled";
                            }

                            echo '<ul id="' . esc_attr($this->field['id']) . '_' . $group . '" class="sortlist_' . $this->field['id'] . $filled . ($vertical ? ' vertical':'').'" data-id="' . esc_attr($this->field['id']) . '" data-group-id="' . $group . '">';
                            echo '<h3>' . esc_html($group_title) . '</h3>';

                            if ( ! isset( $sortlist['placebo'] ) ) {
                                array_unshift( $sortlist, array( "placebo" => "placebo" ) );
                            }

                            foreach ( $sortlist as $key => $list ) {



                                echo '<input class="sorter-placebo" type="hidden" name="' . wp_strip_all_tags( $this->field['name']) . '[' . $group . '][placebo]' . $this->field['name_suffix'] . '" value="placebo">';

                                if ( $key != "placebo" ) {

                                    $label = is_array($list) ? (isset($list['thumb']) ? '<img src="'.$list['thumb'].'" />' : $list['title']) : $list;

                                    echo '<li id="sortee-' . $key . '" class="sortee" data-id="' . $key . '">';
                                    echo '<input class="position ' . $this->field['class'] . '" type="hidden" name="' . wp_strip_all_tags( $this->field['name']) . '[' . $group . '][' . $key . ']' . $this->field['name_suffix'] . '" value="' . $key . '">';
                                    echo wp_kses($label,array('img'=>array('src'=>array())));
                                    echo '</li>';
                                }
                            }

                            if($group_description!=''){

                                echo '<p>'.esc_html($group_description).'</p>';
                            }

                            echo '</ul>';
                        }
                        echo '</fieldset>';
                    }
                }
            }

            function enqueue() {
                if ( $this->parent->args['dev_mode'] ) {
                    wp_enqueue_style(
                        'redux-field-sorder-css',
                        ThemegumReduxFramework::$_url . 'inc/fields/sorter/field_sorter.css',
                        array(),
                        time(),
                        'all'
                    );
                }

                wp_enqueue_script(
                    'redux-field-sorter-js',
                    ThemegumReduxFramework::$_url . 'inc/fields/sorter/field_sorter' . ThemegumRedux_Functions::isMin() . '.js',
                    array( 'jquery', 'redux-js', 'jquery-ui-sortable' ),
                    time(),
                    true
                );
            }

            /**
             * Functions to pass data from the PHP to the JS at render time.
             *
             * @return array Params to be saved as a javascript object accessable to the UI.
             * @since  Redux_Framework 3.1.5
             */
            function localize( $field, $value = "" ) {

                $params = array();

                if ( isset( $field['limits'] ) && ! empty( $field['limits'] ) ) {
                    $params['limits'] = $field['limits'];
                }

                if ( empty( $value ) ) {
                    $value = $this->value;
                }
                $params['val'] = $value;

                return $params;
            }
        }
    }