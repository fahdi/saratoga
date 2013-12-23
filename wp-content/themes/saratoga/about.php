<?php
/*
Template Name: About Page
*/
?>
<?php
    get_header();
?>
<div class="container strategy">
	<?php
	while ( have_posts() ) : the_post();
	    the_content();
	endwhile;
	?>
</div>
<?php
    get_footer();
?>