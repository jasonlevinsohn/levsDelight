<?php
//Report all errors
error_reporting(E_ALL);

//Start the session stuff
//session_start();

//Login Section
//if(isset($_POST['title']) && isset($_POST['posttext']) && isset($_SESSION['SESS_FIRST_NAME'])) {
if(isset($_POST['title']) && isset($_POST['posttext'])) {
	
	//connect to the database
	require_once('connect.php');
	
	//Get Post Type
	
	if(isset($_POST['postType']) && $_POST['postType'] == 'updateMainPost') {
		
		$id	  = $_POST['id'];
		$title   = $_POST['title'];
		$message = $_POST['posttext']; 
		$author  = $_POST['author'];
		
		$currentTime = date("y/m/d : H:i:s", time());
		$qry = "UPDATE mainposts SET title = ?, posttext = ?, timestamp = ? WHERE id = ?";
		
		$stmt = $dbh->prepare($qry);
		$stmt->execute(array($title, $message, $currentTime, $id));
		
		echo '{"success": true, "message":' . json_encode('Post has been updated.') . '}';
		
	} elseif(isset($_POST['postType']) && $_POST['postType'] == 'mainPost') {
		
		
		//Lets get the high number of the sortOrder Column to add the post at the top
		$sortQuery = "select MAX(sortOrder) as highNumber from mainposts";
		$sortOrderStatement = $dbh->query($sortQuery)->fetchAll();
		
		foreach($sortOrderStatement as $sortNumber) {
			$highNumber = $sortNumber['highNumber'];
		}

		//Increment the Sort Order
		$highNumber = $highNumber + 1;

		$title   = $_POST['title'];
		$message = $_POST['posttext']; 
		$author  = $_POST['author'];
		$currentTime = date("y/m/d : H:i:s", time());
		$qry = "INSERT INTO mainposts (title, posttext, author, timestamp, sortOrder) VALUES (?, ?, ?, ?, ?)";
		$stmt = $dbh->prepare($qry);
		$stmt->execute(array($title, $message, $author, $currentTime, $highNumber));
		
		echo '{"success": true, "message":' . json_encode('Post has been added by ' . $author) . '}';
	
	} else {
		echo '{"failure": true, "message":' . json_encode('There is no post type for' . $_POST['postType']) . '}';
	}
} else {
	echo '{"failure": true, "message":' . json_encode('The fields are not set correctly.') . '}';
}
	
	

//End Login Section

?>


