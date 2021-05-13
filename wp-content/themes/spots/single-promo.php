<?php include 'header.php';?>
<?php include 'includes/nav_top.php';?>
    <?php if (have_posts() ) : ?>
            <?php
	 $today = date('Y-m-d', strtotime('+1 hours'));
	$local= get_post_meta($post->ID, 'vsip_local', true);
	
   $given_1= get_post_meta($post->ID, 'vsip_data1', true);
		    $mes_1 = date("M", strtotime($given_1));
			$dia_1 = date("d", strtotime($given_1));
			$ano_1 = date("Y", strtotime($given_1));
			$mes_pt1= modar_mes_int($mes_1, $given_1); 
			///
			$given_2 = get_post_meta($post->ID, 'vsip_data2', true);//data fim
		
			$mes_2 = date("M", strtotime($given_2));
			$dia_2 = date("d", strtotime($given_2));
			$ano_2 = date("Y", strtotime($given_2));
			$mes_pt_2= modar_mes_int($mes_2, $given_2); 
	//	
	?>

<!--centre-->
<div class="container centre_page">
  <header>
    <h1>
 <?php the_title();?>
    </h1>
  </header>
  <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a>|
   404
  </p>
  <div class="row page_row">

    <div class="col-md-8">
      <!--/gauche/-->
      <section id="post-<?php the_ID(); ?>">
        <div class="type-page">
          <!--/post/-->
          <div class="entry_page">
          
           <?php while (have_posts()) : the_post() ?>
<article>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
       
          <div class="entry-content promo_single">
          <div class="s">
             <div class="promo_data">
		<p class="dia"><?php echo $dia_1;?></p>
	     <p class="mes"><?php echo $mes_pt1;?></p>
         <p><?php echo $ano_1;?></p>
			</div>
            </div>
            <div class="separa"> </div>
         <div class="promo_content">  <?php if( '' != get_the_post_thumbnail()) : ?><div class="promo_image"><figure>
      <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>">
      <?php the_post_thumbnail('full'); ?></a>
</figure></div><?php endif ;?>
<h3> Descri&ccedil;&atilde;o</h3>
 <?php the_content(); ?>
 <div class="separa"> </div>
 </div>
 <p> <span class="data_promo">

  <?= $dia_1;?>-<?= $mes_pt1;?>-<?= $ano_1;?> </span> At&eacute; &raquo; <span> <?= $dia_2;?>-<?= $mes_pt_2;?>-<?= $ano_2;?></span></p> <p class="local" > <?=$local;?> 
            <p class="expired"><?php   if ($today == $given_1) { echo'<strong> HOJE!</strong>';} ?></p>
            <?php  if ($local): ?>
            <p class="chegar"  id="drive"></p>
			 <!--mapa-->
             <script>
var geocoder;
var map;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom:15,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

  var address = " <?php echo $local;?>";
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	 document.getElementById('drive').innerHTML= "<a href='https://maps.google.pt/maps?daddr="+ results[0].geometry.location.lat()+","+ results[0].geometry.location.lng()+ "&hl=pt-PT&sll="+  results[0].geometry.location.lat()+","+  results[0].geometry.location.lng() + "&z=16' target='_blank'>Como chegar aqui?  </a> | <a href='http://check-inlove.com/atelier/google_places/?lat="+ results[0].geometry.location.lat()+"&lng="+ results[0].geometry.location.lng()+"'target='_blank'>A volta (800m)"

    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
<h3> Localiza&ccedil;&atilde;o</h3>
			 <div id="mapa" class="local_map">Loading... procurar localiza&ccedil;&atilde;o </div>
             

		    <?php  endif;?>
                   <p> <a href="http://www.check-inlove.com/blog/eventos-portugal/"><strong>Ver + eventos e promo&ccedil;&otilde;es em Portugal &raquo;</strong></a></p>

            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
            <div class="pub">
<!--pub-->
          </div>
          </div>
           <div class="nav_promo">
           <h3> Comentar</h3>
           <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-num-posts="3" data-mobile="false"></div></div>
           
          <!-- ##entry-content -->
<div class="social">
        <p> Partilhar na sua rede social favorita</p><a class=" btn-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">Facebook</a> <a  class="btn-google" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"> Google+</a> <a  class=" btn-tweet" target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=PHOTOSPOT">Tweet</a> <a  class="btn-tumblr" target="_blank" href="http://www.tumblr.com/share"> Tumblr</a>  <a  class="btn-pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&description=<?php the_title(); ?>&media=<?php echo pinterest_image();?>">Pin on Pinterest</a></div>
        </div>
        
      </article>
       <?php endwhile; endif; ?>
          </div>
          <!--/entry/-->
        </div>
        <!--/post/-->
      </section>

      <!--/nav-->
      <div> </div>
      <!--//nav/-->
    </div>
    <!--/gauche/-->
    <div class="col-md-4">
      <header>
        <h3> Menu paginas</h3>
      </header>
   <nav>
     <?php wp_nav_menu(array('menu' => 'menu_bas',  'depth' => 0, 'container' => false,'menu_class' => '', 'container_class' => false, 'menu_id' => false)); ?>
    <?php if (is_user_logged_in()):?>
    <h3> As minhas informa&ccedil;&otilde;es </h3>
         <?php wp_nav_menu(array('menu' => 'user',  'depth' => 0, 'container' => false,'menu_class' => '', 'container_class' => false, 'menu_id' => false)); ?>

    <?php endif;?>
    </nav>
    </div>
  </div>
  <!--/row-->
</div>
<!--//center/-->
<!--footer-->
<?php include 'footer.php';?>