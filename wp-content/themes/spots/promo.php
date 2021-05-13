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

    <div class="col-md-8">
      <!--/gauche/-->
      <section id="post-<?php the_ID(); ?>">
        <div class="type-page">
          <!--/post/-->
          <div class="entry_page">
  <?php include ('includes/promo_single.php');?>
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
   <nav>
    <?php include ('includes/agenda_mes.php');?>
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