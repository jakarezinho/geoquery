<?php 

/*
Template Name: register
*/
require_once(ABSPATH . WPINC . '/registration.php');
global $wpdb, $user_ID;
//Check whether the user is already logged in
if (!$user_ID) {

		if($_POST){
			//We shall SQL escape all inputs
			$username = $wpdb->escape($_POST['username']);
			if(empty($username)) { 
				echo "<p class='error'>Campo utilizador vazio.</p>";
				exit();
			}
			$email = $wpdb->escape($_POST['email']);
			if(!is_email ($email)) { 
				echo "<p class='error'>Email inv&aacute;lido ou incompleto.</p>";
				exit();
			}		
		
				$random_password = wp_generate_password( 12, false );
				$status = wp_create_user( $username, $random_password, $email );
				
				if ( is_wp_error($status) ){ 
				     $error_string = $status->get_error_message();
					echo " <p class='error'>$error_string</p>";
				}else {
					$site = get_bloginfo('name');
					$headers = "From: photospot <info@pequeno.eu>"."\n";
					$subject = "Registo com sucesso no site -$site\n";
					$msg = "Registo bem sucedido no site $site\nDetalhes para login\r\n\r\nUsername: $username\nPassword: $random_password\n\r\n";
					$msg .= "Os dados do registo podem ser alterados em seguida no site)\n\r\n";
					$msg .= "Url de login- " .esc_url( home_url( '/' ) )."login/";
					wp_mail( $email, $subject, $msg, $headers );

					echo "<p class='updated'>Por favor consulte a seu email para dados de acesso.<br><strong>(Verifique a caixa spam do seu email!)</strong></p>";
				}

			exit();
	} else { 


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
          <!--/post/-->
            <?php 					
			if(get_option('users_can_register')) { //Check whether user registration is enabled by the administrator
			?>
			
			<h3> Criar registo no PHOTOSPOT</h3>
			<div id="result"></div> <!-- To hold validation results -->
	  <form id="wp_signup_form" action="" method="post">
	   <p> <label> Escolher um nome de utilizador</label> 
 
			<input type="text" name="username" class="text" value="" /></p>
			<p><label>Email address</label>
			<input type="text" name="email" class="text" value="" /> </p>
			<p>(Os dados de acesso ao site ser&atilde;o enviados para o email de registo)</p>
		<p><input type="submit" id="submitbtn" name="submit" value="Criar registo" /></p>
			
		</form>
			<?php echo "<p> Ja estou registado login <a href='".esc_url( home_url( '/' ) )."login/'> Login no site </a></p>";?>
			<script type="text/javascript">  	
			jQuery(function ($){
			$("#submitbtn").click(function() {
			
			$('#result').html('<img src="<?php bloginfo('template_url'); ?>/images/ajax-loader.gif" class="loader" />').fadeIn();
			var input_data = $('#wp_signup_form').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo "https://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
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
			
			<?php 
				}
	
			else echo "Registration is currently disabled. Please try again later.";
			?>
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

	}
}
else {
	echo "<script type='text/javascript'>window.location='". get_bloginfo('url') ."'</script>";
	exit();
}

?>