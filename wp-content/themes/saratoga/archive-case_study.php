<?php get_header(); ?>
<div class="container case_studies">
    <div class="row top-buffer-84"></div>
    <div class='row title'>
        <div class='col-xs-12'>
            <h4>CASE STUDIES</h4>
        </div>
    </div>
    <div class="row top-buffer"></div>
    <div class='row case_study_top'>
        <div class="col-xs-2 col-offset-2 case_study_menu_active ">AMBER OAKS</div>
        <div class="col-xs-2 case_study_menu">Park Place</div>

    </div>
    <div class="row top-buffer-51"></div>
    <div class='row firstrow'>
        <div class="col-xs-3">
            <?php 

            // get_posts in same custom taxonomy
            $postlist_args = array(
                'posts_per_page'  => -1,
                'orderby'         => 'menu_order title',
                'order'           => 'ASC',
                'post_type'       => 'case_study',
                'category' => 'uncategorized'
            ); 
            $myposts = get_posts( $postlist_args );

            // get ids of posts retrieved from get_posts
            $ids = array();
            $count=0; 
            foreach ( $myposts as $post ) : setup_postdata( $post ); 
            $beforeafter->saratoga_gallery($post->ID);
            $ids[] = $post->ID;
            ?>
            <p class="title">
                <?php the_title() ?>
            </p>
              <p>
                <?php echo get_field( 'address_line1' )?>
            </p>
            <p>
                <?php echo get_field( 'address_line2' )?>
            </p>
            <button class="btn btn-lg btn-primary btn-block">VIEW MAP</button>
        </div>
        <div class='col-xs-9 col-offset-1 borderleft'>
             <?php the_content() ?>
            
            
        </div>
    </div>
    <div class='row top-buffer-57'>
        <div class="col-xs-3"></div>
        <div class='col-xs-9 col-offset-1 borderBottom'></div>
    </div>
    <div class='row'>
        <div class="col-xs-3"></div>
        <div class='col-xs-9 col-offset-1 borderleft'>
            <h4>RESULTS</h4>
              <?php echo get_field( 'results' ); ?>
            
        </div>
    </div>

    <div class='row top-buffer-57'>
        <div class='col-xs-12 borderBottom'></div>
    </div>

    <?php

 $count++;
endforeach; 
//wp_reset_postdata();

 ?>
    <div class='row top-buffer-57'>
        <div class='col-xs-12 nopadding'>
            <nav class="wp-prev-next">        
                <ul class="clearfix">     
                    <?php
                    // get and echo previous and next post in the same taxonomy        
                    $thisindex = array_search($post->ID, $ids);
                    $previd = $ids[$thisindex-1];
                    $nextid = $ids[$thisindex+1];
                    if ( !empty($previd) ) {
                    echo 'sdsd<a rel="prev" href="' . get_permalink($previd). '">previous</a>';
                    }
                    if ( !empty($nextid) ) {
                    echo 'sdsd<a rel="next" href="' . get_permalink($nextid). '">next</a>';
                    }
                    ?>                 
                </ul>   
            </nav>
        </div>
    </div>

</div>

<?php get_footer(); ?>