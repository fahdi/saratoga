<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Saratoga Capiotal Partners">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>favicon.svg">

    <title>Saratoga | Home</title>
          <script type="text/javascript">
    (function() {
    var config = {
      kitId: 'dia1ceb',
      scriptTimeout: 3000
    };
    var h=document.getElementsByTagName("html")[0];h.className+=" wf-loading";var t=setTimeout(function(){h.className=h.className.replace(/(\s|^)wf-loading(\s|$)/g," ");h.className+=" wf-inactive"},config.scriptTimeout);var tk=document.createElement("script"),d=false;tk.src='//use.typekit.net/'+config.kitId+'.js';tk.type="text/javascript";tk.async="true";tk.onload=tk.onreadystatechange=function(){var a=this.readyState;if(d||a&&a!="complete"&&a!="loaded")return;d=true;clearTimeout(t);try{Typekit.load(config)}catch(b){}};var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(tk,s)
    })();
    </script>      
    <!-- Bootstrap core CSS -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
<?php
if(!is_user_logged_in()){
?>
    <header class="container">
    <div class="logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saratoga-logo-white.svg"></div>
    </header>
<?php
}else{
?>

    <header class="jumbotron white">
        <div class="container">
            <div class="logo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saratoga-logo-navy.svg">
            </div>
            <div class="menu">
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="/about/" class="disabled">ABOUT</a>
                    </li>
                     <li >
                        <a href="/process/" >PROCESS</a>
                    </li>
                    <li>
                        <a href="/case-studies/">CASE STUDIES</a>
                    </li>
                    <li>
                        <a href="/portfolio/">PORTFOLIO</a>
                    </li>
                      <li class="highlighted">
                    <?php
                        ob_start();
                        wp_loginout('index.php');
                        $loginoutlink = ob_get_contents();
                        ob_end_clean();
                        $items = '<li>'. $loginoutlink .'</li>';
                       // echo $items

                    if ( is_user_logged_in() ) {
                        echo '<a href="'.wp_logout_url( get_permalink() ).'" title="LOGOUT" class="hunderline">LOGOUT</a>';
                    } else {
                        echo '<a href="'.wp_login_url( get_permalink() ).'" title="LOGIN" class="hunderline">LOGIN</a>';
                    }
                    ?>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <?php
}
?>