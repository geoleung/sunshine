<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$description = get_bloginfo( 'description', 'display' );
$logo_type = lapindos_get_config('logo-type','auto');
$brand_logo = "";

$logo_image = lapindos_get_custom_logo();
$blogname = $blogtitle = get_bloginfo('name');
$logo_text = '<p class="logo-text"><a  href="'.esc_url(home_url('/')).'" title="'.esc_attr($blogtitle).'">'.$blogname.'</a></p>';

switch ($logo_type) {
  case 'image':
        $brand_logo = $logo_image;
    break;
  case 'title':
        $brand_logo = $logo_text;
    break;
  default:
      $brand_logo = (!empty($logo_image) && get_theme_mod( 'custom_logo' )) || is_customize_preview()  ? $logo_image : $logo_text; 
    break;
}

?>
<div class="logo-image">
<?php print wp_kses_post($brand_logo);?>
</div>
<?php if ( $description && lapindos_get_config('show-tagline')) : ?>
<p class="site-slogan"><?php echo esc_html($description); ?></p>
<?php endif; ?>
