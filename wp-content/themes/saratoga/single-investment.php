<?php get_header(); ?>
<div class="container strategy">
    <div class="row top-buffer-84"></div>
    <div class='row title'>
        <div class='col-xs-12'>
            <h4>All Investments</h4>
        </div>
    </div>
    <div class="row top-buffer"></div>
    
    <div class="row top-buffer-51"></div>
    <div class='row firstrow'>
        <div class="col-xs-3">
            <?php 
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; // setup pagination

            $loop = new WP_Query( array( 
                'post_type' => 'investment',
                'paged' => 1,
                'posts_per_page' => 1) 
            );
            
            $count=0; 
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
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
    $beforeafter->saratoga_gallery($post->ID);
    $postid= $post->ID;
   ?>
    <div class='row top-buffer-57'>
        <div class='col-xs-12 nopadding'>
            <nav class="wp-prev-next">    
                <?php
                $count++; endwhile; 
                wp_reset_postdata();
                wp_reset_query();

// get_posts in same custom taxonomy
$postlist_args = array(
   'posts_per_page'  => -1,
   'orderby'         => 'menu_order title',
   'order'           => 'ASC',
   'post_type'       => 'case_study'
); 
$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
$ids = array();
foreach ($postlist as $thepost) {
   $ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
$thisindex = array_search($post->ID, $ids);
$total_ids=count($ids)-1;
/*
echo "<pre>".$thisindex." ".$total_ids."<br/>";
    print_r($ids);
echo "</pre>";
*/
if($thisindex>0){
    $previd = $ids[$thisindex-1];
}
if($total_ids!=$thisindex){
    $nextid = $ids[$thisindex+1];
}

if ( !empty($previd) ) {
   echo '<a rel="prev" href="' . get_permalink($previd). '">PREVIOUS CASE STUDY</a>';
}
if ( !empty($nextid) ) {
   echo '<a rel="next" href="' . get_permalink($nextid). '">NEXT CASE STUDY</a>';
}
                ?>  
            </nav>
        </div>
    </div>

</div>

<?php get_footer(); ?>