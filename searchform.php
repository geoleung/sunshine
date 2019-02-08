<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php print esc_url( home_url( '/' ) );?>">
	<div class="search">
		<input type="search" class="search-field" placeholder="<?php print esc_attr_x( 'Type and hit enter', 'label','lapindos' );?>" value="<?php print get_search_query();?>" name="s" title="<?php print esc_attr_x( 'Search for:', 'label', 'lapindos' );?>" /><button type="submit" class="search-ico fa fa-search" ></button>
	</div>
</form>