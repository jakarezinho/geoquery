<?php
function fb_head(){

?>
<script type="text/javascript">
window.fbAsyncInit = function(){
FB.init({appId:'584088528370791', status:true, cookie:true, xfbml:true, oauth:true});
};
</script>
<div id="fb-root"></div>
<script type="text/javascript">
(function() {
var e = document.createElement('script');
e.type = 'text/javascript';
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
e.async = true;
document.getElementById('fb-root').appendChild(e);
}());
</script>
<?php
}
add_action( 'wp_head', 'fb_head' );
?>
<?php
function wp_ajax_fb_intialize(){
@error_reporting( 0 ); // Don't break the JSON result
header( 'Content-type: application/json' );

if( !isset( $_REQUEST['FB_response'] ) || !isset( $_REQUEST['FB_userdata'] ))
die( json_encode( array( 'error' => 'Authonication required.' )));

$FB_response = $_REQUEST['FB_response'];
$FB_userdata = $_REQUEST['FB_userdata'];
$FB_userid = (int) $FB_userdata['id'];

//NEW CODE INSERT - check if token is valid
$token = $FB_response['authResponse']['accessToken'];
$path = 'https://graph.facebook.com/me?access_token='.$token;
$content = @file_get_contents($path);
$fb_user = json_decode($content);
if ($fb_user->id != $FB_userdata['id'])
   die( json_encode( array( 'error' => 'FB login error' )));
/////
if( !$FB_userid )
die( json_encode( array( 'error' => 'Please connect your facebook account.' )));

global $wpdb;
$user_ID = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_fbid' AND meta_value = '$FB_userid'" );
// check if the user id is valid
if( false === ($check_user = get_userdata($user_ID)) )
{
  $user_ID = false; // set to false to force create a new user
}
////
if( !$user_ID ){
$user_email = $FB_userdata['email'];
$user_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '$user_email'" );

if( !$user_ID ){
if ( !get_option( 'users_can_register' ))
die( json_encode( array( 'error' => 'Registration is not open at this time. Please come back later..' )));

extract( $FB_userdata );

$display_name = $name;
$user_login = $username;


//if( empty( $verified ) || !$verified )
//die( json_encode( array( 'error' => 'Your facebook account is not verified. You hae to verify your account before proceed login or registering on this site.' )));

$user_email = $email;
if ( empty( $user_email ))
die( json_encode( array( 'error' => 'Please re-connect your facebook account as we couldnt find your email address..' )));

if( empty( $name ))
die( json_encode( array( 'error' => 'empty_name', 'We didnt find your name. Please complete your facebook account before proceeding..' )));

if( empty( $user_login ))
$user_login = sanitize_title_with_dashes( sanitize_user( $display_name, true ));

if ( username_exists( $user_login ))
$user_login = $user_login. time();

$user_pass = wp_generate_password( 12, false );
$userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name' );

$user_ID = wp_insert_user( $userdata );
if ( is_wp_error( $user_ID ))
die( json_encode( array( 'error' => $user_ID->get_error_message())));

add_user_meta( $user_ID, '_fbid', (int) $id );
}
else{
add_user_meta( $user_ID, '_fbid', (int) $FB_userdata['id'] );
}
}

wp_set_auth_cookie( $user_ID, false, false );
die( json_encode( array( 'loggedin' => true )));
}
add_action( 'wp_ajax_nopriv_fb_intialize', 'wp_ajax_fb_intialize' );
?>
<?php
function fb_footer(){
if( is_user_logged_in()):
	/*echo "<script type='text/javascript'> jQuery('#facebook_connect').hide(); </script>";*/
return;
endif;
?>
<script type="text/javascript">
jQuery(document).on( "click",'.facebook_connect', function(){
FB.login(function(FB_response){
if( FB_response.status === 'connected' ){
	fb_intialize(FB_response);
}
},
{scope: 'email'});
});

function fb_intialize(FB_response){
	FB.api( '/me', 'GET', 
		{'fields':'id,email,name,verified,name'},
		function(FB_userdata){
			jQuery.ajax({
				type: 'POST',
				url: '<?php echo admin_url( 'admin-ajax.php'); ?>',
				data: {"action": "fb_intialize", "FB_userdata": FB_userdata, "FB_response": FB_response},
				success: function(user){
					if( user.error ){
						alert( user.error );
					}
					else if( user.loggedin ){
						window.location.reload();
					}
				}
			});
		}
	);
};
</script>

<?php
}
add_action( 'wp_footer', 'fb_footer' );


?>
