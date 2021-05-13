<?php include 'header.php';?>
<?php include 'includes/nav_top.php';
if ($deviceType!='phone') {include 'includes/mapa_solo.php';}else{$lat= get_post_meta($post->ID, 'costum_lat', true); $lng= get_post_meta($post->ID, 'custom_lng', true);}
 $local= get_post_meta($post->ID, 'custom_local', true);
?>
<!--centre-->
<div class="container centre">
  <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a> &raquo; Categorias:
    <?php the_category(', ');  the_tags(' Tag:&raquo; ', ', '); // echo get_the_term_list( $post->ID, 'datas', ' Datas:&raquo; ', ', ', '' ); ?>
  </p>
  <div class="row">
    <?php // our loop 
if (have_posts()) :?>
    <div class="col-md-8">
      <!--/gauche/-->
      <?php  while (have_posts()): the_post();?>
      <section id="post-<?php the_ID(); ?>"class="row">
        <div <?php post_class(); ?> class="post">
          <!--/post/-->
          <?php  
		   $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;
	$author = get_the_author();
	$fbs =  get_user_meta($post->post_author, '_fbid', true);
	$link = get_author_posts_url($post->post_author);
	if ($fbs){ $mini = "<img src='https://graph.facebook.com/$fbs/picture'/>";}else{ $mini = get_avatar($post->post_author,50);}?>
          <div class="media"><?php echo "By <a href='$link' title ='$author'>$author</a>".$mini;?> </div>
          <p class="local_post">
            <?= $local?>
          </p>
          <div class="entry">
            <header>
              <h1>
                <?php the_title(); ?>
                </h1>
            </header>
            <?php the_content(); ?>
          </div>
          <!--/entry/-->
        </div>
        <!--/post/-->
        <div class="rat">
          <p> <strong>Fotos de:</strong> <a href="<?php  echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?= $author;?>">
            <?= $author;?>
            </a></p>
          <p>Cole&ccedil;&atilde;o:
            <?php the_category(', ');  the_tags(' Localidade: ', ', '); ?> <?php// echo get_the_term_list( $post->ID, 'datas', 'Datas:&raquo; ', ', ', '' ); ?>
            | <a href="https://maps.google.pt/maps?daddr=<?= $lat;?>,<?= $lng; ?>&hl=pt-PT&sll=<?= $lat;?>,<?= $lng; ?>&z=16" target="_blank">Ver no google maps &raquo;</a></p>
            <p> <a href="http://www.pequeno.eu/atelier/google_places/?lat=<?=$lat;?>&lng=<?=$lng;?> " target="_blank"> Por perto </a> </p> 
          <h3>Shares /<span class="badge"> <?=$likes;?></span></h3>
          <?php social_shares(); ?>
         <!-- <div class="share"></div>-->
          <div class="nav">
        <div class="left"><?php previous_post_link('%link', ' &larr;%title', TRUE ); ?></div>
    <div class="right"><?php next_post_link('%link', '%title  &rarr;', TRUE ); ?></div>
        <hr>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
          <div class="media_single">
            <?php if (is_user_logged_in()):?>
            <hr>
            <?php $user= wp_get_current_user();
	 $fb_user =  get_user_meta($user->ID, '_fbid', true);
	 if ($fb_user){ $mini= "<img src='https://graph.facebook.com/$fb_user/picture'/>";}else{ $mini = get_avatar($user->ID,50);}
	 echo "Hello," . $user->display_name ."! " . $mini ;?>
            <?php endif;?>
          </div>
        </div>
      </section>
      <!-- the comment box -->
      <div class="well comente">
     <?php comments_template( '', true ); ?>
      </div>
      <hr>
      <!-- the comments -->
      <div class="social"><a class=" btn-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">Facebook</a> <a  class="btn-google" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"> Google+</a> <a  class=" btn-tweet" target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=PHOTOSPOT">Tweet</a> <a  class="btn-tumblr" target="_blank" href="http://www.tumblr.com/share"> Tumblr</a>  <a  class="btn-pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&description=<?php the_title(); ?>&media=<?php echo pinterest_image();?>">Pin on Pinterest</a></div>

      <?php endwhile;?>
      <?php else: ?>
      <h3> sem local </h3>
      <?php  endif;?>
      <!--/nav-->
      <div> </div>
      <!--//nav/-->
    </div>
    <!--/gauche/-->
    <div class="col-md-4">
      <!--favoritos-->
      <?php include ('includes/favoritos.php');?>

  <!--agenda mess-->
            <?php include ('includes/agenda_mes.php');?>
        <h3> HOT SPOTS </h3>
      </header>
      <?php wp_tag_cloud('smallest=12&largest=12&number=15&order=DESC&orderby=count&separator=, '); ?>... 
      </div>
  </div>
  <!--/row-->
</div>
<!--//center/-->
<!--footer-->
<?php include 'footer.php';?>