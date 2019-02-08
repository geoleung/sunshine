<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$author_description = get_the_author_meta('description');

if(empty($author_description)) return;
?>
<div class="author-profile bot-m40">
	<?php print get_avatar( get_the_author_meta( 'ID' ), 200 ,'','',array('class'=>'author-profile-image'));?>
    <div class="itemAuthorDetails">
      <div class="itemAuthorName h5">
      	<?php printf( wp_kses(__('by: %s','lapindos' ),array('a'=>array('href'=>array()))),lapindos_get_author_blog_url(false));?>
      </div>
      <div>
      	<?php print wp_kses_post($author_description);?>
      </div>
    </div>
</div>
<div class="clearfix"></div>