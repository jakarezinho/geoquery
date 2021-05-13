<?php include 'header.php';?>
<?php include 'includes/nav_top.php';

?>
<!--centre-->
<div class="container centre_page">
  <header>
    <h1>
     NO FOUND :(
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
<h3> Ops !! algo correu mal.. a pagina que pediu n&atilde;o existe o foi removida </h3>
<p><a href="<?php bloginfo('url'); ?>">&laquo; Voltar a home page</a></p>
<h3> Pesquisar</h3>
<?php get_search_form(); ?>
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