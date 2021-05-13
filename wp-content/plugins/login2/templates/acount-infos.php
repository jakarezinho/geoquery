<div id="register-form" class="widecolumn">
	
	<?php

	if ( $attributes['show_title'] ) : ?>
		<h3><?php _e( 'Profil Info', 'personalize-login' ); ?></h3>

	<?php endif;?>
	<?php $errors = $attributes ['errors'];
	if ( count( $errors  ) > 0 ) : ?>
		<?php foreach ( $errors as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>
	<!--//infos-->
	<?php if (isset($attributes['infos'])) :?>

	<h4><?php echo $attributes['infos'];?></h4>
<?php  endif;?>
<h3>Imagem de perfil </h3>
<p>Escolher imagem de profil</p>
<p> <?php  echo do_shortcode( '[basic-user-avatars]');?></p>
<?php $current_user=wp_get_current_user() ;// var_dump($current_user);?>

<hr>
<h3> As suas informações</h3>
<form id="acount_info" action="<?php echo get_permalink(); ?>?" method="post">
	<p class="form-row">
		<label for="email"><?php _e( 'Email', 'personalize-login' ); ?></label> (o seu email actual)
		<input type="text" name="email" id="email" value=""  placeholder="<?php echo $current_user->user_email;?>">
	</p>

	<p class="form-row">
		<label for="first_name"><?php _e( 'Primeiro nome', 'personalize-login' ); ?></label>
		<input type="text" name="first_name" id="first-name" value="" placeholder="<?php echo the_author_meta( 'first_name', $current_user->ID );?>"></p>

		<p class="form-row">
			<label for="last_name"><?php _e( 'Segundo nome', 'personalize-login' ); ?></label>
			<input type="text" name="last_name" id="last-name" value="" placeholder="<?php echo the_author_meta( 'last_name', $current_user->ID );?>">
		</p>

		<input type="hidden" name="user_id" id="user_id" value="<?php echo $current_user->ID;?>">
         <label>Escolher nome a mostrar</label><br/>
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
		</select>


	<p><label for="description"><?php _e( 'infos sobre mim', 'personalize-login' ) ?></label></p>
	<p><textarea name="description" id="description" rows="5" cols="30" placeholder="<?php echo the_author_meta( 'description', $current_user->ID );?>"></textarea></p>
	

	<p class="signup-submit">
		<input type="submit" name="submit" class="register-button"
		value="<?php _e( 'Actualizar', 'personalize-login' ); ?>"/>
	</p>
</form>
</div>