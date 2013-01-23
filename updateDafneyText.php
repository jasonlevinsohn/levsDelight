<form method="get" name="updateDafneyForm" id="updateDafneyForm" action="index.php" >


<?php
	require_once('connect.php');
	$dafneyQuery = "SELECT * FROM frontpageposts where id = 1";
	$dafneyTitle = "";
	$dafneyText = "";
	$getDafney = $dbh->query($dafneyQuery);
		
	if(count($getDafney) == 1) {
		foreach($dbh->query($dafneyQuery) as $row) {
			$dafneyText = $row['postText'];
		}
		
	} else {
		echo 'There was an error getting the Dafney Text.';
	}

?>
<textarea rows="5" cols="20" name="dafneyUpdatePostText"  id="dafneyUpdatePostText">
	 <?php echo $dafneyText; ?>
</textarea>
<input type="submit" name="submitUpdateDafney" id="submitUpdateDafney" value="Ok" style="width: 30px; " />


</form>