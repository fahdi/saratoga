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
            <?php $loop=new WP_Query( array( 'post_type'=>'case_study', 'posts_per_page' => 1 ) ); 
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
    $count++; endwhile; ?>
    <div class='row top-buffer-57'>
        <div class='col-xs-12 nopadding'>
            <a href="#">NEXT CASE STUDY</a>
        </div>
    </div>

</div>

<?php get_footer(); ?>