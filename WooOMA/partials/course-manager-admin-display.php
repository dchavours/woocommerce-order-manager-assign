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
<title>jQuery UI Datepicker functionality</title>

<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- Javascript -->
<script>
   $(function() {
      $( "#datepicker-13" ).datepicker();
      $( "#datepicker-13" ).datepicker("show");
   });
</script>
      <!-- HTML --> 
      <p>Enter Date: <input type = "text" id = "datepicker-13"></p>
	
	Then once they select the Date, then the next input comes up.

	<h1>&nbsp;</h1>
		


<form action="/action_page.php">
  <label for="cars">Enter Course Name:</label>
  <select name="cars" id="cars">
  <?php foreach ( WC_Bookings_Admin::get_booking_products() as $product ) : ?>
								<option value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo esc_html( sprintf( '%s (#%s)', $product->get_name(), $product->get_id() ) ); ?></option>
		<?php endforeach; ?>
  </select>
  <br><br>
</form>

<?php  echo "product id: " . 8466; ?>


<!-- <form action="/action_page.php">
  <label for="cars">Enter Time:</label>
  <select name="cars" id="cars">
    <option value="volvo">11:00 am</option>
    <option value="saab">Saab</option>
    <option value="opel">Opel</option>
    <option value="audi">Audi</option>
  </select>
  <br><br>
</form> -->


<button>Generate Class Overview</button>

<h1>&nbsp;</h1>

	
	Then after that it will show a table of all the people and if they paid or not and make it so people haven't
	paid are at the top of the list then after that, people who haven't paid for textbooks are below them. 
	
	<?

// Access WordPress database
global $wpdb;
 
// Select Product ID
$product_id = 8466;
       
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


?>

<form action="" method="post">
Search <input type="text" name="searchVar"><br>
<input type ="submit">
  </form>
  <?php



if(isset($_POST["searchVar"])){

  $search = $_POST['searchVar'];

// get the search query
$search_text = ($_POST["search_text"]);

// clean it up
$search_text = sanitize_text_field( $search_text);


$result = $wpdb->get_row( "SELECT * FROM `wp_ppsimple` ORDER BY `name` LIMIT 50 " );

?><div>You searched for <?php  ?> and we found... <?php 

echo 504;
echo $search;


?></div><?php

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



