<?php
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 *
/* Get user info. */
global $current_user, $wp_roles;
get_currentuserinfo();
require_once ('includes/local_avatar.php');
/* Load the registration file. */
require_once( ABSPATH . WPINC . '/registration.php' );
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

   if ( !empty($_POST['pass1'] ) || !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2']){
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
		}else{
            $error[] = __('As passwords n&atilde;o s&atilde;i iguais.  O seu password n&atilde;o foi actualizado', 'profile');
    }
	}

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
       wp_update_user( array ('ID' => $current_user->ID, 'user_url' => esc_attr( $_POST['url'] )));
	   
  if ( !empty( $_POST['email']) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('Email incompleto ou  inv&aacute;lido.', 'profile');
         elseif(email_exists(esc_attr( $_POST['email'])) )
            $error[] = __('Este e-mail j&aacute; est&aacute; a ser utilizado por outro usu&aacute;rio. tente um diferente', 'profile');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['display_name'] ) )
        wp_update_user(array('ID' => $current_user->ID, 'display_name' => esc_attr( $_POST['display_name'] )));
      update_user_meta($current_user->ID, 'display_name' , esc_attr( $_POST['display_name'] ));

        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink().'?updated=true' ); exit;
    }       
}
///AVATAR///
if(isset($_POST['sub']))
{
    $fname=$_FILES['file']['name'];
    $ftype=$_FILES['file']['type']; 
}
if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])     ){
    $simple_local_avatars = new Simple_Local_Avatarssss;
    $result = $simple_local_avatars->edit_user_profile_update($_FILES,$user_id);
	$error_img =  $simple_local_avatars->avatar_upload_error;
  }
include 'header.php';?>

<?php include 'includes/nav_top.php';

?>
<!--centre-->
<div class="container centre_page">
  <header>
    <h1>
    <?php the_title(); ?>

    </h1>
  </header>

  <div class="row page_row">

    <div class="col-md-8">
      <!--/gauche/-->
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <section id="post-<?php the_ID(); ?>">
      
        <div class="type-page profil ">
          <!--/post/-->
         <?php the_content(); ?>
          <?php if ( !is_user_logged_in() ) : ?>
                     <div class="error" role="alert">Para actualizar as suas informa&ccedil;&otilde;es de autor, deve ter  sess&atilde;o iniciada para aceder </div>
                 <!-- .warning -->
          <?php else : ?>
           <h3>As suas informa&ccedil;&otilde;es </h3>
           <p>
		   <?php  $fb =  get_user_meta($user->ID, '_fbid', true);?>
			<!-- FB-->
	<?php if ($fb):?>
       <h3>O seu Perfil  &quot;<?php echo $current_user->user_login ?>&quot; .</h3>
		   <?php if ($fb){ echo "<p>Hello! <strong> $current_user->user_login</strong> </p> <img src='https://graph.facebook.com/$fb/picture' />"; }?>
           
              <?php else:?>
              <!--NORMAL LOGIN-->
              
    <h3>O seu prefil" <?=$current_user->user_login?>"</h3>
    <p> Escolher uma nova imagem de perfil </p>
		   <p><?php echo get_avatar($user->id,96 ,$default, $alt);?></p>
    
    <?php if ( $result) : ?> <div id="message" class="updated"><p>A sua imagem de perfil foi actualizada.</p></div> <?php endif; ?>
    <?php if ($error_img):?> <div id="message" class="error"><p><?=$error_img?></p></div> <?php endif; ?>
<form id="input_avatar" action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file"><br />
    <input id="submitbtn" type="submit" name="sub" value="Enviar a imagem">
</form>
                
                 <?php endif; ?>
	<!-- end avatar-->
        <hr />
        
        
           <?php $user_post_count = count_user_posts($current_user->ID ); ?>
           <p><strong> Locais publicados :</strong> <?=$user_post_count; ?> 
           <div>
             <div></div>
           </div>
           <div>
             <div id="tw-target">
               <div id="tw-target-text-container">
               </div>
             </div>
           </div>
           <p> 
          <?php if ($user_post_count >0):?>
           <p> <a href="<?php  echo get_author_posts_url($current_user->ID); ?>" title="<?=$current_user->user_login;?>"> Os seus locais </a> &raquo;</p><?php endif;?>
           <h3> Editar informa&ccedil;&otilde;es</h3>
      <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="updated"> O seu perfil foi actualizado com sucesso.</div> <?php endif; ?>
              <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
              <form method="post" id="adduser" action="<?php the_permalink(); ?>">
                <p>
                      <label for="first-name">Nome</label>
                      <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
              </p><!-- .form-username -->
                  <p >
                    <label for="last-name">Apelido</label>
                      <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                  </p><!-- .form-username -->
                  <!-- .form-display_name -->
                  <p class="form-display_name"><label for="display_name">Nome publico</label><br />
	
		<select name="display_name" id="display_name"><br/>
		<?php
			$public_display = array();
			$public_display['display_nickname']  = $current_user->nickname;
			$public_display['display_username']  = $current_user->user_login;

			if ( !empty($current_user->first_name) )
				$public_display['display_firstname'] = $current_user->first_name;

			if ( !empty($current_user->last_name) )
				$public_display['display_lastname'] = $current_user->last_name;

			if ( !empty($current_user->first_name) && !empty($current_user->last_name) ) {
				$public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
				$public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
			}

			if ( ! in_array( $current_user->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
				$public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;

			$public_display = array_map( 'trim', $public_display );
			$public_display = array_unique( $public_display );

			foreach ( $public_display as $id => $item ) {
		?>
			<option <?php selected( $current_user->display_name, $item ); ?>><?php echo $item; ?></option>
		<?php
			}
		?>
		</select></p><!-- .form-display_name -->
                  <p> 
                  <label for="email">Email</label>
                   (email actual -> <?php echo $current_user->user_email;?>) 
                      <input class="text-input" name="email" type="text" id="email"  value="" />
                  </p><!-- .form-email -->
                  <p>
                      <label for="url">Web</label>
                      <input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
                  </p><!-- .form-url -->
                  <!-- .form-password -->
                  <hr />
                  <h3> Redefenir a sua senha </h3>
                  <?php if ($fb):?> <em>(Se utilizou a sua conta facebook para entrar no site pode redefenir uma senha para entrar no site com login normal)</em> <?php endif;?> 
                   <p>
                        <label for="pass1">Nova senha</label>
                        <input class="text-input" name="pass1" type="password" id="pass1" />
                    </p><!-- .form-password -->
                    <p>
                        <label for="pass2">Repetir a senha</label>
                        <input class="text-input" name="pass2" type="password" id="pass2" />
                    </p><!-- .form-password -->
                  <hr />
                  <p>
                      <label for="description">Sobre mim ( m&aacute;ximo 300 caracteres )</label>
                      <textarea name="description" id="description" rows="3" cols="50" maxlength="300"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                  </p>
                  <!-- .form-textarea -->
                  <?php 
                        //action hook for plugin and extra fields
                        //do_action('edit_user_profile',$current_user); 
                    ?>
                 
            <p>
                      <?php echo $referer; ?>
                      <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Actualizar informa&ccedil;&otilde;es ', 'profile'); ?>" />
                      <?php wp_nonce_field( 'update-user_'. $current_user->ID ) ?>
                      <input name="action" type="hidden" id="action" value="update-user" />
                  </p><!-- .form-submit -->
              </form><!-- #adduser -->
          <?php endif; ?>
        
          <!--/entry/-->
        </div>
        <!--/post/-->
      </section>
        <?php endwhile; ?>
<?php else: ?>
    <p class="error">
        <?php _e('Sorry, no page matched your criteria.', 'profile'); ?>
    </p><!-- .no-data -->
<?php endif; ?>

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