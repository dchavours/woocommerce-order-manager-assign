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
global $wpdb;
 
if(isset($_POST["date"]) && isset($_POST["courseName"])){

  $searchDate = $_POST['date'];
  $courseName = $_POST['courseName'];


?><div>You searched for <?php  ?> and we found... <?php 

$product_id = $courseName;

var_dump($searchDate);
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
 
// Print array on screen
print_r( $customer_emails );




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



