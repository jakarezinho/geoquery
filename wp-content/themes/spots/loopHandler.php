<?php
// Our include
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Our variables
global $post;
$numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 0;
$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;


query_posts(array(
       'posts_per_page' => $numPosts,
       'paged'          => $page,
	    'order'         => 'DESC',
));
?>
<?php // our loop 
if (have_posts()) :?>

<?php  while (have_posts()): the_post();?>
<section id="post-<?php the_ID(); ?>"class="row"> 
<div <?php post_class(); ?>><!--/post/-->
<?php 
        $local=get_post_meta($post->ID, 'custom_local', true);
	   $lat= get_post_meta($post->ID, 'costum_lat', true); 
		$lng= get_post_meta($post->ID, 'costum_lng', true); 
$post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;
		 $author_id = $post->post_author;
	    $fb =  get_user_meta($author_id, '_fbid', true);
		   $author = get_the_author();
		   $link = get_author_posts_url( $author_id);
	   // $rating = get_post_meta($post->ID, 'ratings_average', true);
		 if ($fb){ $mini = "<img src='https://graph.facebook.com/$fb/picture'/>";}else{ $mini = get_avatar($author_id,50);}
		?>
        <div class="media"><?php echo "By <a href='$link' title ='$author'>$author</a>".$mini;?> </div>
      <p class="local_post"> <?= $local;?> </p>
 <header> 
    <h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2> 
   
    </header>
<div class="entry">
 <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?=image_archive ('large');?>" alt="<?php the_title(); ?>" /></a>
 <p><?php echo excerpt('50');?></p>
</div><!--/entry/-->

</div><!--/post/-->
<div class="rat">
<p><strong>Fotos de:</strong> <a href="<?php  echo get_author_posts_url($author_id); ?>" title="<?= $author;?>"> <?= $author;?> / </a> <?php if ( comments_open() ) :
  comments_popup_link( 'Comentar ou avaliar &raquo;', '1 Comet&aacute;rios &raquo;', '% comments', 'comments-link', 'Comments are off for this post');
endif;?> </p>
 <p>Cole&ccedil;&atilde;o: <?php the_category(', ');  the_tags(' Localidade: ', ', '); ?></p>
 <h3>Shares / <span class="badge"> <?=$likes;?></span> </h3>

 <?php if (is_user_logged_in()):?>
 <hr />
   <div class="media_single"><?php 
     $user= wp_get_current_user();
	 $fb_user =  get_user_meta($user->ID, '_fbid', true);
	 if ($fb_user){ $mini= "<img src='https://graph.facebook.com/$fb_user/picture'/>";}else{ $mini = get_avatar($user->ID,50);}
	 echo "Hello," . $user->display_name ."! " . $mini ;?>
   <?php endif;?>
</div>
</div>
</div>
</section><!--section/--> 
<?php endwhile; wp_reset_query();  endif;?>
