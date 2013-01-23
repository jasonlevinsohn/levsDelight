<?php
//this script is the beginning

include('functions/connect.php');

$symbolQuery = "SELECT DISTINCT ticker FROM stocks";
$symbolStatement = $dbh->query($symbolQuery)->fetchAll();

$symbolCounter = 0;
$symbolCount = count($symbolStatement);

$symbolArray = array();
foreach ($symbolStatement as $ticker) {
	array_push($symbolArray, $ticker);
	$symbolCounter++;
}

//The alternating row color.
$rowColor = "#D5DCF0";
$altCounter = 0;



echo "There are $symbolCount tickers being captured. < /br>";

?>

<table>
	<tr>
		<th>Symbol</th>
		<th>Average</th>
		<th>Total</th>
		<th>Count</th>
	</tr>

<?php

//Now lets get average price of every stock

foreach ($symbolArray as $ticker) {


	//First we have to get all the records for each stock
	$symbolCountQuery = "SELECT bid, timestamp from stocks ";
	$symbolCountQuery .= " WHERE ticker = '" . $ticker['ticker'] . "' ";
	$symbolCountQuery .= " ORDER BY timestamp DESC";
	
	echo $symbolCountQuery;
	//Get the high price and the low price at some point

	$stockStatement = $dbh->query($symbolCountQuery)->fetchAll();
	

	//Now we get a count for each stock. They will be different, because
	//we haven't been capturing all of them all the time.
	$captureCount = 0;
	$firstCount = 0;
	$priceArray = array();
	$timeArray = array();
	foreach ($stockStatement as $stock) {

		$strTime = strtotime($stock['timestamp']);
		$formatTime = date("H:i", $strTime);
		if($ticker['ticker'] == 'CCI' && $formatTime == '09:00') {
			$firstCount++;
			echo "The current Price: " . $stock['bid'] . " and the time is " . $formatTime . " counter: " . $firstCount . "<br />";
			
			
		}
			array_push($priceArray,  $stock['bid']);
			array_push($timeArray, $stock['timestamp']);
			$captureCount++;

		
		
	}
//var_dump($priceArray);

	//Let's add up the total prices
	$totalPrice = 0.00;
	$currentPrice = 0.00;
	foreach ($priceArray as $price) {
		
		$currentPrice = $price[0];
		if($ticker['ticker'] == 'CCI') {
			echo "The current Prisle: " . $price . "<br />";
		}
		

		$totalPrice = $totalPrice + $currentPrice;
		
	}
	
	//Now what is the average price?
	$averagePrice = $totalPrice / $captureCount;
	
	?>
	<tr>
	 	<?php if($altCounter % 2) { $altCounter++ ?>
			<td style="backgroundColor: <?php echo $rowColor; ?>">
				<?php echo $ticker['ticker']; ?>
			</td>
			<td style="backgroundColor: <?php echo $rowColor; ?>">
				<?php echo $averagePrice; ?>
			</td>
			<td style="backgroundColor: <?php echo $rowColor; ?>">
				<?php echo $totalPrice; ?>
			</td>
			<td style="backgroundColor: <?php echo $rowColor; ?>">
				<?php echo $captureCount; ?>
			</td>

		<?php } else { ?>
			<td>
				<?php echo $ticker['ticker']; ?>
			</td>
			<td>
				<?php echo $averagePrice; ?>
			</td>
			<td>
				<?php echo $totalPrice; ?>
			</td>
			<td>
				<?php echo $captureCount; ?>
			</td>


		<?php } ?>
	</tr>
	
<?php } ?>

</table>

?>

< /br>

	




var_dump($symbolArray);




?>
