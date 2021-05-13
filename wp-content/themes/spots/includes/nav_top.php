<header><!--/nav/-->
<?php $user= wp_get_current_user();
    $fb =  get_user_meta($user->ID, '_fbid', true);
if ($fb){ $mini= "<img src='https://graph.facebook.com/$fb/picture'/>";}else{ $mini = get_avatar($user->ID,50);}?>
  <nav class="nav_top"> <span class="toggle-top menu"></span><div  class="container"> <h1 class="top_h1"><a href="<?php bloginfo('siteurl');?>" title="<?php bloginfo('name');?>">PEQUENO.EU<small> BLOG</small></a></h1> 
  <ul class="list-inline nav_petit">
    <li class="env_photo"><a href="<?php bloginfo('url'); ?>/eventos-promos/">Sugerir evento</a></li><li><?php if (is_user_logged_in()){echo "| Hello, $user->display_name! ".get_avatar($user->ID,20);}?></li></ul></div>
   </nav>
   </header><!--/nav/-->
<aside id="nav_p" class="navigation"><!--/navigation-->
  <div class="container">
  <div class="col-md-6">
            <label for="searchform">Pesquisar spots</label>
  <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
    <div class="form-group">
<input name="s" type="text"  class="form-control pesquisar"  id="s" value="<?php the_search_query(); ?>" placeholder="pesquisar"/>
</div>
  </form>
  <?php if (is_user_logged_in()):?>
   <div class="media_nav"> <p><?php echo "Hello, $user->display_name! " .$mini;?> <a href="<?php echo wp_logout_url( home_url() );?>" title="Logout"> Logout</a></p> 
     <p><a href="<?php bloginfo('url'); ?>/perfil/" title="minhas informa&ccedil;&otilde;es">Editar perfil</a></p>
   </div>
   <?php endif;?>
  <ul class="nav_sidebar">
  <li> <a href="http://www.pequeno.eu/blog/local/">Sugerir local</a></li>
  <li> <a href="http://www.pequeno.eum/blog/eventos-promos/">Sugerir evento</a></li>
  </ul>
   <p> Explorar lugares/ explore placess</p>
  <ul class="nav_sidebar">
<?php wp_list_categories('&title_li=');//show_count=1 ?>
</ul>
    </div>
   <div class="col-md-6">
  <p>Explorar SPOTS</p>
 <div class="tagcloud">
<?php wp_tag_cloud('smallest=12&largest=20&number=50&order=ASC&orderby=count'); ?>
</div>
  </div>
  <div class="clearfix"></div>

   <p class="toggle-top fechar"> X fechar</p>
  </div>
 
  </aside><!--/navigation/-->
   