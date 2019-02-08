<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.1
 */
?>
<?php if(($title = lapindos_get_config('the_title')) && $title!='' && 'content' == lapindos_get_config('title_position')  ): ?>
		<h1 class="post-title h3 bot-m20"><?php the_title();?></h1>
<?php endif; ?>
