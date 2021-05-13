<?php 

/*
Template Name: Novo password
*/
global $wpdb, $user_ID;



if (!$user_ID) { //block logged in users

	if($_POST['action'] == "novo_pass"){
		if ( !wp_verify_nonce( $_POST['tg_pwd_nonce'], "tg_pwd_nonce")) {
		  exit("No trick please");
	   }  
		if(empty($_POST['pass_1'])) {
			echo "<div class='error'>Por favor digite uma senha </div>";
			exit();
		}
		
		if($_POST['pass_1'] !=  $_POST['pass_2']) {
			echo "<div class='error'> As senhas n&atilde;o s&atilde;o iguais !</div>";
			exit();
		}
		
		$new_password = $_POST['pass_1'];
		$reset_key = $_POST['key'];
				$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_activation_key = %s", $reset_key));

		wp_set_password( $new_password, $user_data->ID );

		echo "<div class='sucsses'>A sua senha foi alterada com sucesso <a href ='".get_bloginfo('url')."/login'>login</a></div>";
		
	exit();}

if(isset($_GET['key'])&& $_GET['action'] =="rec_pass"){
			   
			   $reset_key = $_GET['key'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT  user_activation_key FROM $wpdb->users WHERE user_activation_key = %s", $reset_key));
		$user_key= $user_data->user_activation_key;
if ($_GET['key']!= $user_key ) {exit("<h2> A sua senha ja foi alterada</h2>");}

include 'header.php';
 include 'includes/nav_top.php';
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
      <div class="type-page profil">
      <h3> Redefenir a sua nova senha </h3>
          <!--/post/-->
          
           <form class="user_form" id="wp_pass_reset" action="" method="post">	
           
         <div id="result"></div> <!-- To hold validation results -->
            <p><label>Nova Password</label>	<br />	
			<input type="password" class="text" name="pass_1" value="" /></p>
             <p>
			<label> Digite de novo password
			</label><br />
			<input type="password" class="text" name="pass_2" value="" />
             </p>
		<input type="hidden" class="text" name="key" value="<?= $reset_key?>" /><br />
			<input type="hidden" name="action" value="novo_pass" />
			<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
			<p> <input type="submit" id="submitbtn" class="reset_password" name="submit" value="Redefinir senha" /> 
			</p>
			
		  </form>
						<script type="text/javascript">  
			jQuery(function ($){
			$("#wp_pass_reset").submit(function() {			
			$('#result').html('<img src="<?php bloginfo('template_url'); ?>/images/ajax-loader.gif" class="loader" />').fadeIn();
			var input_data = $('#wp_pass_reset').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo get_permalink( $post->ID ); ?>",
			data: input_data,
			success: function(msg){
			$('.loader').remove();
			$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
			}
			});
			return false;
			
			});
			});
			</script>
			
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
      <header> </header>
    </div>
  </div>
  <!--/row-->
</div>
<!--//center/-->
<!--footer-->
<?php include 'footer.php';

}else {echo "<h2> existe algo de errado :(</h2>";}

} else {
	wp_redirect( home_url() ); exit(); }
	//redirect logged in user to home page

?>