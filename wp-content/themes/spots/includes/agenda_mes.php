       <aside>
       <header>
       <h2>Eventos do m&ecirc;s  <small>(ANUAL <?php echo date('M:Y');?>)</small></h2>
    
      </header>

	  <?php   $evento=date('F'); $args = array(
	'post_type' => 'post',
	'datas' => $evento,
	  'posts_per_page' => 5,
	  'orderby' => 'rand'
);?>

<ul class="rating_perso">

<?php $the_query= new WP_Query($args);
	  if( $the_query-> have_posts() ) : while($the_query-> have_posts() ) : $the_query->the_post(); ?>
       <?php $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;
	    $author = get_the_author();
		$avt=get_avatar($post->post_author,30); 
	   ?>
<li><a href="<?php the_permalink();?>"><?php the_post_thumbnail('mini');?> <span><?php the_title();?> </span></a> <br> Shares: <?=$likes;?><br> By: <?=$author;?> <?=$avt;?> </li>
<?php endwhile;?>
  <?php else:?>
	  <li> Sem eventos para este m&ecirc;s / no events for this month <?php echo $evento; ?></li>
	  <?php endif;

wp_reset_postdata();?>

</ul>
	<p class="text-right"><a href="http://www.check-inlove.com/blog/datas/<?php echo $evento; ?>/"> +  Eventos <small>( <?php echo date('M:Y');?>)</small>&raquo;</a></p>

</aside>