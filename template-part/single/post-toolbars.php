<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$post_id = get_the_ID();
?>
<ul class="post-toolbars single-post">
	<li class="toolbar toolbar-date"><?php esc_html_e( 'On', 'lapindos');?> <span class="date"><?php the_date();?></span><i class="fa fa-circle"></i><?php printf( esc_html__('by %s','lapindos' ),lapindos_get_author_blog_url(false));?></li>
	<li class="toolbar toolbar-shared">
		<i class="fa fa-share-alt"></i>
		<ul class="share-action">
			<li class="share-label"><?php esc_html_e('share to','lapindos');?></li>
			<li><a rel="nofollow" href="<?php print esc_url('https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink());?>" onclick="javascript:window.open('<?php print esc_url('https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink());?>', 'facebook-share-dialog', 'width=600,height=400');
                                return false;"><i class="fa fa-facebook"></i></a></li>
			<li><a rel="nofollow" href="<?php print esc_url('https://twitter.com/share?url='.get_the_permalink());?>"><i class="fa fa-twitter"></i></a></li>
			<li><a rel="nofollow" href="<?php print esc_url('https://plus.google.com/share?url='.get_the_permalink());?>" onclick="javascript:window.open(this.href,
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                                return false;"><i class="fa fa-google"></i></a></li>
			<li><a rel="nofollow" href="<?php print esc_url('https://www.pinterest.com/pin/create/button/?url='.get_the_permalink());?>"><i class="fa fa-pinterest"></i></a></li>
		</ul>
	</li>
	<li class="toolbar comment-info"><i class="fa fa-comment-o"></i><?php print get_comments_number();?></li>
<?php do_action('lapindos_toolbars' , $post_id);?>
</ul>