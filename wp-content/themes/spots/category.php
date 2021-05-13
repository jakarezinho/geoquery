<?php include 'header.php';
 include 'includes/nav_top.php';
     include ('includes/Mobile_Detect.php');
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
 if ($deviceType!='phone') {include ('includes/map2.php');}

      $the_query = new WP_Query( array(
  'post_type' => 'post',
   'cat' => $cat, 
   'paged' => get_query_var('paged'),
  'posts_per_page' => 8,
  'order' => 'DESC'
));
 //var_dump ($cat); 
 $n = get_the_category(); $cat_n = $n[0];

?>

<!--centre-->
  <div class="container centre"> 
  
   <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a> &raquo; Categorias:
        <?php the_category(', '); ?></p>
        <header>
    <h1>Recentes: <?=single_cat_title(); ?> <small> <?=$cat_n->category_count;?> fotos</small> </h1>
    </header>
  <div class="row">
   <?php 
   
   if ($the_query-> have_posts() ) :?>

      <?php while ( $the_query->have_posts()) :$the_query->the_post(); ?> 
    <?php $author_id = $post->post_author;  
        $local= get_post_meta($post->ID, 'vsip_local', true);
        //$rating = get_post_meta($post->ID, 'ratings_average', true);
		 $link = get_author_posts_url($author_id);
        $post_like_count = get_post_meta($post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;?>
           <?php  $fb = get_user_meta($author_id, '_fbid', true); $author = get_the_author();
		    $mini = get_avatar($author_id,50);
		   ?>
      <div class="col-md-3 col-sm-4  col-xs-12 view">  
      <article>
      <div class="nota" style="background-image: url('<?=image_archive ('large');?>');">
      
		<div class="media_cat"> <?php echo "<a href='$link' title ='$author'>$mini</a> <br> $author";?></div>
      <div class="note-card__text">
      <h1 class="note-card__title"><a rel="permalink" href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h1>
        <div class="note-card__excerpt"><p><?= $local;?></p></div>
    </div>

      </div>
      <div class="note-card__footer">
<p> <strong>Shares</strong> <?=$likes;?></p>
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
<h3>Spots</h3>

  <?php get_category_tags ($cat); ?>
  
        <?php  else : ?>
        
       <h2> No fotos</h2>
		<?php endif;?>
          <?php wp_reset_postdata(); ?>
    </div><!--/row-->
</div><!--//center/-->
<!--footer-->
<?php include 'footer.php';?>