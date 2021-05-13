<?php include 'header.php';
include 'includes/nav_top.php';
 if ($deviceType!='phone') {include ('includes/mapa_1.php');}?> 
<?php 

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' )  ); 
$the_query = new WP_Query( array(
  'post_type' => 'post',
 'tax_query' => array(array( 'taxonomy' => $term->taxonomy, 'field'=> 'slug','terms'=>$term->name ,),),
  'paged' => get_query_var('paged'),
  //'category__not_in' => array( 14,),
  'posts_per_page' =>8,
  //'orderby'       => 'rand',
   'order'         => 'DESC'
));
     
?>

<!--centre-->
  <div class="container centre">
     <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a>
        <?php echo  $term->taxonomy.' , '. datas_pt($term->name);?></p>
        <header>
    <h1>Recentes :  <?= datas_pt($term->name); ?></h1>
    </header>
  <div class="row">
   <?php if ($the_query-> have_posts() ) :?>
      <?php while ( $the_query->have_posts()) :$the_query->the_post(); ?> 
      <?php 
	    $author = get_the_author();
		  if ( !is_search()){ $author_id = $post->post_author;}
        $local= get_post_meta($post->ID, 'costum_local', true);
       $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;
		  $fb =  get_user_meta($author_id, '_fbid', true);
		   $link = get_author_posts_url($author_id);
		   if ($fb){ $mini= "<img src='https://graph.facebook.com/$fb/picture'/>";}else{ $mini = get_avatar($author_id,50);}
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
<p> <strong>Shares</strong>
<?=$likes; ?></p>
  </div>
      </article>
    
       
		
     </a></div><!--/div_bootstrap//-->
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
<h3> HOT SPOTS </h3>
<?php wp_tag_cloud('smallest=12&largest=22&number=5&order=DESC&orderby=count&separator= , '); ?>...
        <?php  else : ?>
        
       <h2> No fotos</h2>
		<?php endif;?>
          <?php wp_reset_postdata(); ?>
    </div><!--/row-->
</div><!--//center/-->
<!--footer-->
<?php include 'footer.php';?>