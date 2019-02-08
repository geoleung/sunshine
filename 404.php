<?php
/**
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
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
<?php

$error_text = "";

if(($page_id =  lapindos_get_config('404-page'))){
        $page_404 = lapindos_get_wpml_post( absint($page_id) );

        if(!empty( $page_404 ) && is_object($page_404)){
            $error_text = $page_404->post_content;
        }
}
else{
	add_filter( 'body_class', create_function('$classes','$classes[]=\'background-primary\'; return $classes;'));
}

remove_action('wp_head','lapindos_sidebar_loader');

?>
<?php wp_head();?>
</head>
<body <?php body_class();?>>
<?php 

if ($error_text!='') {
	print do_shortcode($error_text);
}
else{?>
<div class="container">
	<div class="error404-content color-background page-404">
		<h2 class="title-404 color-background" ><?php esc_html_e( '404 PAGE','lapindos' );?></h2>
<?php 

$error_text=lapindos_get_config('404-text','');

if($error_text!=''){
	print do_shortcode($error_text);
}
else{?>
		<h3 class="subtitle-404 color-background"><?php esc_html_e( 'Sorry! The page  you\'re looking not found','lapindos' );?></h3>
		<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'lapindos' ); ?></p>
		<a href="<?php print esc_url( home_url( '/') );?>" class="btn btn-secondary-thirdy"><?php esc_html_e( 'BACK TO HOME','lapindos');?></a>
<?php }?>
	</div>					
</div>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>