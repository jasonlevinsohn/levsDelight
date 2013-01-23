<html>  
  <head><title>PHP Stock Query Test</title>  
  
  <?php
  
	//Report all errors
	error_reporting(E_ALL);
	
	require_once('functions/connect.php');
	//include('functions/functions.php');

	
		
		$yqlBaseUrl = "http://query.yahooapis.com/v1/public/yql?q=";
	
		$yqlQuery = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20music.artist.popular%20where%20website%20like%20'%25lady%25'&format=json&callback=cbfunc";
		$theQuery = "select%20*%20from%20music.artist.popular%20where%20website%20like%20'%25lady%25'";
		$uncoded = "select * from music.artist.popular where website like '%lady%'";
		
		$stockQuery = "select symbol, AskRealtime, BidRealtime from yahoo.finance.quotes where symbol in ";
		$stockQuery .= "(";
		
		$stockQuery .= "'CCI', 'ATPG', 'ALU', 'AXAS', 'AAV', 'MRX', 'ANW', 'ALJ', 'AMCF', 'ACI'";
		$stockQuery .= ", 'BPZ', 'BRN', 'BKEP', 'BOLT', 'CFK', 'CKX', 'CRED', 'DVR', 'CPE', 'NEP'";
		$stockQuery .= ", 'CRK', 'CEP', 'CZZ', 'CXPO', 'DK', 'DBLE', 'XCO', 'END', 'ESA', 'EQU'";
		$stockQuery .= ", 'EPM', 'EXH', 'FXEN', 'FPP', 'FTK', 'FST', 'GMXR', 'GST', 'GOK', 'GGS'";
		$stockQuery .= ", 'GTE', 'GRH', 'HKN', 'HK', 'HNRG', 'HNR', 'HEK', 'HERO', 'HUSA', 'HDY'";
		$stockQuery .= ", 'IO', 'JRCC', 'KOG', 'LLEN', 'LPR', 'LPH', 'LEI', 'MPET', 'MHR', 'MXC'";
		$stockQuery .= ", 'MILL', 'NGS', 'GBR', 'NR', 'NOA', 'ORIG', 'OXF', 'PACD', 'PKD', 'PCX'";


		$stockQuery .= ")";
		
		//********************We are on page 11*************

		$encodedQuery = urlencode($stockQuery);
		

		
		echo 'The Encoded Query is ' . $encodedQuery . '<br /><br />';
		
		
		$queryToSend = $yqlBaseUrl . $encodedQuery . "&format=json&callback=&env=http://datatables.org/alltables.env";
		
		
		$response = file_get_contents($queryToSend);
		
		
		//var_dump($response);
		$json = json_decode($response, true);
		
		//var_dump($json);
		
		//$track = $json['query']['results']['Artist'][0]['trackCount'];
		//$track = $json['query']['results']['Artist'];
		$track = $json['query']['results']['quote'];

		//var_dump($track);
		
		try {
			foreach($track as $artist) {
				// $trackNumber = $artist['trackCount'];
				$symbol = $artist['symbol'];
				$ask = $artist['AskRealtime'];
				$bid = $artist['BidRealtime'];
				$currentTime = date("Y-m-d : H:i:s", time());
				
				echo '\n\n The script last ran at: ' . $currentTime;
				try {
					$tickerDataStatement = "INSERT INTO stocks (ticker, ask, bid, timestamp) VALUES (?, ?, ?, ?)";
					$tickerDataPrep = $dbh->prepare($tickerDataStatement);
					$tickerDataPrep->execute(array($symbol, $ask, $bid, $currentTime));
					echo 'Ticker ' . $symbol . ' Inserted <br />\n';
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		//var_dump($track);
		
		//echo $track;
			
	//phpinfo();
	
	

  ?>
  </head>  
 
</html>  