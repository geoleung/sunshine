<?php
defined('ABSPATH') or die();

if ( !class_exists( 'ThemegumReduxFramework' ) && file_exists( get_template_directory(). '/redux-framework/ReduxCore/framework.php' ) ) {

	add_filter('redux_opt_name',create_function('','return "lapindos_config";'));
	require_once(get_template_directory().'/redux-framework/ReduxCore/framework.php');

}
if ( !isset( $lapindos_config ) && file_exists( get_template_directory() . '/lib/config.php' ) ) {

	require_once(get_template_directory().'/lib/config.php');
}
?>