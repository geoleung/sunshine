<?php
defined('ABSPATH') or die();
/**
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php lapindos_view_port();?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head();?>
</head>
<body <?php body_class();?>>
<div class="main-container ">
  <div class="page-heading <?php print lapindos_get_config('heading_position','');?>">
    <?php get_template_part( 'template-part/heading'); ?>
  </div>
  <div class="main-content clearfix <?php print apply_filters('lapindos_main_content_class','' );?>">
		<div class="container">
		<div class="row">
		<div class="content col-xs-12 <?php print esc_attr(apply_filters('themegum_content_css_column','col-sm-6 col-md-8'));?>">