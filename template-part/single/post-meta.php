<?php
defined('ABSPATH') or die();
/**
 * @package WordPress
 * @subpackage Lapindos
 * @since Lapindos 1.0.0
 */

$num_comment = get_comments_number();

$comment_msg= $num_comment ? sprintf( _n('%d comment','%d comments',$num_comment,'lapindos'), $num_comment) : esc_html__('no comment','lapindos');
?>
<ul class="post-meta-info bot-m20">
	<?php if(($date_post = get_the_date())):?>
	<li class="meta date-info"><i class="fa fa-clock-o"></i><?php print ent2ncr($date_post);?></li>
	<?php endif;?>
	<li class="meta user-info"><?php esc_html_e('Posted by:','lapindos');?> <a href="<?php print get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) );?>"><?php the_author();?></a></li>
<?php if(($categories = get_the_category_list("</li><li>,&nbsp;</li><li>"))):
$categories = "<ul class=\"post-categories\"><li>".$categories."</li></ul>";
?>
	<li class="meta categories-info"><?php printf( __('category: %s','lapindos'), ent2ncr($categories)) ;?></li>
<?php endif;?>
	<li class="meta comment-info"><i class="fa fa-comment-o"></i><?php print ent2ncr($comment_msg);?></li>
</ul>