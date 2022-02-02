<?php

// I think that this plays on the name searchVar 
$search = $_POST['searchVar'];

global $wpdb;


// get the search query
$search_text = ($_POST["search_text"]);

// clean it up
$search_text = sanitize_text_field( $search_text);


$result = $wpdb->get_row( "SELECT * FROM `wp_ppsimple` ORDER BY `name` LIMIT 50 " );

?><div>You searched for <?php echo $search_text; ?> and we found... <?php 

foreach ($result as $row) {
echo $row->t; 
}

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