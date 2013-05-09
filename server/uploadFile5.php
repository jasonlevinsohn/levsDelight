<?php
//Report all errors

include('../connect.php');

try {
	$title = "Put Title Here.";
	$desc = "Put Description Here.";
          $maxId = "1000";
    $monthId = "13";
    $createThumb = False;

	if(isset($_POST['month'])){
        $month = $_POST['month'];

        // Check to see if Ezra is the month and we will create a thumbnail picture as well.
        if($month == 'ezra') {
            $createThumb = True;
        }
		if(isset($_POST['description'])) {
			$desc = $_POST['description'];
		}
		if(isset($_POST['title'])) {
			$title = $_POST['title'];
		}
		
		
		//******************GET THE HIGHEST ID TO USE AS THE IMAGE NAME IF IT EXISTS**********************
        try {
            if($createThumb) {
			    $getMaxIdQuery = "SELECT MAX(id) as maxId FROM ezraShows";
            } else {
			    $getMaxIdQuery = "SELECT MAX(id) as maxId FROM slideshows";
            }
			$getMaxIdStatement = $dbh->query($getMaxIdQuery);
			if(count($dbh->query($getMaxIdQuery)->fetchAll() == 1)) {
				foreach($getMaxIdStatement as $theMax) {
					$maxId = $theMax['maxId'];
				} 
			} else {
				$maxId = 0;
			}
		} catch (Exception $e) {
			echo '{"success": false, "message": "Error Querying Database for Hightest ID' . $e->getMessage() . ' }';
		}
		
		
		//******************UPLOAD OUR IMAGE TO THE SERVER**********************
		//move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/levsdelight/htdocs/" . $newImageName);
		try {


            // Create Thumbnail if Ezra Picture
            if ($createThumb) {

                $imageDimensions = new Imagick($_FILES["file"]["tmp_name"]);
                $geo = $imageDimensions->getImageGeometry();
                $imageWidth = $geo['width'];
                $imageHeight = $geo['height'];
                error_log("Image Height: " . $imageHeight . " Width: " . $imageWidth);

		        $or = $imageDimensions->getImageOrientation();
                error_log("orientation: " . $or);

                if ($or == 1) {
                    $textOrientation = 'Landscape';
                } else if ($or == 6) {
                    $textOrientation = 'Portrait';
                } else {
                    $textOrientation = 'Unknown';
                }


			    $thumbPath = "/var/www/levsdelight/htdocs/" . $month . "/images/thumbs/mobile-image" . $maxId . ".jpg";
                $image2 = new Imagick($_FILES["file"]["tmp_name"]);
			    $image2->thumbnailImage(200, 200, TRUE);
			    $image2->writeImage($thumbPath);

			    $uploadPath = "/var/www/levsdelight/htdocs/" . $month . "/images/large/mobile-image" . $maxId . ".jpg";
                $image = new Imagick($_FILES["file"]["tmp_name"]);
			    $image->thumbnailImage($imageWidth, $imageHeight, TRUE);
			    $image->writeImage($uploadPath);
            } else {

                $uploadPath = "/var/www/levsdelight/htdocs/" . $month . "/" . $month . "-pictures/mobile-image" . $maxId . ".jpg";
                
                //Get the Image from the FILES Header
                $image = new Imagick($_FILES["file"]["tmp_name"]);

                //Resize the image to what we need
                $image->thumbnailImage(533, 400, TRUE);
                
                //Save the Image to our slideshow folder
                $image->writeImage($uploadPath);
            }
			
			
		} catch (Exception $e) {
			echo '{"success": false, "message": "Error Uploading File: ' . $e->getMessage() . ' }';
		}
		
		//**********************GET THE SLIDESHOW ID FROM THE SLIDESHOW MAP TABLE***************
		try {
			$getMonthIdQuery = "SELECT monthId FROM monthMap WHERE monthName = '" . $month . "'";
			$getMonthIdStatement = $dbh->query($getMonthIdQuery);
			if(count($dbh->query($getMonthIdQuery)->fetchAll() == 1)) {
				foreach($getMonthIdStatement as $theMonth){
					$monthId = $theMonth['monthId'];
				} 
			} else {
				echo '{"success": true, "message": "Could not get the MonthId: ' . $e->getMessage() . ' }';
			}
		} catch (Exception $e) {
			echo '{"success": false, "message": "Error Getting Slideshow Id: ' . $e->getMessage() . ' }';
		}
		
		
		//**********************GET THE HIGHEST SORT ORDER IN OUR CURRENT SLIDESHOW*************
        try {
			$getSortOrderQuery = "SELECT MAX(`order`) as sortOrder FROM slideshows WHERE slideshowid = " . $monthId;
			$getSortOrderStatement = $dbh->query($getSortOrderQuery);
			if(count($dbh->query($getSortOrderQuery)->fetchAll() == 1)) {
				foreach($getSortOrderStatement as $theSort) {
					$sortOrder = $theSort['sortOrder'] + 1;
				}
			} else {
				$sortOrder = "1";
			}
		} catch (Exception $e) {
			echo '{"success": false, "message": "Error Getting Highest Sort Order: ' . $e->getMessage() . ' }';
		}
		
		//**********************PERSIST THE MAP TO OUR NEWLY UPLOADED PICTURE TO THE SLIDESHOW*************
        try {
            if($createThumb) {

                $thumbPath = "images/thumbs/mobile-image" . $maxId . ".jpg";
                $largePath = "images/large/mobile-image" . $maxId . ".jpg";
                $rightNow = date("Y-m-d H:i:s");
                $addPictureQuery = "INSERT INTO ezraShows(title, `desc`, thumbLocation, largeLocation, isActive, monthId, sortOrder, timestamp, height, width, orientation)";
                $addPictureQuery .= " VALUES('" . $title . "', '" . $desc . "', '" . $thumbPath . "', '" . $largePath . "', 1, " . $monthId . ", " . $sortOrder . ", '" . $rightNow . "', " . $imageHeight . ", " . $imageWidth . ", '" . $textOrientation . "')";
                error_log("The mysql insert query for uploading pictures: ");
                error_log($addPictureQuery);
                $addPicturePrep = $dbh->prepare($addPictureQuery);
                $addPicturePrep->execute();
            } else {

                $databasePath = $month . "-pictures/mobile-image" . $maxId . ".jpg";
                
                $addPictureQuery = "INSERT INTO slideshows(title, `desc`, pictureLocation, isActive, slideshowid, `order`)";
                $addPictureQuery .= " VALUES('" . $title . "', '" . $desc . "', '" . $databasePath . "', 1, " . $monthId . ", " . $sortOrder .  ")";
                $addPicturePrep = $dbh->prepare($addPictureQuery);
                $addPicturePrep->execute();
            }

			
		} catch (Exception $e) {
			echo '{"success": false, "message": "Error Persisting File Location to Database: ' . $e->getMessage() . ' }';
		}
		

        echo '{"success": true, "message": "Picture Uploaded to: ' . $month . ' slideshow. " }';
        error_log("A picture has been uploaded successfully.");
	} else {
		echo '{"success": false, "message": "The month is not set" }';

	}
	
	

	
	
} catch (Exception $e) {
	echo '{"success": false, "message": " ' . $e->getMessage() . ' "}';
}

	

?>
