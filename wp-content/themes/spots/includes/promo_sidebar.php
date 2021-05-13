<!---liste eventos--->
<?php 
			////
			$post_page=3;
			 $today = date('Y-m-d');
			$todayw = date('Y-m-d', strtotime(' next saturday'));
			$domingo = date('Y-m-d', strtotime(' next sunday'));
			$semana = date('Y-m-d', strtotime(' last sunday  midnight'));
			 $date= date('d-F-Y');
$the_query = new WP_Query( array(
  'post_type' => 'promo',
  'posts_per_page' => $post_page,
  'meta_key' => 'vsip_data1',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_query' => array(
  array(
    'key' => 'vsip_data1',
    'value' => $today,
    'compare' => '>=',
    'type' => 'DATE'
  ))
));
?>
<?php if ($the_query-> have_posts() ) : ?>
<section  class="entry-content">
<header>
<h3> Agenda </h3>
</header>
 <!-- <div class="calendar"><p> <a href="http://www.check-inlove.com/blog/eventos-portugal/"> Eventos recomendados   &raquo;</a></p>
    <p class="bouton"><a href="http://www.check-inlove.com/blog/eventos-promos/" >SUGERIR EVENTO  </a></p></div>-->

  
  <?php while ($the_query-> have_posts() ) : $the_query->the_post();?>
    
    <?php $current_post = $post->ID;?>
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
			///
			$im_ev = teste_image(get_the_post_thumbnail( $current_post, 'thumbnail' ));
 !empty($im_ev)? $image_event= $im_ev : $image_event = 'http://www.check-inlove.com/blog/wp-content/themes/check-inlove/images/logo_ev.png';
			
			?>
  
 <div class="promos">
 <!--style="background-image:url('<?=$image_event;?>')-->
    <div class="mini_promo">
    <div class="promo_data">
      <div class="mes"><?= $mes_pt1;?></div>
		<div class="dia"><?= $dia_1;?></div>
         <div class="dia_decal"></div>
       <div > <?= $dia_2;?> / <?= $mes_pt_2;?></div>
	 
			</div>
    </div> 
    <?php  // if ($today > $givens) { wp_delete_post( $post->ID );} ?>
  <div class="promos_decal">
   <p class="promo_petit"><?php echo get_avatar( get_the_author_meta( 'ID' ), 25); ?> <small><?php the_author(); ?> </small></p>
    <p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
     <strong> <?php the_title(); ?></strong></a>&raquo;</p>
    <p class="promo_petit"><span class="local"><?php echo get_post_meta($post->ID, 'vsip_local', true); /// local?></span></p>
  
      <div class="aviso">
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
	
	
	 case $today >= $given_1:
    echo' A decorrer';
    break;
	
	case $semana >= $given_1 || $given_1 <= $domingo:
   echo' Esta semana';
    break;
	
	case 
	 $given_1 == $todayw || $given_1 == $domingo :
	 echo'<strong>  Fim de semana</strong>';
    break;
	
    }
	?>
    </div>
     </div>
     <div class="clearfix"></div>
     
  </div>
  <?php endwhile;?>
 <?php else: ?>
 
 <h2>N&atilde;o existem eventos agendados  a partir de <?php echo $today ;?></h2>
 
  <?php endif;?>
  
  
  <?php wp_reset_postdata(); ?>
      <p><a href="http://www.check-inlove.com/blog/eventos-portugal/"> Ver mais  eventos </a>&raquo;
      </p>
</section>