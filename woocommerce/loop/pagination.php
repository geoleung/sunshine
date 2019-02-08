<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$is_rtl = is_rtl();

?>
<nav class="shop-pagination pagination">
	<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => $base,
			'format'       => $format,
			'add_args'     => false,
			'current'      => max( 1, $current ),
			'prev_next'   => true,
			'total'        => $total,
		    'prev_text'   => $is_rtl ? '<span><i class="fa fa-angle-right"></i></span>' : '<span><i class="fa fa-angle-left"></i></span>',
		    'next_text'   => $is_rtl ? '<span><i class="fa fa-angle-left"></i>' : '<span><i class="fa fa-angle-right"></i></span>',
			'type'         => 'list',
			'before_page_number' => '<span>',
			'after_page_number' => '</span>',
			'end_size'     => 3,
			'mid_size'     => 3,
		) ) );
	?>
</nav>