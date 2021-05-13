<?php 

/*
Template Name: login
*/
global $user_ID;
$url= get_bloginfo('url');
if (!$user_ID) {

	if($_POST){
		//We shall SQL escape all inputs
		$username = $wpdb->escape($_REQUEST['username']);
		$password = $wpdb->escape($_REQUEST['password']);
		$remember = $wpdb->escape($_REQUEST['rememberme']);

		if($remember) $remember = "true";
		else $remember = "false";
		$login_data = array();
		$login_data['user_login'] = $username;
		$login_data['user_password'] = $password;
		$login_data['remember'] = $remember;
		$user_verify = wp_signon( $login_data, false ); 
		//wp_signon is a wordpress function which authenticates a user. It accepts user info parameters as an array.
		
		if ( is_wp_error($user_verify) ) {

			echo "<span class='error'>Password o nome de utilizador inv&aacute;lido!</span>";
			exit();
		} else {	
			//wp_redirect($url);
			echo "";
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
							<!--/post/-->
							<div class="">
								<h3> LOGIN</h3>
								<div id="result"></div> <!-- To hold validation results -->
								<form id="wp_login_form" action="" method="post">
									<p>
										<label>Username</label>
										<input type="text" name="username" class="text" value="" />
									</p>
									<p><label>Password</label>
										<input type="password" name="password" class="text" value="" /> </p>
										<p>
											<label>
												<input name="rememberme" type="checkbox" value="forever" />
											Lembrar-me? </label></p>

											<p><input type="submit" id="submitbtn" name="submit" value="Login" /></p>

										</form>
										<hr />
										<p><a href="<?php echo esc_url( home_url( '/' ) );?>redefinir-senha/"> Password esquecida ?</a></p>
										<p><a href="<?php echo esc_url( home_url( '/' ) );?>registar/">Registar </a></p>

										<?php  do_action( 'wordpress_social_login' ); ?>
										<script type="text/javascript">  
											jQuery(function ($){
												$("#submitbtn").click(function() {
													$('#result').html('<img src="<?php bloginfo('template_url'); ?>/images/ajax-loader.gif" class="loader" />').fadeIn();
													var input_data = $('#wp_login_form').serialize();
													var url ="<?=get_bloginfo('url')?>";
													$.ajax({
														type: "POST",
														url:  "<?php echo "https://". $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>",
														data: input_data,
														success: function(msg){
															$('.loader').remove();
															if(msg== ""){
																$(location).attr('href',url);
															}
															$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
											
														}
													});
													return false;

												});
											});
										</script>

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
			wp_redirect($url);
		}

		?>