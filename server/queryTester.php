<?php

include('../connect.php');

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
			echo '{"success": true, "message": " '. $maxId . ' }';

			
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Querying Database for Hightest ID' . $e->getMessage() . ' }';
		}
?>