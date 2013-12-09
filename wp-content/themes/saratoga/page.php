<?php
    get_header();
?>
    <div class="container home">
        <h2>Welcome, you can login securely below.</h2>

        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
      </div>
<?php
    get_footer();
?>
