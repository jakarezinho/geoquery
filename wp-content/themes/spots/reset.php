<?php 

/*
Template Name: reset pass
*/
global $wpdb, $user_ID;

if (!$user_ID) { //block logged in users

	if($_POST['action'] == "tg_pwd_reset"){
		if ( !wp_verify_nonce( $_POST['tg_pwd_nonce'], "tg_pwd_nonce")) {
		  exit("No trick please");
	   }  
		if(empty($_POST['user_input'])) {
			echo "<div class='error'>Por favor o seu nome de utilizador ou E-mail address</div>";
			exit();
		}
		//We shall SQL escape the input
		$user_input = $wpdb->escape(trim($_POST['user_input']));
		
		if ( strpos($user_input, '@') ) {
			$user_data = get_user_by('email',$user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				echo "<p class='error'>inv&aacute;lido  E-mail address!</p>";
				exit();
			}
		}
		else {
			$user_data = get_user_by('login',$user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				echo "<p class='error'>inv&aacute;lido Username!</p>";
				exit();
			}
		}
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if(empty($key)) {
			//generate reset key
			$key = wp_generate_password(20, false);
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));	
		}
		
		//mailing reset details to the user
		$headers = "From: photospot <info@pequeno.eu>"."\r\n";
		$message = __('Alguém pediu a redefinição da senha para a seguinte conta:') . "\r\n\r\n";
		$message .= get_option('siteurl') . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('Se isto foi um erro , apenas ignore este email e nada vai acontecer.') . "\r\n\r\n";
		$message .= __('Para redefinir sua senha , visite o seguinte endereço:') . "\r\n\r\n";
		$message .= get_bloginfo('url')."/newpass?key=$key&action=rec_pass". "\r\n";
		
		if ( $message && !wp_mail($user_email, 'Redefinir nova senha', $message,$headers) ) {
			echo "<p class='error'>Email failed to send for some unknown reason.<p>";
			exit();
		}
		else {
			echo "<p class='updated'>Um email foi enviado com instru&ccedil;&otilde;es para repor a sua password.<br>(<strong>Verifique a sua pasta spam !</strong>)</p>";
			exit();
		}
		
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
      <h3> Redefenir aqui a sua senha</h3>
          <!--/post/-->
          
           <form class="user_form" id="wp_pass_reset" action="" method="post">	
           
         <div id="result"></div> <!-- To hold validation results -->
            <label><p><strong> Introduzir aqui  seu nome de utilizador ou email</strong><br> 
           <small>( A sua nova password sert enviada para o email utilizada no registo VERIFIQUE A SUA PASTA SPAM!)</small> </p> </label>		
			<p><input type="text" class="text" name="user_input" value="" /></p>
			
			<input type="hidden" name="action" value="tg_pwd_reset" />
			<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
			<p><input type="submit" id="submitbtn" class="reset_password" name="submit" value="Redefinir senha" /></p>
			
			</form>
			
			<script type="text/javascript">  
			jQuery(function ($){
			$("#wp_pass_reset").submit(function() {			
			$('#result').html('<img src="<?php bloginfo('template_url'); ?>/images/ajax-loader.gif" class="loader" />').fadeIn();
			var input_data = $('#wp_pass_reset').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo get_permalink($post->ID); ?>",
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
	}
	
}
else {
wp_redirect( home_url() );
}

?>