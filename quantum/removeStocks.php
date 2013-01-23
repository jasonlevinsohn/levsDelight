<html>  
  <head><title>PHP Stock Removal Test</title>  
  
  <?php
  
	//Report all errors
	error_reporting(E_ALL);
	
	require_once('functions/connect.php');
	//include('functions/functions.php');

	
	
	
		try {
			$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
			
			$currentDate = date("Y-m-d", $lastmonth);
			echo "The current time is: " . $currentDate;
			
			$removeStocksQuery = "DELETE FROM stocks WHERE timestamp < ?";
			$removeStocksStatement = $dbh->prepare($removeStocksQuery);
			$removeStocksStatement->execute(array($currentDate));
			echo "All stocks have been removed before " . $currentDate;
			
			
			
		} catch (Exception $e) {
		
			echo "Error deleting old stocks for date " . $currentDate . ": " . $e->getMessage();
		}
		

  ?>
  </head>  
 
</html>  