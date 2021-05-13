<!--footer-->
<footer class="footer">
<div class="container"> 
<div class="col-md-4">
<header><h1 class="footer_h1"><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>">PEQUENO.EU </a></h1>
</header>
<p> <?php bloginfo('description'); ?></p>
  <nav>
     <?php wp_nav_menu(array('theme_location' => 'menu_bas',  'depth' => 0, 'container' => false,'menu_class' => 'list-inline', 'container_class' => false, 'menu_id' => false)); ?>
    <?php if (is_user_logged_in()):?>
    
         <?php wp_nav_menu(array('theme_location' => 'menu_user',  'depth' => 0, 'container' => false,'menu_class' => 'list-inline', 'container_class' => false, 'menu_id' => false)); ?>

    <?php endif;?>
    </nav>
</div>
<div class="col-md-8">
  <h3> Lugares / Places</h3>
<ul class="list-inline">
<?php wp_list_categories('show_count=1&title_li='); ?>
</ul></div>

  <div class="clearfix"></div>  
  <p class="text-center love"><small>Jorge Melo PEQUENO.EU <?= date('Y');?></small> - <a href="" title="web design" target="_blank"> JM</a></p>
</div>
  <?php wp_footer(); ?>
</footer>

</body>
</html>