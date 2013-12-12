<?php
    get_header();
?>
    <div class="container home">
       

        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
      


 <h2>Please fill out the form below and we will be in touch shortly.</h2>
        <form class="form-signin">

        <input type="text" class="form-control" placeholder="YOUR NAME" required autofocus>
        <input type="email" class="form-control" placeholder="YOUR EMAIL" required>

        <button class="btn btn-lg btn-primary btn-block login-new" type="submit">REQUEST A LOGIN</button>
      </form>
      </div>
<?php
    get_footer();
?>
