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

<?
//var_dump(WC_Bookings_Admin::get_booking_resources());

?>


<?php

$coursesWithTimes = array();

foreach ( WC_Bookings_Admin::get_booking_products() as $product ) {
    print_r($product->get_id() . " : " .  $product->get_name() );
    // $bookedOrNah = WC_Booking_Data_Store::get_bookings_star_and_end_times($product);
    // var_dump($bookedOrNah);

    echo "<br>";



   // This might be bad because the og class I'm calling might not be called with the right class. 

    $bookieInit = new WC_Product_Booking($product->get_id()); 
    
   //  var_dump($bookieInit->get_first_block_time());
    
    $bookie = new WC_Booking_Form($product);


      $posted = array();
		if ( ! empty( $posted['wc_bookings_field_duration'] ) ) {
			$interval = (int) $posted['wc_bookings_field_duration'] * $product->get_duration();
		} else {
			$interval = $product->get_duration();
		}
		$min_duration     = $product->get_min_duration();


      $first_block_time     = $product->get_first_block_time();
		
      $base_interval = $product->get_duration();

      $intervals        = array( $min_duration * $base_interval, $base_interval );
      $timestamp = strtotime( "{2021}-{01}-{04}" );

		$from                 = strtotime( $first_block_time ? $first_block_time : 'midnight', $timestamp );
      $standard_from        = $from;

		$resource_id_to_check = ( ! empty( $posted['wc_bookings_field_resource'] ) ? $posted['wc_bookings_field_resource'] : 0 );
      $to = strtotime( '+ 1 day', $standard_from ) + $interval;
      $to                   = strtotime( 'midnight', $to ) - 1;


      echo ("Duration of course " . $product->get_id()   .  " = "  . $interval . " hours <br>");
      echo ("First block time = " . $bookieInit->get_first_block_time());
      echo ("<br>");
      echo ("<br>");
      echo ("<br>");

      // foreach
   //    $cartItems[] = array(
   //       'id' => $cart_item_two['data']->get_id(),
   //       'quantity' => $cart_item_two['quantity'],
   //   );


}


// This for lop is going to generate the times which correlate with each course. 








?>

<form action="" method="post">
      <!-- HTML --> 
      <p>Enter Date:</p> 
      <input name="date" type = "text" id = "datepicker-13">
      <h1>&nbsp;</h1>
      <p>Enter Course:</p> 
  <select name="courseName" id="courseNameId">
  <?php foreach ( WC_Bookings_Admin::get_booking_products() as $product ) : ?>
								<option value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo esc_html( sprintf( '%s (#%s)', $product->get_name(), $product->get_id() ) ); ?></option>
		<?php endforeach; ?>
  </select>
  <h1>&nbsp;</h1>


  <input type ="submit">
  </form>


<h1>&nbsp;</h1>


	<?

// Access WordPress database

// There will be a filter here which will say Enter course which will filter the results by block per the day. 





global $wpdb;
 
if(isset($_POST["date"]) && isset($_POST["courseName"])){


  $searchDate = $_POST['date'];
  $month = substr($searchDate,0,2);
  $day = substr($searchDate,3,2);
  $year = substr($searchDate,6);
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



  $courseName = $_POST['courseName'];


?><div>You searched for <?php  ?> and we found... <?php 

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


// Trying to copy the above logic but have the variable be a series of arrays. 


$array_for_query = "SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id";



$query = $wpdb->get_results($array_for_query, ARRAY_A);


print_r($query);

$i = 1;    

// foreach($query as $row)
// {
//     // do stuff with $row here.
//     echo "yeet";
//     echo "<br>";
//     echo "<td>$i</td>";
//     $i++;

//    }


/*
$sql = "SELECT * FROM test_sort";
$get_fruit = mysqli_query( $con_wp, $sql );

while ( $row = mysqli_fetch_array( $get_fruit ) ) {
$items[$row['id']] = array('fruit' =&gt; $row['fruit'], 'color' =&gt; $row['color'], 'price' =&gt; $row['price']);
}

array_multisort( array_column( $items, 'price' ), $items );

print_r($items);
*/




//






 
// People who have purchased that course.

echo "People who have purchased the course: " . $product_id . " ";
// Print array on screen
print_r( $customer_emails );

echo "This line will print out the dates for each person when they plan on taking the course: ";

echo "<br>";

var_dump($customer_emails);



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


