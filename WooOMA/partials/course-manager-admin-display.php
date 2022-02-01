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



<form action="/action_page.php">
  <label for="cars">Enter Time:</label>
  <select name="cars" id="cars">
    <option value="volvo">11:00 am</option>
    <option value="saab">Saab</option>
    <option value="opel">Opel</option>
    <option value="audi">Audi</option>
    <?php foreach ( WC_Bookings_Admin::get_booking_products() as $product ) : ?>
								<option value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo esc_html( sprintf( '%s (#%s)', $product->get_name(), $product->get_id() ) ); ?></option>
		<?php endforeach; ?>


  </select>
  <br><br>
</form>


	
	Then after that it will show a table of all the people and if they paid or not and make it so people haven't
	paid are at the top of the list then after that, people who haven't paid for textbooks are below them. 
	
	<?

