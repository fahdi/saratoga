<?php
/*
Template Name: Investments Page
*/
?>
<?php
    get_header();
?>
    <div class="container investments">

        <div class='row firstrow'>
            <div class='col-xs-12'>
                <h2>INVESTMENTS</h2>
            </div>
        </div>
    <div class='row '>
            <?php
            $loop = new WP_Query( array( 'post_type' => 'investment', 'posts_per_page' => 100 ) ); 
            $count=0;
            while ( $loop->have_posts() ) : $loop->the_post(); 
            ?>
            <!-- if first change the second class-->
            <div class='col-xs-3 col-xs-offset-1'>
            <div class="inner">
                <h2><a href="<?php the_permalink() ?>"><? the_title() ?></a></h2>
                
            </div>
            </div>
            <?php 
            $count++;
            if($count%3==0){
            ?>
            </div>
            <?php
            if($count<$loop->found_posts){
            ?>
             <div class='row portfolio'>
            <?php
            }
            }
            endwhile; ?>
            <!-- Do the loop for the div above and add the following close div once the number reaches 3 or multiples of three -->
        

    </div>
    </div>

<?php
    get_footer();
?>