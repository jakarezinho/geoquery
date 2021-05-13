<!DOCTYPE html>
<html <?php language_attributes(); ?>><head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="apple-touch-icon" sizes="72x72" href="http://www.check-inlove.com/ios-72.png">
<link rel="apple-touch-icon" sizes="114x114" href="http://www.check-inlove.com/ios-114.png">
<link rel="apple-touch-icon" href="http://www.check-inlove.com/ios-57.png">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   
    
<?php 
  // bootsatrap///
   wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );

   //
	wp_enqueue_script('google_maps','https://maps.googleapis.com/maps/api/js?key=AIzaSyAp8ewZvzi0U9CFUYNqSSVQ_BKoXV4GOlU&libraries=places');
	 wp_enqueue_script('jquery');
	  wp_enqueue_script("bootstrap", "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery'));
	 wp_enqueue_script('js', get_bloginfo('template_url') . '/js/js.js', array('jquery'),'1.0' ,false);
	  wp_enqueue_script('richemarker', get_bloginfo('template_url') . '/js/richemarker.js', array('jquery'),'1.0' ,false);
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	
	wp_head();
	?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url'); ?>/css/like-styles.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/promo.css" />
<link href='https://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
<?php if (is_page( array( '2501', '2510','2506','2514','2240' ))):?><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/profil.css" /> <?php endif;?>

</head>
<body <?php body_class();?>>

