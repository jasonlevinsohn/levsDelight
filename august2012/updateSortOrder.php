<?php
	sleep(1);
	
	if(empty($_POST['newOrder'])) {
		$return['error'] = true;
		$return['message'] = 'There is no tag named sortOrder';
	} else {
		//Change the sort order of the pictures
		try{
			//Capture the vaiables index post
			$id = $_POST['recordId'];
			$oldOrder = $_POST['oldOrder'];
			$newOrder = $_POST['newOrder'];	
			$slideshowId = $_POST['slideshowId'];
				
			require_once('../connect.php');
			
			//IF the new sort order is higher than the old sort order, decrease all the order's between the old order and new
			//order by 1 and set the order of the record id to the new order.
			if($newOrder > $oldOrder){
						
					try {
						$higherSort = "SELECT id, `order` FROM slideshows WHERE `order` > " . $oldOrder . " AND `order` <= " . $newOrder;
					$higherSort .= " AND slideshowId = " . $slideshowId . " ORDER BY `order` ASC";
					
					$higherSortStatement = $dbh->query($higherSort);
					
					//Update all the order's between the new and old order
					foreach($higherSortStatement as $higher) {
						$oneLess = $higher['order'] - 1;
						$theId = $higher['id'];
						$higherSortUpdate = "UPDATE slideshows SET `order` = " . $oneLess . " WHERE id = " . $theId;
						$higherSortPrep = $dbh->prepare($higherSortUpdate);
						$higherSortPrep->execute();
							
					} 
					
					//Set the New order number to the picture we want to change
					$setNewSort = "UPDATE slideshows SET `order` = " . $newOrder . " WHERE id = " . $id;
					$setNewPrep = $dbh->prepare($setNewSort);
					$setNewPrep->execute();
						
						$return['error'] = false;	
						$return['message'] = 'Picture Sorted Up.';
						
					} catch(Exception $e) {
						
						$return['error'] = true;	
						$return['message'] = "The Update Failed to Execute";
						
					}
					
				
				
				//Write this code
			} else {
				//If the new order is lower than the old sort order, increase all the order's between the old order and the new
				//order by 1 and set the order of the record id to the new order.
				try {
					$lowerSort = "SELECT id, `order` FROM slideshows WHERE `order` < " . $oldOrder . " AND `order` >= " . $newOrder;
					$lowerSort .= " AND slideshowId = " . $slideshowId . " ORDER BY `order` ASC";
					
					$lowerSortStatement = $dbh->query($lowerSort);
					
					//Update all the order's between the new and old order
					foreach($lowerSortStatement as $lower) {
						$oneMore = $lower['order'] + 1;
						$theId = $lower['id'];
						$lowerSortUpdate = "UPDATE slideshows SET `order` = " . $oneMore . " WHERE id = " . $theId;
						$lowerSortPrep = $dbh->prepare($lowerSortUpdate);
						$lowerSortPrep->execute();
							
					} 
					
					//Set the New order number to the picture we want to change
					$setNewSort = "UPDATE slideshows SET `order` = " . $newOrder . " WHERE id = " . $id;
					$setNewPrep = $dbh->prepare($setNewSort);
					$setNewPrep->execute();
						
						$return['error'] = false;	
						$return['message'] = 'Picture Sorted Down.';
						
					} catch(Exception $e) {
						
						$return['error'] = true;	
						$return['message'] = "The Update Failed to Execute";
						
					}
				
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