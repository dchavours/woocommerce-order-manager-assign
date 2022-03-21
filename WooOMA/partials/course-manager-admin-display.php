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

// Start booking_start
global $wpdb;


// This runs a query and gets the wholestart times but it's just one big string that's in in this array 
// and also they're not unique because they're all the times. 
// so there's multiple strings repeating it within the all_booking_begins arrray below should 
// be changed anywaysbecause it's supposed to be agnostic towards booking times.
function fill_all_booking_times($arrayParam){

	foreach($arrayParam as $booking_start ){


		$all_booking_times[] = $booking_start['meta_value'];
	}

  return $all_booking_times;
}





// This function takes the large string that includes 
// the days in the months and puts it into units that can be used better.
// Also used to delineate hours.
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





// This function takes the time of strings produced by turn_into_units and decided if its am or pm. 
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

// Start booking find logic
$all_8810_sql_command = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_booking_product_id' AND meta_value = '8810' ";
$all_array_8810 = $wpdb->get_results($all_8810_sql_command, ARRAY_A);





var_dump($all_array_8810);







function solo_post_id_for_booking_8810($arrayParam2){
// Ok so the first loop is going to loop through all nodes first on the first-level.
	foreach ( $arrayParam2 as $arrayThing ) {
		
		$new_array[] = $arrayThing["post_id"];	
		
		echo $arrayThing["post_id"];
		echo '<br>';


	}
	
	return $new_array;
	
}


// I'm getting a null value because the function doesn't have a return value. 
var_dump(solo_post_id_for_booking_8810($all_array_8810));


// This function is going to take all of the post ids returned from solo_post_id_for_booking_8810 put a comma in between it and have it be the variable added to a sql statement for 
// where to search so the row can be returned and the parent can be found. 
function implode_string_array($arrayParam3){


}


















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

 
echo '508';
 print_r( wc_get_is_paid_statuses());
 var_dump(wc_get_is_paid_statuses());





$product_id = $courseName;


var_dump($courseName);
// Select Product ID

// Find billing emails in the DB order table
$statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );



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








$customer_booking_start = $wpdb->get_col("
   SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
   AND pm.meta_key IN ( '_booking_start' )
   AND im.meta_key IN ( '_product_id', '_variation_id' )
   AND im.meta_value = $product_id
");








$customer_booking_end = $wpdb->get_col("
   SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
   INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
   INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
   WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
   AND pm.meta_key IN ( '_booking_end' )
   AND im.meta_value = $product_id
");


// _payment_method_title

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

print_r( $customer_emails );
echo "<br>";
echo "Customer Phone:";
echo "<br>";


print_r( $customer_phone );

echo "<br>";
echo "customer_booking_start:";
echo "<br>";

print_r( $customer_booking_start );

echo "<br>";
echo "customer_booking_end:";
echo "<br>";
print_r( $customer_booking_end );



echo "<br>";
echo "payment_method_title:";
echo "<br>";


print_r( $payment_method_title );








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


