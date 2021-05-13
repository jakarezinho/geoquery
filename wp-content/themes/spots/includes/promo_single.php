<!---liste eventos--->

<?php 
			////
			$post_page=10;
			 if (is_single()){$post_page=5 ;}
			  $today = date('Y-m-d');
			$todayw = date('Y-m-d', strtotime(' next saturday'));
		   $domingo = date('Y-m-d', strtotime(' next sunday'));
		   $semana = date('Y-m-d', strtotime(' last sunday  midnight'));
			$date= date('d-F-Y');
			$args = array(
  'post_type' => 'promo',
  'posts_per_page' => $post_page,
  'paged' => get_query_var('paged'),
  'meta_key' => 'vsip_data1',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_query' => array(
  array(
    'key' => 'vsip_data2',
    'value' => $today,
    'compare' => '>=',
    'type' => 'DATE'
  ))
);
$the_query = new WP_Query($args);
?>
 
<div class="page-title-container">
<h3>Eventos e promos</h3>
<p class="data_promo"> Eventos recomendados <a href="http://www.check-inlove.com/blog/eventos-promos/">tem sugestões para a agenda dos próximos dias ?» </a> </p>
<section  class="entry-content">
<?php if ($the_query-> have_posts() ) : ?>
    <?php while ($the_query-> have_posts() ) : $the_query->the_post();?>
  <?php  $given_1= get_post_meta($post->ID, 'vsip_data1', true);// data principio
		    
			$mes_1 = date("M", strtotime($given_1));
			$dia_1 = date("d", strtotime($given_1));
			$ano_1 = date("Y", strtotime($given_1));
			$mes_pt1= modar_mes($mes_1, $given_1); 
			///
			$given_2 = get_post_meta($post->ID, 'vsip_data2', true);//data fim
		
			$mes_2 = date("M", strtotime($given_2));
			$dia_2 = date("d", strtotime($given_2));
			$ano_2 = date("Y", strtotime($given_2));
			$mes_pt_2= modar_mes($mes_2, $given_2);
			$mes_pt_int= modar_mes($mes_2, $given_2);
			//
			$im_ev = teste_image(get_the_post_thumbnail( $post->ID, 'thumbnail' ));
 !empty($im_ev)? $image_event= $im_ev : $image_event = 'http://www.check-inlove.com/blog/wp-content/themes/check-inlove/images/logo_ev.png';

			?>
  <article>
    <div class="promos">
     
    
      <div class="mini_promo">
        <div class="promo_data">
          <div class="mes">
            <?= $mes_pt1;?>
          </div>
          <div class="dia">
            <?= $dia_1;?>
          </div>
          <div class="dia_decal"></div>
          <div >
            <?=$dia_2;?>
            /
            <?= $mes_pt_2;?>
          </div>
        </div>
      </div>
      <?php  // if ($today > $givens) { wp_delete_post( $post->ID );} ?>
      <div class="promos_decal">
        <p class="promo_petit"><?php echo get_avatar( get_the_author_meta( 'ID' ),  25 ); ?> <small>
          <?php the_author(); ?>
          </small> </p>
        <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"> <strong>
          <?php the_title(); ?>
          </strong> </a> &raquo;</h4>
        <p class="promo_petit"> <span class="local"><?php echo get_post_meta($post->ID, 'vsip_local', true);?> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
          <?= $dia_1;?>
          -
          <?= $mes_pt1;?>
          -
          <?= $ano_1;?>
          &raquo;
          <?= $dia_2;?>
          -
          <?= $mes_pt_2;?>
          -
          <?= $ano_2;?>
          |</span></p>
        <?php
		 /// dialogue dates///
               switch ($today)
			   {
	case $today > $given_2 :
    echo'<strong> passado</strong>';
    break;
	
	case $today == $given_1:
    echo'<span class="hoje_2"> Hoje!</span>';
    break;   
	
    case  $given_1== $given_2 && $given_1 !== $todayw:
    echo'<span class="ultimo">  S&oacute; um dia!</span>';
    break;
	
	case $today == $given_2 :
    echo'<span class="ultimo"> ULTIMO DIA!</span>';
    break;
	
	case $given_1 == $todayw || $given_1 == $domingo :
	 echo'<strong>  Fim de semana</strong>';
    break;
	
	case $semana >= $given_1 || $given_1 <= $domingo:
   echo'<strong> Esta semana </strong>';
    break;
	
	case $today >= $given_1:
    echo'<strong> A decorrer</strong>';
    break;
    }
	?>
        
      </div>
      <div class="clearfix"></div>
    </div>
	
  </article>
  <?php endwhile;?>
   <?php else:?>
   <h3>Não existem eventos agendados</h3>
        <?php endif;?>
        <?php wp_reset_postdata(); ?>
  <div class="promos_nav">
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
</section>
