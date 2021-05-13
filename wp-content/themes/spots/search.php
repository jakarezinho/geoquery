<?php include 'header.php';?>
<?php include 'includes/nav_top.php';
 
 
?>
<!--centre-->
  <div class="container centre_page">
    
        <header>
    <h1> Resultado da pesquisa</h1>
    </header>
 <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a> | pesquisa</p>
  <div class="row">
       <div class="col-md-8"><!--/gauche/-->
  <?php
$allsearch = new WP_Query("s=$s&showposts=-1"); 
echo '<p class="local">'.$allsearch ->found_posts.' resultados.</p>';
?>
<section> 
  <?php if (have_posts()) :?> 
  <?php get_search_form(); ?>
<ul class="pesquisa">

 <?php  while (have_posts()): the_post();?>
 <?php 
        $local= get_post_meta($post->ID, 'vsip_local', true);
        $rating = get_post_meta($post->ID, 'ratings_average', true);?>
           <?php  $author_id = $post->post_author;  $fb = get_user_meta($author_id, '_fbid', true); $author = get_the_author();
		   if ($fb){ $mini= "<img src='https://graph.facebook.com/$fb/picture'/>";}else{ $mini = get_avatar($author_id,50);}
		   ?>
 <div> <!--/post/-->
  <li>
  <div class="comment-author"> <?php echo $mini. "By $author ";?></div>

<h2><a rel="permalink" href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
<p><strong>Local:</strong>
<?= $local?> </p>
<div class="entry">
</div><!--/entry/-->

</li>
</div><!--/post/-->
<?php endwhile;?>
</ul>
</section>
       <!--//nav/-->
<?php else: ?>
<h3>Pesquisa  sem resultados</h3>
<p> Tente uma nova pesquisa com palvras chave diferentes</p>
<?php get_search_form(); ?> 
<?php  endif;?>
<div class="nav_cat">
  <?php
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>
</div>
      </div> <!--/gauche/-->
             <div class="col-md-4">
                  <!--favoritos-->
       <?php include ('includes/favoritos.php');?>
             <header> 
             <h3> TOP RATINGS <small>Locais mais votados</small></h3>
             </header>
              <?php  jm_most_popular();?>
               <header>
        <h3> HOT SPOTS </h3>
      </header>
      <?php wp_tag_cloud('smallest=12&largest=12&number=15&order=DESC&orderby=count&separator=, '); ?>...
             </div>
    </div><!--/row-->
</div><!--//center/-->
<!--footer-->
<?php include 'footer.php';?>