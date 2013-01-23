<?php
include('connect.php');
try {
$month = "september2012";
			$getMonthIdQuery = "SELECT monthId FROM monthMap WHERE monthName = '" . $month . "'";
			$getMonthIdStatement = $dbh->query($getMonthIdQuery);
			if(count($dbh->query($getMonthIdQuery)->fetchAll() == 1)) {
				foreach($getMonthIdStatement as $theMonth){
					$monthId = $theMonth['monthId'];

echo $monthId;
				} 
			} else {
				echo '{"success": true, "message": "Could not get the MonthId: ' . $e->getMessage() . ' }';
			}
		} catch (Exception $e) {
			echo '{"success": true, "message": "Error Getting Slideshow Id: ' . $e->getMessage() . ' }';
		}

?>