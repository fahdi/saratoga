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
            $current_user = wp_get_current_user();
           // echo 'User ID: ' . $current_user->ID . '<br />';
            $cid=$current_user->ID;
            $args = array(
    'numberposts' => -1,
    'post_type' => 'investment',
    'meta_query' => array(        
        array(
            'key' => 'users',
            'value' => $cid,
            'compare' => 'LIKE'
        ),
        
    )
);
            $loop = new WP_Query( $args ); 
            $count=0;
            while ( $loop->have_posts() ) : $loop->the_post(); 
            ?>
            <!-- if first change the second class-->
            <div class='col-xs-3 col-xs-offset-1'>
            <div class="inner">
                <h2><a href="<?php the_permalink() ?>"><? the_title() ?></a>
                </h2>
            </div>
            </div>
            <?php 
            /*
            $current_user = wp_get_current_user();
            echo 'User ID: ' . $current_user->ID . '<br />';
            $usersss=get_field('users');
            echo "<pre>";
            print_r($usersss);
            echo "</pre>"; 
            */
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