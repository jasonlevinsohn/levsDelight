<?php

echo 'what up New York';

 /*
			//Load the Tasks
			require_once('../connect.php');
			$siteQuery = "SELECT * from sites";
			$getSitesStatement = $dbh->query($siteQuery);
			//$getSiteCount = count($getSitesStatement);
			//foreach($getSitesStatement as $siteRow)
			
			$taskQuery = "SELECT * from tasks";
			$getTasksStatement = $dbh->query($taskQuery);
		?>	
		
		<h1 id="title"><?php echo $title;?></h1>
		<table class="contentTable">
			<tr class="header-table">
				<th class="contentTable">Site</th>
				<?php
					$siteCounter = 0;
					foreach($getSitesStatement as $siteRow) { 
						//Get Site Id's for getting the tasks later on
						$siteNumberArray[$siteCounter] = $siteRow[0];
						$siteCounter++;
				?>
					<th colspan="3" class="contentTable"><?php echo $siteRow[2] . ' - ' . $siteRow[1];?></th>
				<?php } ?>	
			</tr>
			<tr class="contentTable">
				<td class="contentTable">Tasks</td>
				
				<!-- For each site we have add more column headers -->
				<?php foreach($dbh->query($siteQuery) as $siteRow) { ?>
					<td class="contentTable">Incomplete</td>
					<td class="contentTable">Pending</td>
					<td class="contentTable">Complete</td>
				<?php } ?>	
			
			</tr>
			<?php foreach($getTasksStatement as $taskRow) { ?>
				<tr class="contentTable">
					<td class="contentTable"><?php echo $taskRow[1]; ?></td>
						<?php
						//Write query for each task
						
						for($i = 0; $i < count($siteNumberArray); $i++) {
							
							$eachTaskQuery = "SELECT * FROM siteTasks WHERE siteId = " . $siteNumberArray[$i] . " AND taskId = " . $taskRow[0];
							
							
							if(count($dbh->query($eachTaskQuery)) == 1) {
								foreach($dbh->query($eachTaskQuery) as $eachTask) {
									if($eachTask['taskStage'] == 0) { ?>
										<td class="contentTable">X</td>
										<td class="contentTable"></td>
										<td class="contentTable"></td>
									<?php } elseif($eachTask['taskStage'] == 1) { ?>
										<td class="contentTable"></td>
										<td class="contentTable">X</td>
										<td class="contentTable"></td>
									<?php } elseif($eachTask['taskStage'] == 2) { ?>
										<td class="contentTable"></td>
										<td class="contentTable"></td>
										<td class="contentTable">X</td>
									<?php } else { ?>
										<td colspan="3" class="contentTable">N/A</td>
									<?php } 
								}
							} else { ?>
								<td colspan="3" class="contentTable">N/A</td>
							<?php } 
						} //End $siteNumberArray FOR LOOP
						
					?>
				</tr>
			<?php } 

*/
	
?>

