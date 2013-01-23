<?php
if(isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
	
	//Include connection 
	include('../connect.php');
	
	//Get the data
	$imageData = $GLOBALS['HTTP_RAW_POST_DATA'];

	
	$filename    = $_SERVER['HTTP_UPLOADFILENAME'];
	$filesize    = $_SERVER['HTTP_UPLOADFILESIZE'];
	$filetype    = $_SERVER['HTTP_UPLOADFILETYPE'];
	$folderName  = $_SERVER['HTTP_FOLDERNAME'];
	$slideshowId = $_SERVER['HTTP_SLIDESHOWID'];
	

	//Get the image type
	$imageType = strpos($filetype, 'jpeg');
	

	//We use === because the position might actually be 0 and the if statement
	//will treat that as false if we only used ==
	if($imageType === false) {
		echo 'File is not a JPEG, we can not upload it.';
	} else {
		
		//Remove the headers.  
		$filteredData = substr($imageData, strpos($imageData, ",")+1);

		//Decode the data from the Base64 encoding
		$unencodedData = base64_decode($filteredData);

		//Save the file and create an entry in the database
		try {
			//************************CHANGE HERE TO THE MONTH OF PICTURES*************************
			//************************FOLDER PERMISSIONS ALSO NEED TO BE CHANGE - sudo chmod 777 [foldername]**********************
			$fileToSave = "../" . $folderName . "/" . $folderName . "-pictures/" . $filename;
			$fp = fopen($fileToSave, 'x');
			fwrite($fp, $unencodedData);
			fclose($fp);
			
			$pictureLocation = $folderName . "-pictures/" . $filename;
		

			$insertPictureQuery = "INSERT INTO slideshows(pictureLocation, isActive, slideshowid) VALUES (?, ?, ?)";
			$insertPicturePrep = $dbh->prepare($insertPictureQuery);
			//**************************CHANGE HERE THE NUMBER OF THE SLIDESHOW*********************
			$insertPicturePrep->execute(array($pictureLocation, 1, $slideshowId)) or die('Error inserting picture record');
		
		

		} catch (Exception $e) {
			echo 'Error saving the file';
		}
		

	}

} else {
	echo "Error writing file to system";
}
?>