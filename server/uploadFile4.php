<?php
//Report all errors
try {
	//$file = $_POST['file'];
	$dir = "july2012";
	$return = var_export($_FILES, true);
	if(isset($_POST['value1'])) {
		$dir = $_POST['value1'];
	}
	
	try {
		$newImageName = "ourLittleImage.jpg";
		move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/levsdelight/htdocs/july2012/july2012-pictures/" . $newImageName);
	} catch (Exception $e) {
		echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
	}
	echo '{"success": true, "fileString": " ' . $dir . ' "}';

} catch (Exception $e) {
	echo '{"failure": true, "message": " ' . $e->getMessage() . ' "}';
}

	

?>