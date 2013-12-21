<?php
/**
 * @package Financial Statements
 * @version 1.0
 */
/*
Plugin Name:  Financial Statements
Plugin URI: http://www.fahdmurtaza.com/
Description: Enables you to add Financial Statements to your site.
Author: Fahd Murtaza
Version: 1.0 
Author URI: http://www.fahdmurtaza.com/
*/


// Creates Financial Statement item custom post type
add_action('init', 'post_type_financialstatament');
function post_type_financialstatament() 
{
  $labels = array(
    'name' => _x('Financial Statement', 'post type general name'),
    'singular_name' => _x('Financial Statement', 'post type singular name'),
    'add_new' => _x('Add New', 'financialstatament'),
    'add_new_item' => __('Add New Financial Statement')
 
  );
 
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor')); 
 
  register_post_type('financialstatament',$args);
 
}

// list_financialstataments function which lists all the financialstataments posts in the wordpress
function list_financialstataments(){
?>
<ul class="link_list medium">
<?php
//start the loop

//wp_get_archives ('type=yearly');
custom_recent_posts('group=1&limit=100'); 




?>  </ul>
<?php
} // end function list_financialstataments
add_theme_support('post-thumbnails');



/*add_filter( 'getarchives_where' , 'ucc_getarchives_where_filter' , 10 , 2 );
function ucc_getarchives_where_filter( $where , $r ) {
echo str_replace( "post_type = 'post'" , "post_type = 'financialstatament'" , $where );
return str_replace( "post_type = 'post'" , "post_type = 'financialstatament'" , $where );
}
*/

/**
 Most important configuration variable is $group:
 0      -       Just put the date at the left side.
 1      -       Group by year, month, and day.
*/

function custom_recent_posts($args = '') {
    global $wp_locale, $wpdb;
	$url ='#';
    // params fun
    parse_str($args, $r);
    $defaults = array('group' => '1', 'limit' => '10', 'before' => '<li>', 'after' => '</li>', 'show_post_count' => false, 'show_post_date' => true, 'date' => 'F jS, Y', 'order_by' => 'post_date DESC');
    $r = array_merge($defaults, $r);
    extract($r);
    
    // output 
    $output    = '';
    $pre       = '';
    $full_date = '';
    $year      = '';
    $month     = '';
    $day       = '';
    
    // the query
    $where = apply_filters('getarchives_where', "WHERE post_type = 'financialstatament' AND post_status = 'publish'");
    $join  = apply_filters('getarchives_join', "");
    $qry   = "SELECT ID, post_date, post_title, post_name 
              FROM $wpdb->posts $join 
              $where ORDER BY $order_by LIMIT $limit";
    $arcresults = $wpdb->get_results($qry);
	$attachment_url='#';	
	$attachment_id=-1;	
    if ($arcresults) {
        foreach ($arcresults as $arcresult) {
			
			
		
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => 100,
			'post_status' => null,
			'post_parent' => $arcresult->ID
		);
		$attachments = get_posts($args);
      
		   foreach ($attachments as $attachment) {
			   if(strpos($attachment->guid, ".pdf")){
						$attachment_url=$attachment->guid;	
						$attachment_id=$attachment->ID;	
						
			   }			   
			}
		
        

			
			
            if ($arcresult->post_date != '0000-00-00 00:00:00') {
//                $url  = get_permalink($arcresult);
	              $url  = $attachment_url;

                if ($group == 0) { // dates at the side of the post link
                    $arc_date = date($date, strtotime($arcresult->post_date));
                    $full_date = '<em class="date">' . $arc_date . '</em> ';
                }
                if ($group == 1) { // grouping by year then month-day
                    $y = date('Y', strtotime($arcresult->post_date));
                    if ($year != $y)  {
                        $year = $y;
                        $pre = '<h3>' . $year . '</h3>';
                    }
                    $m = date('F Y', strtotime($arcresult->post_date));
                    if ($month != $m) {
                        $month = $m;
                  //      $pre .= '<li class="month">' . substr($month, 0, -4) . '</li>';
                    } 
                    $d = date('jS', strtotime($arcresult->post_date));
                    if ($day != $d) {
                        $day = $d;
                    //    $full_date = '<em>' . $day . '</em>';
                    }
                }
                $text = strip_tags(apply_filters('the_title', $arcresult->post_title));
                $output .= get_archives_link($url, $text, $format, 
                                              $pre . $before . $full_date, 
                                             $after);
                $pre = ''; $full_date = '';
            }
        }
    }
    echo $output;
}
?>