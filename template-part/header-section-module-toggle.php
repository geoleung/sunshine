<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
$toggle = lapindos_get_config('toggle-icon','');
?>
<span class="slide-bar"><?php print ($toggle!='') ? '<i class="'.sanitize_html_class($toggle).'"></i>' : 'X';?></span>
