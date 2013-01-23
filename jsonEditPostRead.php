

<?php

require_once('connect.php');



	//#############-SITE PROFILE JSON RENDERER-######-BEGIN-#################
	try {
			$getTotalCount = "select * from mainposts";
			$getTotalStatement = $dbh->query($getTotalCount)->fetchAll();
			$recordTotal = count($getTotalStatement);
			
			
			$getPostsStatement = $dbh->query($getTotalCount);	
				
				
				
			
				
			$jsonProfile = '{"success": true, "totalCount": ' . $recordTotal . ',';
			$jsonProfile .= '"editPostRoot": [ ';
			//For readablitity and testing
			//$jsonProfile .= '<br>';
					
					$profileCounter = 0;
					foreach ($getPostsStatement as $profile) {
						
						$cleanString = str_replace("\"", "\\\"", $profile['posttext']);
						if($profileCounter == 0) {
							$jsonProfile .= ' { "id": ' . $profile['id'] . ', "title": "' . $profile['title'] . 
							'", "author": "' . $profile['author'] . '", "posttext": "' . $cleanString . '" } '; 
							//For readability and testing
							//$jsonProfile .= '<br>';
							$profileCounter = 1;
						} else {
							$jsonProfile .= ', { "id": ' . $profile['id'] . ', "title": "' . $profile['title'] . 
							'", "author": "' . $profile['author'] . '", "posttext": "' . $cleanString . '" } '; 
							//For readablitity and testing
							//$jsonProfile .= '<br>';
						}
						
					}
				$jsonProfile .= ']}';
					
			echo $jsonProfile;
			
		} catch (Exception $e) {
		
			echo '{"failure": true, "message":'.json_encode('Error getting Posts to Edit') . '}';
		
		}
		//#############-SITE PROFILE JSON RENDERER-######-END-#################
		
?>