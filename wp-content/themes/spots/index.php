<?php include 'header.php';?>
<?php include 'includes/nav_top.php';?>

<?php
	$args = array(
  'post_type' => 'slide',
  'numberposts' =>1,
   'orderby'       => 'rand',
   //'order'         => 'DESC'
);

	?>
    <?php   $the_query = new WP_Query($args ); if ($the_query-> have_posts() ) : ?>
        <?php  while ($the_query-> have_posts() ) : $the_query->the_post(); 
		
		$title = get_the_title( $post->ID);
		?>
        
       <?php $thumbnail = get_the_post_thumbnail( $post->ID, 'full' );
	   $image_slide = teste_image($thumbnail);
	   $title= get_the_title($post->ID);
	         endwhile;endif;
			 wp_reset_postdata();
	   ?>
<div class="hidden-xs load_fond"> 
<section class="top" style="background-image:url('<?php  echo $image_slide ;?>');">
<div class="container">
<div class="intro"><h1><?=$title;?></h1>
<h2>
Guia dos melhores locais "Guide of the best places" </h2>
<h3> <span class="explorar"><a href="https://www.pequeno.eu/blog/local/">Sugerir local</a></span></h3>
</div>
</div>
</section>
</div>

<!--centre-->
  <div class="container centre">
  <header>
    <h1>Atividade Recente</h1>
       </header>
  <div class="row"><a name="explorar"></a> 
       <div class="col-md-8"><!--/gauche/-->
<div id="content"> </div><!--/loopajax-->
<?php if (!is_user_logged_in()):?>
   <p id="log"></p>
   <?php endif;?>
<!--/nav-->
<div>
 <p class="text-center"> <button type="button"  id="more"class="btn btn-default btn-lg">+ Seguintes...</button></p>
 </div><!--//nav/-->
      </div> <!--/gauche/-->
             <div class="col-md-4">
             <!--favoritos-->
      <div class="hidden-xs"> <?php include ('includes/favoritos.php');?></div>
      <!--agenda mess-->
            <?php include ('includes/agenda_mes.php');?>
             <?php include ('includes/promo_sidebar.php');?>
             <header> 
             <h3> HOT SPOTS </h3>
             </header>
             <?php wp_tag_cloud('smallest=12&largest=12&number=10&order=DESC&orderby=count&separator=, '); ?>...
             </div>
    </div><!--/row-->
</div><!--//center/-->
<!--footer-->
<?php include 'footer.php';?>