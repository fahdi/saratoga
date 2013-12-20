<?php
/*
Plugin Name: Before & After section for Saratoga
Plugin URI: mailto:info@fahdmurtaza.com
Description: A before and after portfolio generator for saratoga.
Version: 1.0
Author: Fahd Murtaza
Author URI: http://www.fahdmurtaza.com
*/

/*  Copyright 2013 Fahd Murtaza info@fahdmurtaza.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__,'ba_install');

$beforeafter = new BeforeAfter();

class BeforeAfter {

	function BeforeAfter() {
		// JS libs for the plugin
		add_action("admin_print_scripts", array(&$this, 'ba_js_libs') , 7);

		// Add the admin meta boxes
		add_action('admin_menu', array(&$this, 'ba_admin') , 7);

		// The function to show AJAX media library
		add_action('wp_ajax_ba_return_media_library', array(&$this, 'ba_return_media_library') , 7);

		// The function to show before and after in AJAX calls 
		add_action('wp_ajax_ba_return_beforeafter', array(&$this, 'ba_return_beforeafter') , 7);

		// 
		add_action('wp_ajax_ba_add', array(&$this, 'ba_add') , 7);
		add_action('wp_ajax_ba_remove', array(&$this, 'ba_remove'), 7);
		add_action('wp_ajax_ba_sort', array(&$this, 'ba_sort'), 7);
		
	}
	
	// Template Tags
	
	function is_gallery($id = null) {
		
		global $wpdb;
		
		//$wpdb->show_errors();
		$table_name = $wpdb->prefix . "ba";
		
		if (!isset($id)) :
			return false;
		endif;
		
		$post_id_is_gallery = $id;
		
		$images = $wpdb->get_results("SELECT * FROM $table_name WHERE post = $post_id_is_gallery ORDER BY ba_order ASC", ARRAY_A);
		
		if ($images) :
			return true;
		else :
			return false;
		endif;
		
	}
	
	function gallery($type = 'after' , $id = 0 , $file = 'thumb' , $links = true, $list = false , $rel = "beforeafter" , $limit = false) {
		
		global $post;
		global $wpdb;
				
		$table_name = $wpdb->prefix . "ba";
		
		if ($id == 0) :
			$query = "SELECT * FROM $table_name WHERE cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		else :
			$query = "SELECT * FROM $table_name WHERE post = $id AND cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		endif;
		
		$images = $wpdb->get_results($query, ARRAY_A);
		
			
			if ($images) :
			
				foreach ($images as $image) :
				
					$id = $image['id'];
					$wpid = $image['wpid'];
					$file_path = wp_get_attachment_url($wpid);
					$thumb_path = wp_get_attachment_thumb_url($wpid);
					$order = $image['ba_order'];
					?>
					
						<?php if ($list) : ?> 
							<li>
						<?php endif; ?>
					
							<?php if ($links) : ?> 
								<a href="<?php echo $file_path; ?>" rel="<?php echo $rel; ?>">
							<?php endif; ?>
						
								<img  src="<?php if ($file == 'file') : echo $file_path; else : echo $thumb_path; endif; ?>" />
						
							<?php if ($links) : ?> 
								</a>
							<?php endif; ?>
						
						<?php if ($list) : ?> 
							</li>
						<?php endif; ?>
					
					<?php
				
				endforeach;
			
			endif;
		
	}

	// New Gallery, specific to Saratoga and the bootstrap theme, not generic

	function saratoga_gallery( $id = 0) {
		
		$type = 'before';
		$file = 'file';
		$links = false;
		$list = false;
		$rel = "beforeafter";
		$limit = false;

		global $post;
		global $wpdb;
			
		$table_name = $wpdb->prefix . "ba";
		

		// Get 'after' images from database

		if ($id == 0) :
			$query = "SELECT wpid FROM $table_name WHERE cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		else :
			$query = "SELECT wpid FROM $table_name WHERE post = $id AND cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		endif;

		//echo $query;
		
		$images = $wpdb->get_results($query, ARRAY_A);
		
			
		// Get 'after' images from database

		$type = 'after';

		if ($id == 0) :
			$query = "SELECT wpid FROM $table_name WHERE cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		else :
			$query = "SELECT wpid FROM $table_name WHERE post = $id AND cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		endif;

		//echo $query;

		$images2 = $wpdb->get_results($query, ARRAY_A);
		

		// Get labels from database
		
		$type = 'label';

		if ($id == 0) :
			$query = "SELECT label FROM $table_name WHERE cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		else :
			$query = "SELECT label FROM $table_name WHERE post = $id AND cat = '$type' ORDER BY ba_order ASC";
			if ($limit) :
				$query = $query . " LIMIT " . $limit;
			endif;
		endif;

		$labels = $wpdb->get_results($query, ARRAY_A);
	if($images && $images){
		$combined = array_merge($images,$images2,$labels);
		$total=count($combined);
		$label_start= $total-$total/3;
		$times=$total-$label_start;

		for($counter=0;$counter<$times;$counter++){
		$file_path = wp_get_attachment_url($combined[$counter]['wpid']);
		?>
		 <!-- start photos loop -->
    <div class='row project-photos'>
        <div class="col-xs-3">
            <?php if($counter==0){ ?>
            <h4>Project Photos</h4>
            <?php
        	}
            ?>
        </div>
        <div class='col-xs-9 col-offset-1 borderleft'>
            <h4><?php echo $combined[$label_start]['label']; ?></h4>
            <div class="row">
                <div class="col-xs-6"><span>Before</span>
                    <br/>
                    <?php
                    $file_path = wp_get_attachment_url($combined[$counter]['wpid']);
                    ?>
                    <img src="<?php echo $file_path?>" />
                </div>
                <div class="col-xs-6"><span>After</span>
                    <br/>
                    <?php
                    $file_path = wp_get_attachment_url($combined[$counter+3]['wpid']);
                    ?>
                    <img src="<?php echo $file_path?>" />
                </div>
            </div>
        </div>
    </div>
	<?php
    if($counter<$times-1){
    	// <!-- Show if not last set -->
    ?>
    
    <div class='row top-buffer-57'>
        <div class="col-xs-3"></div>
        <div class='col-xs-9 col-offset-1 borderBottom'></div>
    </div>
    <?php
		} // <!-- Show if not last set -->
	$label_start++;

	} //  <!-- end loop -->
}
?>

	<div class='row top-buffer-57'>
        <div class='col-xs-12 borderBottom'></div>
    </div>

	<?php
	
	}
	
	// Admin
	
	function ba_post_box() {

		$this->ba_style();
		$this->ba_scripts();
		
		global $post;
		
		?>
	    <div class="ba_box">
	        
			<?php if ($post->ID == 0) : ?>
			
				<div class="ba_alert">
					To organize a Before/After gallery, please <strong>save or publish your post</strong>.
				</div>
				
			<?php else : ?>
			
				
				<div class="ba_use">
					<strong>Drag and drop</strong> items from the media library into <em>Before</em> or <em>After</em>. <strong>Double-click</strong> items to remove them. <br/>
					Add text to the 'label' field and hit the Add Label button to add labels for <em>Before</em> or <em>After</em> images. <br/>
					Add as many labels as you want. Only first ones which match the total number of <em>Before</em> or <em>After</em> Images will show up on site. 

				</div>
				
				<div class="ba_column ba_media">
		            <h5 class="ba">Media Library <a href="media-new.php">(Add New)</a></h5>
		            <ul id="ba_media">

		            </ul>
		            <div class="ba_clear"></div>
		            <div id="label_form"></div>
		        </div>

		        <div class="ba_column">
		            <h5 class="ba">Before</h5>
		            <ul id="ba_before">

		            </ul>
		        </div>

		        <div class="ba_column">
		            <h5 class="ba">After</h5>
		            <ul id="ba_after">

		            </ul>
		        </div>
		        <div class="ba_column label_column">
		            <h5 class="ba">Label</h5>
		            <ul id="ba_label">

		            </ul>
		        </div>

				
			<? endif; ?>
			
	        <div class="ba_clear"></div>
	    </div>

		<?php

	}
	
	function ba_style() {

		?>
	    <style>

			.ba_clear {
			clear:both;
			visibility:hidden;
			}
			
			.ba_box {
				width:100%;
				margin:15px;
			}
			
			.ba_box li {
				cursor:move;
			}
			#ba_label li {
				height: 75px;
				display: block;
				border: 1px #ccc dashed;
			}
			#ba_label li input{
				margin: 20px 0 20px 5px;
				padding: 5px;
			}
			.ba_use {
				color:green;
				margin-bottom:20px;
			}
			

			h5.ba {
			font-size:1em;
			font-weight:bold;
			border-bottom:#CCCCCC solid 1px;
			padding-bottom:8px;
			margin-bottom:8px;
			margin-top:0px;
			background-color:#FFFFFF;
			}

			.ba_column {
				float:left;
				width:80px;
				margin-right:15px;
			}

			.label_column {
				width: 196px;
				vertical-align: middle;
			}
			.ba_media {
			width:400px;
			}



			#ba_before, #ba_after {
			padding-bottom:75px;
			clear:both;
			}

			ul#ba_media li {
				float:left;
				width:75px;
				height:75px;
				margin-bottom:5px;
				margin-right:5px;

			}



		</style>
	    <?php 

	}

	function ba_scripts() {

		global $post;

		?>

		<script type="text/javascript">

			jQuery(document).ready(function($) {

				// If JS enabled, disable main input
				$("#ba_label").prop('disabled', true);
				
				// If JS enabled then add fields
				$("#label_form").append('<input placeholder="Add label" id="resp_input" ></input><input type="button" value="Add Label" id="add"> ');

				// Add items to input field
				var eachline='';
				$("#add").click(function(){
	      		$('#ba_label').append("<li><input name='label' type='text' value='"+$('#resp_input').val()+"'></li>");
	      		$('#ba_label').trigger("sortreceive");
			});    

				// Init
				ba_return_everything();
					
				// Jquery
				

				// After
				$("#ba_after").sortable({
					dropOnEmpty: true,
					receive: function(event, ui) {
						var wpid = $(ui.helper).attr('id');
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_add" , wpid:wpid, cat:'after', post:'<?php echo $post->ID;?>' },
							function(str) {
								ba_return_everything();
							}
						);
					} , 
					update: function(event, ui) {
						var ba_order = $(this).sortable("serialize");
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_sort", cat:'after' , post:'<?php echo $post->ID;?>' , ba_order:ba_order},
							function(str) {
								ba_return_everything();
							}
						);
					}
				});	
				
				// Before
				$("#ba_before").sortable({
					dropOnEmpty: true,
					receive: function(event, ui) {
						var wpid = $(ui.helper).attr('id');
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_add" , wpid:wpid, cat:'before', post:'<?php echo $post->ID;?>' },
							function(str) {
							   ba_return_everything();
							}
						);
						
					} ,
					update: function(event, ui) {
						var ba_order = $(this).sortable("serialize");
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_sort", cat:'before' , post:'<?php echo $post->ID;?>' , ba_order:ba_order},
							function(str) {
								ba_return_everything();
							}
						);
					}
				});	
				
				// Label

				$( "#ba_label" ).bind( "sortreceive", function(event, ui) {
					
						//alert($('#ba_label input').val());
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_add" , wpid:9999, cat:'label', post:'<?php echo $post->ID;?>',label:$('#ba_label input').val() },
							function(str) {
							   ba_return_everything();
							}
						);
				});

				$("#ba_label").sortable({
					dropOnEmpty: true,
					receive: function(event, ui) {
						// Maza karo, hum binding kar rahe hain
						
					} ,
					update: function(event, ui) {
						var ba_order = $(this).sortable("serialize");
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_sort", cat:'label' , post:'<?php echo $post->ID;?>' , ba_order:ba_order},
							function(str) {
								ba_return_everything();
							}
						);
					}
				});	
				
				$('.ba_list_item').live("dblclick", 
					function () {
						var id = $(this).attr("id");
						$.post(
							"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
							{action:"ba_remove" , id:id},
							function(str) {
							   ba_return_everything();
							}
						);
					}
				);
				
				// Methods
				function ba_return_everything() {
					$('.ba_box').fadeOut(100);
					//Media Library
					$.post(
						"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
						{action:"ba_return_media_library"},
						function(str) {
							$('#ba_media').html(str);
							$("#ba_media li").draggable({ 
								revert : 'invalid',
								refreshPositions: true,
								connectToSortable:'#ba_before, #ba_after'
							});
						}
					);
					// Before
					$.post(
						"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
						{action:"ba_return_beforeafter" , cat:"before" , post:<?php echo $post->ID; ?>},
						function(str) {
						   $('#ba_before').html(str);
						}
					);
					// After
					$.post(
						"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
						{action:"ba_return_beforeafter" , cat:"after" , post:<?php echo $post->ID; ?>},
						function(str) {
						   $('#ba_after').html(str);
						}
					);
					// Label
					$.post(
						"<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php", 
						{action:"ba_return_beforeafter" , cat:"label" , post:<?php echo $post->ID; ?>},
						function(str) {
						   $('#ba_label').html(str);
						}
					);
					//
				$('.ba_box').fadeIn(100);
					
				}

			});

		</script>

	    <?php
	}
	
	// Methods
	
	function ba_add() {

		$wpid = $_POST['wpid'];
		$wpid = trim($wpid, 'ba_wpid_');
		
		$cat = $_POST['cat'];
		$post = $_POST['post'];


		//echo $_POST[''];

		//print_r($_POST['labels']);
		$label=$_POST['label'];

		global $wpdb;
		$wpdb->show_errors();

		$table_name = $wpdb->prefix . "ba";
		
		// find the highest order thus far
		
		$items = $wpdb->get_results("SELECT ba_order FROM $table_name WHERE post = $post AND cat = '$cat'", ARRAY_A);
		
		if ($items) :
			$order_set = array();
			foreach ($items as $item) :
			  $order_set[] = $item['ba_order'];
			endforeach;
			$highest_order = max($order_set);
		else :
			$highest_order = 0;
	    endif;
	
		$highest_order++;

		$data_array = array(
						'wpid' => $wpid,
						'cat' => $cat,
						'post' => $post,
						'ba_order' => $highest_order,
						'label' => $label
						);

		$wpdb->insert($table_name, $data_array );

		exit();

	}

	function ba_remove() {

		$id = $_POST['id'];
		$id = $wpid = trim($id, 'ba_id_');

		global $wpdb;
		$wpdb->show_errors();

		$table_name = $wpdb->prefix . "ba";

		$wpdb->query("DELETE from $table_name WHERE id = $id");

		exit();

	}
	
	function ba_sort() {
		
		global $wpdb;
		$wpdb->show_errors();
		$table_name = $wpdb->prefix . "ba";
		
		$post = $_POST['post'];
		$cat  = $_POST['cat'];
		
		$ids = $_POST['ba_order'];
		$ids = explode('ba_id[]=', $ids);
		
		$ba_order = -1;
		
		foreach ($ids as $id) :

			$ba_order++;

			$pattern = "/&/";
			$id = preg_replace($pattern, '' , $id);

			$data_array = array(
				"ba_order" => $ba_order
				);
			$where = array('id' => $id);
			$wpdb->update($table_name, $data_array, $where );

		endforeach;
		
		exit();
		
	}
	
	// Models
	
	function ba_return_media_library() {
		global $wpdb;
		$wpdb->show_errors();
		$table_name = $wpdb->prefix . "ba";

		// which images are already in a before/after list?
		$used_items = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

		if ($used_items) :	

			$useds = '';

			foreach ($used_items as $used) :

				$useds = $useds . $used['wpid'] . ',';

			endforeach;

			$useds = ltrim($useds);
			$useds = substr($useds, 0, -1);

			$images = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' AND id NOT IN($useds)");

		else :

			$images = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'attachment'");

		endif;

		if ($images) :	

			foreach ($images as $image) :
				$id = $image->ID;
				$file = wp_get_attachment_thumb_url($id);

				?>
	            <li id="ba_wpid_<?php echo $id; ?>">
				<img  src="<?php echo $file ?>" width="75" height="75" />
	            </li>
				<?php

			endforeach;

		endif;

		exit();

	}

	function ba_return_beforeafter() {

		global $wpdb;
		$wpdb->show_errors();
		$table_name = $wpdb->prefix . "ba";

		$post = $_POST['post'];
		$cat = $_POST['cat'];

		$images = $wpdb->get_results("SELECT * FROM $table_name WHERE cat = '$cat' AND post = $post ORDER BY ba_order ASC", ARRAY_A);
		if($cat!='label'){
			if ($images) :

				foreach ($images as $image) :

					$id = $image['id'];
					$wpid = $image['wpid'];
					$file = wp_get_attachment_thumb_url($wpid);
					$order = $image['ba_order'];
					$label = $image['label'];

					?>
					<li id="ba_id_<?php echo $id; ?>" class="ba_list_item">
		            	<img  src="<?php echo $file ?>" width="75" height="75" />
		            </li>
					<?php

				endforeach;
			endif;
		}else {
			if ($images) :

				foreach ($images as $image) :

					$id = $image['id'];
					$wpid = $image['wpid'];
					$file = wp_get_attachment_thumb_url($wpid);
					$order = $image['ba_order'];
					$label = $image['label'];

					?>
					<li id="ba_id_<?php echo $id; ?>" class="ba_list_item">
		            	<?php
		            	echo $label;
		            	?>
		            </li>
					<?php

				endforeach;
			endif;
		}
	

		exit();

	}
	
	// Init
	
	function ba_admin() {

		add_meta_box( 'beforeafter', __( 'Before/After', 'beforeafter' ), array(&$this, 'ba_post_box'), 'post', 'advanced');
		add_meta_box( 'beforeafter', __( 'Before/After', 'beforeafter' ), array(&$this, 'ba_post_box'), 'case_study', 'advanced');

	}
	
	function ba_js_libs() {

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-selectable');

	}
	
}

// Install

function ba_install() {

	 global $wpdb;
	 $wpdb->show_errors();

	 $table_name = $wpdb->prefix . "ba";

	 if($wpdb->get_var("show tables like '$table_name'") != $table_name) :

	 	$sql = "CREATE TABLE " . $table_name . " (
	 		id int NOT NULL AUTO_INCREMENT,
	 		wpid int,
	 		post int NOT NULL,
			cat text NOT NULL,
            label text,
			ba_order int NOT NULL,
	 		PRIMARY  KEY id (id)
	 		);";

	 	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	 	dbDelta($sql);

	 endif;
}

?>