<?php
//Report all errors

include('../connect.php');

try {
	$title = "Put Title Here.";
	$desc = "Put Description Here.";
    $maxId = "1000";
	if(isset($_POST['month'])){
		$month = $_POST['month'];
		if(isset($_POST['description'])) {
			$desc = $_POST['description'];
		}
		if(isset($_POST['title'])) {
			$title = $_POST['title'];
		}
		
		
		//******************GET THE HIGHEST ID TO USE AS THE IMAGE NAME IF IT EXISTS**********************
		try {
			$getMaxIdQuery = "SELECT MAX(id) as maxId FROM slideshows";
			$getMaxIdStatement = $dbh->query($getMaxIdQuery);
			if(count($dbh->query($getMaxIdQuery)->fetchAll() == 1)) {
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
			$image->thumbnailImage(533, 400, TRUE);
			
			//Save the Image to our slideshow folder
			$image->writeImage($uploadPath);
			
			
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Uploading File: ' . $e->getMessage() . ' }';
		}
		
		//**********************GET THE SLIDESHOW ID FROM THE SLIDESHOW MAP TABLE***************
		
		//**********************GET THE HIGHEST SORT ORDER IN OUR CURRENT SLIDESHOW*************
		try {
			$getSortOrderQuery = "SELECT MAX(`order`) as sortOrder FROM slideshows WHERE slideshowid = 14";
			$getSortOrderStatement = $dbh->query($getSortOrderQuery);
			if(count($dbh->query($getSortOrderQuery)->fetchAll() == 1)) {
				foreach($getSortOrderStatement as $theSort) {
					$sortOrder = $theSort['sortOrder'] + 1;
				}
			} else {
				$sortOrder = "1";
			}
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Getting Highest Sort Order: ' . $e->getMessage() . ' }';
		}
		
		//**********************PERSIST THE MAP TO OUR NEWLY UPLOADED PICTURE TO THE SLIDESHOW*************
		try {
			$databasePath = $month . "-pictures/mobile-image" . $maxId . ".jpg";
			
			$addPictureQuery = "INSERT INTO slideshows(title, `desc`, pictureLocation, isActive, slideshowid, `order`)";
			$addPictureQuery .= " VALUES('" . $title . "', '" . $desc . "', '" . $databasePath . "', 1, 14, " . $sortOrder .  ")";
		 	$addPicturePrep = $dbh->prepare($addPictureQuery);
			$addPicturePrep->execute();
			
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Persisting File Location to Database: ' . $e->getMessage() . ' }';
		}
		
		echo '{"success": true, "message": "Picture Uploaded to: ' . $month . ' slideshow. " }';
	} else {
		echo '{"success": true, "message": "The month is not set" }';

	}
	
	

	
	
} catch (Exception $e) {
	echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
}

	

?>