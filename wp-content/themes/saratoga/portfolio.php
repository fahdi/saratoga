<?php
/*
Template Name: Portfolio Page
*/
?>
<?php
    get_header();
?>
    <div class="container portfolio">
        <div class='row firstrow'>
            <div class='col-xs-12'>
                <h2>PORTFOLIO</h2>
            </div>
        </div>
        <div class='row portfolio'>
            <?php $loop = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => 100 ) ); ?>
<?php 
$count=0;
while ( $loop->have_posts() ) : $loop->the_post(); 
            ?>
            <div class='col-xs-4'>
                <h2><?php the_title() ?></h2>
                <p><?php echo get_field( 'address_line1' )?>
                    <br/><?php echo get_field( 'address_line2' )?></p>
                <p><a href="<?php echo get_field( 'link_url' )?>"><?php echo get_field( 'link_text' )?></a></p>

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