  <!---liste eventos--->
               <?php 
			////
			$today= date('Y-m-d');
			$domingo = date('Y-m-d', strtotime(' next sunday'));
			$todayw = date('Y-m-d', strtotime(' next saturday'));
			 $date= date('d-F-Y');
			 $month = date('Y-m'.'01');

		$args =	array(
  'post_type' => 'promo',
  'posts_per_page' => 1,
  'meta_key' => 'vsip_data1',
  'orderby' => 'rand',
  'order' => 'ASC',
  'meta_query' => array(
  array(
    'key' => 'vsip_data1',
    'value' => $today,
    'compare' => '==',
    'type' => 'DATE'
  ))
);
$the_query = new WP_Query($args);
?>
        <?php if ($the_query-> have_posts() ) : ?>

         <div class="page-title-container">
<div class="page-title popsugar-bg">EVENTOS </div>
<span class="arrow-right-big popsugar-border"></span>
</div>
<section>
<ul class="hoje">
<p class="hoje_top"> A começar hoje ! / Start today </p>


<?php while ($the_query-> have_posts() ) : $the_query->the_post();?>
<li>
<?php $current_post = $post->ID;?>

<?php  // if ($today > $givens) { wp_delete_post( $post->ID );} ?>

  <h2 class="liste"><small><?php the_author(); ?>» </small><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><strong> <?php the_title(); ?></strong></a>&raquo;</h2>
	     <p class="promo_petit"> <span class="data_promo"><?php  $given_1= get_post_meta($post->ID, 'vsip_data1', true);// data principio
		    
			
		 
			$mes_1 = date("M", strtotime($given_1));
			$dia_1 = date("d", strtotime($given_1));
			$ano_1 = date("Y", strtotime($given_1));
			$mes_pt1= modar_mes($mes_1, $given_1);
			echo $dia_1.'-'.$mes_pt1.'-'.$ano_1; ?>
	       /  
	       <?php $given_2 = get_post_meta($post->ID, 'vsip_data2', true);//data fim
		
			$mes_2 = date("M", strtotime($given_2));
			$dia_2 = date("d", strtotime($given_2));
			$ano_2 = date("Y", strtotime($given_2));
			$mes_pt_2= modar_mes($mes_2, $given_2);
			echo $dia_2.'-'.$mes_pt_2.'-'.$ano_2;?> </span>
	       <span class="local"><?php echo get_post_meta($post->ID, 'vsip_local', true); /// local?></span></p>
         
  </li>
     <?php endwhile;?>
               <div class="separa"> </div>
             <p><small><a href="http://www.check-inlove.com/blog/eventos-portugal/">Ver mais eventos e promoções em Portugal »</a></small></p>  
            <?php endif;?>
         <?php wp_reset_postdata(); ?>
              
                
      </ul> 
      </section>
      <!--///fim_promo-->