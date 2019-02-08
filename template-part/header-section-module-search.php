<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

?>
<ul class="search-form nav navbar-nav ">
	<li class="dropdown dhidden-xs">
	  	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search"></i></a>
  		<ul class="dropdown-menu">
			<li>
	<form role="search" method="get" class="navbar-form" action="<?php print esc_url( home_url( '/' ) );?>">
	<div class="form-group">
		<input type="search" class="search-field form-control" placeholder="<?php print esc_attr_x( 'Type and hit enter', 'label','lapindos' );?>" value="<?php print get_search_query();?>" name="s" title="<?php print esc_attr_x( 'Search for:', 'label', 'lapindos' );?>" />
	</div>
	</form>
			</li>
	  	</ul>
	</li>
<?php if(function_exists('is_shop')):
$cart_link = get_permalink(get_option( 'woocommerce_cart_page_id' ));
$cart_count=  WC()->cart->get_cart_contents_count() ? WC()->cart->get_cart_contents_count() : 0;
?>
	<li class="cart-menu">
		<a class="cart-link" href="<?php print esc_url($cart_link);?>"><i class="cart-btn fa fa-shopping-cart"></i><span class="cart-count"><span class="item_count"><?php print $cart_count;?></span></span></a>
	</li>

<?php endif;?>

</ul>