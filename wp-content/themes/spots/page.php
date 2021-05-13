<?php include 'header.php';?>
<?php include 'includes/nav_top.php';

?>
<!--centre-->
<div class="container centre_page">
  <header>
    <h1>
      <?php the_title(); ?>
    </h1>
  </header>
  <p><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>" class="author"> Home </a>|
    <?php the_title(); ?>
  </p>
  <div class="row page_row">
    <?php // our loop 
if (have_posts()) :?>
    <div class="col-md-8">
<div class="row">
      <!--/gauche/-->
      <?php  while (have_posts()): the_post();?>
      <section id="post-<?php the_ID(); ?>">
        <div <?php post_class(); ?>>
          <!--/post/-->
          <div class="entry_page">
            <?php the_content(); ?>
          </div>
          <!--/entry/-->
        </div>
        <!--/post/-->
      </section>
      <?php endwhile; endif;?>
       <!--/nav-->
      <div> </div>
      <!--//nav/-->
      </div>
    </div>
    <!--/gauche/-->
    <div class="col-md-4 hidden-xs">
      <header>
        <h3> Menu paginas</h3>
      </header>
      <nav>
     <?php wp_nav_menu(array('menu' => 'nornal',  'depth' => 0, 'container' => false,'menu_class' => '', 'container_class' => false, 'menu_id' => false)); ?>
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