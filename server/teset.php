<?php
//Report all errors
try {

	//Include connection 
	//include('../connect.php');

	//$maxId = 5000;
	//$path = "july2012";
	//$desc = "";
	echo '{"success": true, "fileString": " we made it "}';

	
	//if(isset($_POST['month'])) {

		//*********Get the highest id to use as the image name**************
		//$getMaxIdQuery = "SELECT MAX(id) as maxId FROM slideshows";
		//$getMaxIdStatement = $dbh->query($getMaxIdQuery);
		//if(count($dbh->query($getMaxIdQuery->fetchAll()) == 1)) {
			//foreach($getMaxIdStatement as $theMax) {
			//	$maxId = $theMax['maxId'];
			//}
		//}
		//$month = $_POST['month'];
		//if(isset($_POST['description'])) {
		//	$desc = $_POST['description'];
		//}
		
	//	$uploadPath = "/var/www/levsdelight/htdocs/" . $month . "/" . $month . "-pictures/mobile-image" . $maxId . ".jpg";
	//	$databasePath = $month . "-pictures/mobile-image" . $maxId . ".jpg";
	//} 

	/************Implement sort query to get current highest sort query**********************/

	/************Implement Adding Image to database**********************/
	
	//try {
		
		//move_uploaded_file($_FILES["file"]["tmp_name"], $uploadPath);
	//} catch (Exception $e) {
	//	echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
	//}
	//echo '{"success": true, "fileString": " ' . $uploadPath . ' "}';
	
} catch (Exception $e) {
	echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
}

	

?>