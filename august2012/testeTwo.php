<?php
//Report all errors

include('../connect.php');

try {
	$desc = "Put Description Here.";

	if(isset($_POST['month'])){
		$month = $_POST['month'];
		if(isset($_POST['description'])) {
			$desc = $_POST['description'];
		}
		
		
		//******************GET THE HIGHEST ID TO USE AS THE IMAGE NAME IF IT EXISTS**********************
		try {
			$getMaxIdQuery = "SELECT MAX(id) as maxId FROM slideshows";
			$getMaxIdStatement = $dbh->query($getMaxIdQuery);
			if(count($dbh->query($getMaxIdQuery->fetchAll()) == 1)) {
				foreach($getMaxIdStatement as $theMax) {
					$maxId = $theMax['maxId'];
				} 
			} else {
				$maxId = 0;
			}
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Querying Database for Hightest ID' . $e->getMessage() . ' }';
		}
		
		
		//******************UPLOAD OUR IMAGE TO THE SERVER**********************
		//move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/levsdelight/htdocs/" . $newImageName);
		try {
			$uploadPath = "/var/www/levsdelight/htdocs/" . $month . "/" . $month . "-pictures/mobile-image" . $maxId . ".jpg";
			
			//Get the Image from the FILES Header
			$image = new Imagick($_FILES["file"]["tmp_name"]);
			
			//Resize the image to what we need
			$image->thumbnailImage(400, 600, TRUE);
			
			//Save the Image to our slideshow folder
			$image->writeImage($uploadPath);
			
			
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Uploading File: ' . $e->getMessage() . ' }';
		}
		  
		 
		echo '{"success": true, "message": "The month is: ' . $desc . ' " }';
	} else {
		echo '{"success": true, "message": "The month is not set" }';

	}
	
	

	
	
} catch (Exception $e) {
	echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
}

	

?>