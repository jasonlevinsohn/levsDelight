<?php
	sleep(1);
	
	if(empty($_POST['newOrder'])) {
		$return['error'] = true;
		$return['message'] = 'There is no tag named sortOrder';
	} else {
		//Change the sort order of the pictures
		try{
			//Capture the vaiables index post
			$id = $_POST['recordid'];
			$oldOrder = $_POST['oldOrder'];
			$newOrder = $_POST['newOrder'];	
			$slideshowId = $_POST['slideshowId'];
				
			require_once('../connect.php');
			
			//IF the new sort order is higher than the old sort order, decrease all the order's between the old order and new
			//order by 1 and set the order of the record id to the new order.
			if($newOrder > $oldOrder){
					$higherSort = "SELECT id FROM slideshows WHERE order > " . $oldOrder . " AND < " . $newOrder . "AND slideshowid = " .
					$slideShowId;
				
				$return['error'] = false;	
				$return['message'] = $higherSort;
				//Write this code
			} else {
				//If the new order is lower than the old sort order, increase all the order's between the old order and the new
				//order by 1 and set the order of the record id to the new order.
				
			}
			$return['error'] = false;
			//$return['message'] = 'Picture ' . $_POST['newOrder'] . ' sorted.';
			
			
			
		} catch (Exception $e) {
			$return['error'] = true;
			$return['message'] = 'General Error changing the sort order';
		}
		
	}
	
	echo json_encode($return);
?>