<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$content = lapindos_get_config( 'text-module','');

if($content!=''):?>
<div class="module-text">
<?php print do_shortcode($content);?>
</div>
<?php endif;?>
