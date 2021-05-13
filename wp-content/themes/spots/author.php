<?php include 'header.php';
 include 'includes/nav_top.php';
 $autd= get_the_author_meta('ID');
 if ($deviceType!='phone') {include ('includes/mapa_1.php');}?> 
<?php 
      $the_query = new WP_Query( array(
  'post_type' => 'post',
  'author' =>  $autd,
   'paged' => get_query_var('paged'),
  'posts_per_page' => 8,
  'order' => 'DESC'
));

 ///user
 $nome = get_the_author_meta( 'display_name', $autd );
 $user_url = get_the_author_meta( 'user_url', $autd );
 $user_description = get_the_author_meta( 'description', $autd );
 $user_twitter = get_the_author_meta( 'twitter', $autd );
 $fb =  get_user_meta( $autd, '_fbid', true);
?>

<!--centre-->
  <div class="container centre"> 
  
 
        <header>
        	
			<div class="media_autor"> 
			<?php $user_post_count = count_user_posts( $autd );
			if ($fb){ echo "<img src='https://graph.facebook.com/$fb/picture' />"; }else {echo get_avatar($autd,50);}?>
            <h1> <?php echo "$nome <small> / $user_post_count  fotos</small>"; ?></h1>
           
            </div>
    </header>
    <div class="infos_autor">
    <h3> Informa&ccedil;&otilde;es sobre o autor </h3>
    <ul class="list-inline">
    <li> <strong>Nome: </strong><?= $nome?></li>
    <li> <?php if($user_url) {echo "<strong> Web: </strong><a href='$user_url'>$user_url </a>";} ?> </li>
      <li> <?php if($user_description) {echo " <strong>Sobre mim: </strong> $user_description";} ?> </li>
    </ul>
    
     </div>

  <div class="row">
   <?php if ($the_query-> have_posts() ) :?>

      <?php while ( $the_query->have_posts()) :$the_query->the_post(); ?> 
    <?php 
        $local= get_post_meta($post->ID, 'vsip_local', true);
         $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;
         $author_id = $post->post_author;  $fb =  get_user_meta($author_id, '_fbid', true);  $author = get_the_author();
         if ($fb){ $mini= "<img src='https://graph.facebook.com/$fb/picture'/>";}else{ $mini = get_avatar($author_id,50);}?>
      <div class="col-md-3 col-sm-4  col-xs-12 view">  
      <article>
      <div class="nota" style="background-image: url('<?=image_archive ('large');?>');">
      <div class="media_cat"> </div>
      <div class="note-card__text">
      <h1 class="note-card__title"><a rel="permalink" href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h1>
        <div class="note-card__excerpt"><p><?= $local;?></p></div>
    </div>
      </div>
      <div class="note-card__footer">
<p> <strong>Rating</strong>
<?=$likes; ?></p>
  </div>
      </article>
</div><!--/div_bootstrap//-->
        <?php endwhile; ?>
         <div class="nav_cat">
  <?php
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $the_query->max_num_pages
) );
?>
</div>
<h3> Spots</h3>
<?php get_tags_aut($autd)?>
        <?php  else : ?>
        
       <h2> No fotos</h2>
		<?php endif;?>
          <?php wp_reset_postdata(); ?>
    </div><!--/row-->
</div><!--//center/-->
<!--footer-->
<?php include 'footer.php';?>