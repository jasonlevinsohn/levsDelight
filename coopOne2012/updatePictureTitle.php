<form method="get" name="updateDafneyForm" id="updateDafneyForm" action="index2.php" >


<?php
	require_once('connect.php');
	//$pictureId = stripslashes((string) $_GET['id']);
	//$pictureId = mysql_real_escape_string($_GET['id']);

	$pictureId = $_GET['id'];
	
	
	$pictureQuery = "SELECT * FROM slideshows where id = " . $pictureId;
	$pictureTitle = "";
	$pictureDesc = "";
	$getPicture = $dbh->query($pictureQuery);
	echo "The picture id is: " . $pictureId . "</br>";	
	if(count($getPicture) == 1) {
		foreach($dbh->query($pictureQuery) as $row) {
			$pictureTitle = $row['title'];
		}
		echo "the picture title is: " . $pictureTitle . "</br>";
		
	} else {
		echo 'There was an error getting the Picture Text.';
	}

?>
<input type="text" name="pictureUpdateTitle"  id="pictureUpdateTitle" size="10" value="<?php echo $pictureTitle; ?>" />
<input type="hidden" name="pictureUpdateId" id="pictureUpdateId" value="<?php echo $pictureId ?>" />
<input type="submit" name="submitUpdatePicture" id="submitUpdatePicture" value="Ok" style="width: 30px; " />


</form>