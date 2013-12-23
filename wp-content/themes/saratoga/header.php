<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Saratoga Capiotal Partners">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>favicon.svg">

    <title>
        <?php wp_title( '|', true, 'right' ); ?>
        <?php bloginfo( 'name'); ?></title>
    <script type="text/javascript" src="//use.typekit.net/dia1ceb.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>
<?php if(is_page( 'our-portfolio')){ $class_text='class="portfoliobody"' ; } else{ $class_text='' ; } ?>

<body <?php echo $class_text; ?>>
    <?php if(!is_user_logged_in()){ ?>
    <header class="container">
        <div class="logo">
            <a href="<?php bloginfo('url');?>">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saratoga-logo-white.svg">
            </a>
        </div>
    </header>
    <?php }else{ ?>

    <header class="jumbotron white">
        <div class="container">
            <div class="logo">
                <a href="<?php bloginfo('url');?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saratoga-logo-navy.svg">
                </a>
            </div>
            <div class="menu">
                <ul class="nav nav-pills">
                <?php
                $user = wp_get_current_user();
                if( isset( $user->roles ) && is_array( $user->roles ) ) {
                    //check for admins
                    if( in_array( "administrator", $user->roles ) ) {
                        // redirect them to the default place
                        //echo "admin";
                        ?>
                        
                        <li <?php if(is_page('investments') or is_singular('investment')){?>class="active" <?php
                        }
                        ?>>
                            <a <?php if(is_page('investments') or  is_singular('investment')){?>class="active" <?php
                        }
                        ?> href="/investments/">INVESTMENTS</a>
                        </li>

                        <li <?php if(is_page('about')){?>class="active" <?php }?>>
                            <a href="/about/" <?php if(is_page('about')){?>class="active" <?php }?>>ABOUT</a>
                        </li>
                        <li <?php if(is_page('process')){?>class="active" <?php }?>>
                            <a href="/process/" <?php if(is_page('process')){?>class="active" <?php }?>>PROCESS</a>
                        </li>
                         <li <?php if(is_singular('case_study')){?>class="active" <?php }?>>
                            <a href="/case_study/amber-oaks/" <?php if(is_singular('case_study')){?>class="active" <?php }?>>CASE STUDIES</a>
                        </li>
                        <li  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>
                            <a href="/our-portfolio/"  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>PORTFOLIO</a>
                        </li>
                        <li class="highlighted">
                        <?php 
                            if ( is_user_logged_in() ) { echo '<a href="'.wp_logout_url( get_permalink() ). '" title="LOGOUT" class="hunderline">LOG OUT</a>'; } else { echo '<a href="'.wp_login_url( get_permalink() ). '" title="LOGIN" class="hunderline">LOGIN</a>'; } ?>
                        </li>
                        <?php
                        } elseif( in_array( "subscriber", $user->roles ) ) {
                        //echo "sub";
                        ?>
                        <li <?php if(is_page('about')){?>class="active" <?php }?>>
                            <a href="/about/" <?php if(is_page('about')){?>class="active" <?php }?>>ABOUT</a>
                        </li>
                        <li <?php if(is_page('process')){?>class="active" <?php }?>>
                            <a href="/process/" <?php if(is_page('process')){?>class="active" <?php }?>>PROCESS</a>
                        </li>
                        <li <?php if(is_singular('case_study')){?>class="active" <?php }?>>
                            <a href="/case_study/amber-oaks/" <?php if(is_singular('case_study')){?>class="active" <?php }?>>CASE STUDIES</a>
                        </li>is_singular
                        <li  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>
                            <a href="/our-portfolio/"  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>PORTFOLIO</a>
                        </li>
                        <li class="highlighted">
                        <?php 
                            if ( is_user_logged_in() ) { echo '<a href="'.wp_logout_url( get_permalink() ). '" title="LOGOUT" class="hunderline">LOG OUT</a>'; } else { echo '<a href="'.wp_login_url( get_permalink() ). '" title="LOGIN" class="hunderline">LOGIN</a>'; } ?>
                        </li>
                        <?php
                        }elseif( in_array( "investor", $user->roles ) ) {
                            ?>
                            
                        <li <?php if(is_page('investments')){?>class="active" <?php
                        }
                        ?>>
                            <a <?php if(is_page('investments')){?>class="active" <?php
                        }
                        ?> href="/investments/">INVESTMENTS</a>
                        </li>

                        <li <?php if(is_page('about')){?>class="active" <?php }?>>
                            <a href="/about/" <?php if(is_page('about')){?>class="active" <?php }?>>ABOUT</a>
                        </li>
                        <li <?php if(is_page('process')){?>class="active" <?php }?>>
                            <a href="/process/" <?php if(is_page('process')){?>class="active" <?php }?>>PROCESS</a>
                        </li>
                         <li <?php if(is_singular('case_study')){?>class="active" <?php }?>>
                            <a href="/case_study/amber-oaks/" <?php if(is_singular('case_study')){?>class="active" <?php }?>>CASE STUDIES</a>
                        </li>
                        <li  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>
                            <a href="/our-portfolio/"  <?php if(is_page('our-portfolio')){?>class="active" <?php }?>>PORTFOLIO</a>
                        </li>
                        <li class="highlighted">
                        <?php 
                            if ( is_user_logged_in() ) { echo '<a href="'.wp_logout_url( get_permalink() ). '" title="LOGOUT" class="hunderline">LOG OUT</a>'; } else { echo '<a href="'.wp_login_url( get_permalink() ). '" title="LOGIN" class="hunderline">LOGIN</a>'; } ?>
                        </li>
                            <?php
                        }
                    }else {

                            //  echo "No users role";
                            // Used for debugging only
                    }
            ?>
                </ul>
            </div>
        </div>
    </header>
    <?php } ?>