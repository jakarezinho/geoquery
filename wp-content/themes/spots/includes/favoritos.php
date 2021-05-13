
<?php 
			 $the_query = new WP_Query( array(
  'post_type' => 'post',
  'category_name' => 'recomendo', 
  //'cat' => $id,
  'posts_per_page' =>1,
  'orderby'  => 'rand',

))
			 ?>
<?php if ($the_query-> have_posts() ) :?>
<?php while ( $the_query->have_posts()) :$the_query->the_post(); ?>
<?php 
        $local= get_post_meta($post->ID, 'custom_local', true);
   $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0;?>
<div class="col-md-12 col-sm-12  col-xs-12 favoritos">
 <header>
             <h2> Lugares favoritos  </h2>
             </header> 
  <article>
 
    <div class="nota" style="background-image: url('<?=image_archive ('large');?>');">
      <?php  $author_id = $post->post_author;
	    $fb =  get_user_meta($author_id, '_fbid', true);
		   $author = get_the_author();
         $avat=get_avatar($author_id,50);
		 echo "<div class='media_cat'>$avat <br> By $author</div>";
		?>
      <div class="note-card__text">
        <h1 class="note-card__title"><a rel="permalink" href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
          </a></h1>
        <a rel="permalink" href="<?php the_permalink(); ?>"> </a>
        <div class="note-card__excerpt">
          <p>
            <?= $local;?>
          </p>
        </div>
      </div>
    </div>
    <div class="note-card__footer">
      <p> <strong>Shares</strong>
        <?=$likes; ?>
      </p>
    </div>
  </article>
</div>
<?php endwhile;endif; ?>
