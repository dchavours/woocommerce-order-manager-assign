<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wp2mag.blogspot.com
 * @since      1.0.0
 *
 * @package    Course_Manager
 * @subpackage Course_Manager/admin/partials
 */



$dir = WP_PLUGIN_DIR . '/woocommerce-order-manager-assign';


$serialize_output_file = $dir . '/local-machine-path.json';

if ( file_exists($serialize_output_file)) {
	echo "It exists";
} else {
	fopen($dir . '/local-machine-path.json', "w");
}


 
?>




<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1>&nbsp;</h1>


<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- Javascript -->
<script>
   $(function() {
      $( "#datepicker-13" ).datepicker();
      $( "#datepicker-13" ).datepicker("show");
   });
</script>

<?php

global $wpdb;

// Start booking_start logic.
/**
 * fill_all_booking_times - This runs a query and gets the wholestart times but it's just one big string that's in in this array 
 * 			    and also they're not unique because they're all the times. 
 * 			    so there's multiple strings repeating it within the all_booking_begins arrray below should 
 * 			    be changed anywaysbecause it's supposed to be agnostic towards booking times.
 * 
 * @param mixed $arrayParam 
 * @access public
 * @return void
 */
function fill_all_booking_times($arrayParam){

	foreach($arrayParam as $booking_start ){


		$all_booking_times[] = $booking_start['meta_value'];
	}

  return $all_booking_times;
}




/**
 * turn_into_units - This function takes the large string that includes 
 * 		     the days in the months and puts it into units that can be used better.
 * 		     Also used to delineate hours.
 * 		     Some of the code below is commented out because the only focus atm 
 * 		     is the hour value.
 * @param mixed $unicode_full_time_string 
 * @access public
 * @return void
 */
function turn_into_units($unicode_full_time_string){

	foreach ($unicode_full_time_string as $array_unique_time_unit){
   
#  		 $all_booking_time_units[] = array(  

#   	   	 'whole_time' => $array_unique_time_unit,
#   	    	 'year' => substr($array_unique_time_unit,0, 4),
#   	   	 'month' => substr($array_unique_time_unit,4,2),
#   	  	 'day' => substr($array_unique_time_unit,6,2),
#   	    	 'hour' => substr($array_unique_time_unit,8,2),
#   	    	 'minute' => substr($array_unique_time_unit,12,2)
#    		);
   	$hourInt = (int)substr($array_unique_time_unit,8,2);


   	$all_booking_hours_begin_or_end[] = $hourInt;

	} 
	return $all_booking_hours_begin_or_end;
}





/**
 * match_pm_or_am - This function takes the time of strings produced by turn_into_units and decided if its am or pm. 
 * 
 * @param mixed $hour_unit_array 
 * @access public
 * @return void
 */
function match_pm_or_am($hour_unit_array){

	sort($hour_unit_array);

	foreach($hour_unit_array as $booking_int_time){

		if($booking_int_time < 12){

        	 $formatted_times_hours[] = $booking_int_time . ":00am"; 
		}

		if($booking_int_time == 12){
			
		$formatted_times_hours[] = $booking_int_time . ":00pm"; 
		}

		if($booking_int_time > 12){

		$formatted_times_hours[] = $booking_int_time - 12 . ":00pm"; 
      		}
      		
	}

	

   // This is going to return an array. 
   return $formatted_times_hours;

}

// Start booking start variables.
$all_booking_starts_sql_command = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_booking_start'";
$all_booking_starts_row = $wpdb->get_results($all_booking_starts_sql_command, ARRAY_A);
$array_unique_time_starts = array_unique(fill_all_booking_times($all_booking_starts_row));
$array_unique_time_starts_no_repeats = array_unique(turn_into_units($array_unique_time_starts));


// Start booking end variables. 
$all_booking_ends_sql_command = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_booking_end'";
$all_booking_ends_row = $wpdb->get_results($all_booking_ends_sql_command, ARRAY_A);
$array_unique_time_ends = array_unique(fill_all_booking_times($all_booking_ends_row));
$array_unique_time_ends_no_repeats = array_unique(turn_into_units($array_unique_time_ends));



?>

<form action="" method="post">
      <!-- HTML --> 
      <p>Enter Date:</p> 
      <input name="date" type = "text" id = "datepicker-13">
      <h1>&nbsp;</h1>
      <p>Enter Course:</p> 
  <select name="course_name" id="courseNameId">
  <?php foreach ( WC_Bookings_Admin::get_booking_products() as $product ) : ?>

	<option value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo esc_html( sprintf( '%s (#%s)', $product->get_name(), $product->get_id() ) ); ?></option>
 
  <?php endforeach; ?>
  </select>
  <h1>&nbsp;</h1>



 <p>Enter Begining Hours:</p> 
  

  <select name="courseName" id="courseNameId">
  <?php foreach (match_pm_or_am($array_unique_time_starts_no_repeats) as $hour_end ) : ?>

	<option value="<?php echo $hour_end; ?>"><?php echo $hour_end; ?></option>

  <?php endforeach; ?>
  </select>


  <p>Enter Ending Hours:</p> 

  <select name="courseName" id="courseNameId">
  <?php foreach (match_pm_or_am($array_unique_time_ends_no_repeats ) as $hour_end ) : ?>

	<option value="<?php echo $hour_end; ?>"><?php echo $hour_end; ?></option>
 
  <?php endforeach; ?>
  </select>

  <h1>&nbsp;</h1>
  
  <input type ="submit">
</form>


<h1>&nbsp;</h1>


<?




global $wpdb;
 
if(isset($_POST["date"]) && isset($_POST["course_name"])){ 


  $array_unique_time_unit = $_POST['date'];
  $month = substr($array_unique_time_unit,0,2);
  $day = substr($array_unique_time_unit,3,2);
  $year = substr($array_unique_time_unit,6);
  echo $month.$day.$year;
  $day_start    = strtotime( 'midnight', strtotime( $day ) );
  $day_end      = strtotime( 'midnight +1 day', strtotime( $day ) ) - 1;

  $findDateBooking = new  WC_Bookings_Calendar();

  $product_filter  = isset( $_REQUEST['filter_bookings_product'] ) ? absint( $_REQUEST['filter_bookings_product'] ) : '';
  
  $booking_filter = array();
  if ( $product_filter ) {
     array_push( $booking_filter, $product_filter );
  }
//   $events = array();



  $courseName = $_POST['course_name'];


?><div>You searched for <?php  ?> and we found... <?php 

 
//echo '508';
// print_r( wc_get_is_paid_statuses());
// var_dump(wc_get_is_paid_statuses());





$product_id = $courseName;


// var_dump($courseName);
// Select Product ID

// Find billing emails in the DB order table
$statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );


echo "<h2>" . $product_id .  "</h2> ";



$customer_emails = $wpdb->get_col("
   SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
   AND pm.meta_key IN ( '_billing_email' )
   AND im.meta_key IN ( '_product_id', '_variation_id' )
   AND im.meta_value = $product_id
");


$customer_emails = $wpdb->get_col("
   SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
   AND pm.meta_key IN ( '_billing_email' )
   AND im.meta_key IN ( '_product_id', '_variation_id' )
   AND im.meta_value = $product_id
");



$customer_phone = $wpdb->get_col("
   SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
   AND pm.meta_key IN ( '_billing_phone' )
   AND im.meta_key IN ( '_product_id', '_variation_id' )
   AND im.meta_value = $product_id
");

$payment_method_title = $wpdb->get_col("
   SELECT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   AND pm.meta_key IN ( '_payment_method_title' )
   AND im.meta_key IN ( '_product_id', '_variation_id' )
   AND im.meta_value = $product_id
");







echo "People who have purchased the course: " . $product_id . " ";
// Print array on screen
echo "<br>";
echo "Customer Emails:";
echo "<br>";

//print_r( $customer_emails );
echo "<br>";
echo "Customer Phone:";
echo "<br>";


//print_r( $customer_phone );

echo "<br>";
echo "customer_booking_start:";
echo "<br>";

//print_r( $customer_booking_start );

echo "<br>";
echo "customer_booking_end:";
echo "<br>";
//print_r( $customer_booking_end );



echo "<br>";
echo "payment_method_title:";
echo "<br>";


//print_r( $payment_method_title );







// Start booking find logic!
// This going into wp_postmeta and looks through the column of meta_key for the value of every booking customer who booked 8810.
$booking_product_id_sql_cmd = "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_booking_product_id' AND meta_value = $product_id ";


/**
 * The variable $array_booking_product_id_sql_cmd takes the sql queued results and turns it into an array. 
 */
$array_booking_product_id_sql_cmd =$wpdb->get_results( $booking_product_id_sql_cmd, ARRAY_A);
//var_dump($array_booking_product_id_sql_cmd);


/**
 * reduce_sql_array_by_one_dimension - This function reduces the sql command it takes by one dimension because the sql is queued with one exta dimension we don't need. 
 * 
 * @param mixed $arrayParam2 This takes in an Array from $wpdb->get_results.         
 * @access public
 * @return void
 */
function reduce_sql_array_by_one_dimension($arrayParam){
	foreach ( $arrayParam as $arrayThing ) {
		$new_array[] = $arrayThing["post_id"];
	}
	return $new_array;
}
//var_dump(reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd));










/**
 * This takes all the ids who bought $product_id reduces it to a string for a subsequent sql statement query
 * This variable is used to search through wp_posts table.  
 */
$ids = implode(', ',  reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd));
var_dump($ids);


/**
 * This sql query finds the parent_post for the booking, in the table wp_posts
 *
 *
 *
 */

$sql_parent_array = 'SELECT post_parent, post_date,post_status, post_name, post_type FROM wp_posts WHERE ID IN ('.$ids.')';
$parent_post_array_return = $wpdb->get_results($sql_parent_array, ARRAY_A);
//var_dump($parent_post_array_return);



/**
 * This variable finds the post_purchase_id for all wcb entries. 
 */
$sql_find_child_booking ='
SELECT meta_key, meta_value, post_id  FROM wp_postmeta WHERE post_id IN ('.$ids.')
AND meta_key NOT IN
( "_edit_lock", "rs_page_bg_color", "_wc_bookings_gcalendar_event_id", "_booking_resource_id", "_booking_customer_id", "_booking_parent_id","_booking_all_day","_booking_cost","_booking_order_item_id","_booking_persons","_booking_product_id","_local_timezone","_edit_last")
';
$sql_find_child_wcb_array = $wpdb->get_results($sql_find_child_booking,  ARRAY_A);


var_dump($sql_find_child_wcb_array);


// This is going to take in 2 arrays as well as $product_id
/**
 * array_level_output - This function outputs all the booking_starts and booking_ends of $product_id inputted into the search form.  
 * 
 * @param mixed $wcb_meta_data_info 
 * @access public
 * @return void
 */
function array_level_output($sql_find_child_wcb_array){
	for ($i = 0; $i < count($sql_find_child_wcb_array); $i++) {
	  echo  $sql_find_child_wcb_array[$i]["meta_key"] . ": "  .   $sql_find_child_wcb_array[$i]["meta_value"] .  " 511 <br><br>" ;

	}
}
array_level_output($sql_find_child_wcb_array);




/**
 * split_array_into_twos - Takes the $sql_find_child_wcb_array and returns an array for 
 * the booking_start and booking_end values. This will hopefully be added on later to the
 * array of pair_parent_with_child(reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd), $parent_post_array_return, $product_id ));

 * 
 * @param mixed $sql_find_child_wcb_array 
 * @access public
 * @return void
 */
function split_array_into_twos ($sql_find_child_wcb_array){
	$split_two_array = array();

	$group_size = 2;
	$count =  count($sql_find_child_wcb_array); 
	$number_increment = $count / 2;
	for ($i = 0; $i < $number_increment;) {
		$group = array_slice($sql_find_child_wcb_array,$i,2);
		$split_two_array[] = $group;
		$i = $i +2;
	}
	return $split_two_array;
}


var_dump(split_array_into_twos($sql_find_child_wcb_array));



/**
 * pair_parent_with_child - This function correlates the wcb purcahse id with the wc purchase id. As well as filtering out entries that have a wcb but not a wc. 
 * - This needs to return an array with relevant information.  
 * @param mixed $array_wp_postmeta_child 
 * @param mixed $array_wp_posts_2 
 * @param mixed $product_id 
 * @access public
 * @return void
 */
function pair_parent_with_child($array_wp_postmeta_child, $parent_post_array_return, $product_id){
	
	$wc_purchase_ids = array();

	for ($i = 0; $i < count($parent_post_array_return); $i++) {
		if( $parent_post_array_return[$i]["post_parent"] == 0 ){
			echo $array_wp_postmeta_child[$i] . " did not buy " . $product_id . "<br><br>"; 
		}
		else{	

		
		
	        	 $wc_purchase_ids[] =  $wc_pairings =array( "wc" =>  $parent_post_array_return[$i]["post_parent"], "wcb" => $array_wp_postmeta_child[$i] );
	
			//$valid_wc_and_wcb_id = ($array_wp_postmeta_child[$i] => "Some value.");
			//echo $array_wp_postmeta_child[$i] . "-wcb & " . $parent_post_array_return[$i]["post_parent"]. "-wc,  he or she bought " , $product_id . " and paid with " . "<br><br>";
		}
	}
	return $wc_purchase_ids;
}


var_dump(pair_parent_with_child(reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd), $parent_post_array_return, $product_id ));


$to_assign_assoc_array = pair_parent_with_child(reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd), $parent_post_array_return, $product_id );






/**
 * This is the part where I work on writing data to a file. 
 * To develop scripts elsewhere.
 *
 * */



$bt8836 = array("booking-start" => "20220110180000", "booking-end" => "20220110190000"   );



$json = json_encode($bt8836); 


file_put_contents("target-array-struct.json", $json);


// This works only once the the file is not in the folder. Basically, cannot update but only start // a new.
function create_json_file ( $array_param_one){
	$dir = WP_PLUGIN_DIR . '/woocommerce-order-manager-assign';
	$target_file = $dir . '/array-struct.json';


	// encode array to json
	$json = json_encode($array_param_one);
	//display it
	//generate json file
	if (!file_exists($target_file)){

			fopen($target_file, "w");

		file_put_contents($target_file, $json);
	}
}

create_json_file(pair_parent_with_child(reduce_sql_array_by_one_dimension($array_booking_product_id_sql_cmd), $parent_post_array_return, $product_id ));











// stop doing stuff
die();

$result = $conn->query($sql);

if ($result->num_rows > 0){
while($row = $result->fetch_assoc() ){
	echo $row["name"]."  ".$row["age"]."  ".$row["gender"]."<br>";
}
} else {
	echo "0 records";
}

$conn->close();

}


