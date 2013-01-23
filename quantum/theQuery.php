<html>  
  <head><title>Stock Query Test</title>  
  
  <?php
  
	//Report all errors
	error_reporting(E_ALL);
	
	require_once('functions/connect.php');
	

	
		
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
		
		//********************We are on page 10*************

		echo $stockQuery;		
		
	?>
</head>
<body>
</body>
</html>