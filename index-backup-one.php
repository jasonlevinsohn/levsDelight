<!DOCTYPE html>
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Nimbuslike
Description: A two-column, fixed-width design for 1024x768 screen resolutions.
Version    : 1.0
Released   : 20090717

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>LevsDelight</title>
<meta name="keywords" content="villa rica farm" />
<meta name="description" content="" />
<!-- <link rel="stylesheet" type="text/css" href="extjs/ext-4-0-2a/resources/css/ext-standard.css"> -->
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<!--  -->

<!-- JavaScript -->
    <script type="text/javascript" src="extjs/ext-4-0-2a/ext-all.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
		Ext.onReady(function() {
			var ls = Ext.get('loginSubmit');
		
			ls.on('click', function() {
				
				
			}); 
		
		});
		
		
		
	</script>
</head>
<body>

<?php
//Report all errors
error_reporting(E_ALL);

//Start the session stuff
session_start();

$title = 'Lev\'s Delight';


//Is the browser an iPad?
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');

$browser = $_SERVER['HTTP_USER_AGENT'];


//Send an email whenever someone visits the Levs Delight Website

$to = 'jason.levinsohn@gmail.com';
$subject = 'Visitor to Lev\'s Delight';
$message = 'The visitor is using browser: ' . $browser;

if(mail($to, $subject, $message)) {

	echo 'Message Sent';
} else {
	//echo 'Message failed to send';
}




if(isset($_GET['userInput']) && isset($_GET['passInput'])) {
	
	//connect to the database
	require_once('connect.php');
	$login = $_GET['userInput'];
	$pass = md5($_GET['passInput']);
	$qry = "SELECT * FROM users where user = '$login' AND pass = '$pass'";
	
	$statement = $dbh->query($qry);
	
	
	if(count($statement) == 1) {
		foreach($dbh->query($qry) as $row) {
			
			session_regenerate_id();
			$_SESSION['SESS_MEMBER_ID'] = $row['id'];
			$_SESSION['SESS_FIRST_NAME'] = $row['firstName'];
			
		}
	}
	
	
} else if(isset($_GET['loginSubmit']) && $_GET['loginSubmit'] == 'logout') {
	session_unset();
	session_destroy();
}

//Update Dafney Title Section
if(isset($_GET['dafneyUpdateText'])) {
	require_once('connect.php');
	$updateText = $_GET['dafneyUpdateText'];
	$updateQuery = "UPDATE frontpageposts SET title=? WHERE id=?";
	$updatePrep = $dbh->prepare($updateQuery);
	$updatePrep->execute(array($updateText, 1));
	
	
}

//Update Dafney Title Section
if(isset($_GET['dafneyUpdatePostText'])) {
	require_once('connect.php');
	$updateText = $_GET['dafneyUpdatePostText'];
	$updateQuery = "UPDATE frontpageposts SET postText=? WHERE id=?";
	$updatePrep = $dbh->prepare($updateQuery);
	$updatePrep->execute(array($updateText, 1));
	
	
}



?>
<div id="wrapper">
	<div id="header-wrapper">
		
		<div id="header">
			<div id="logo">
				<h1><a href="#"><?php echo $title; ?></a></h1>
				<h2>by Jason and Natty</h2>
			</div>
			
			<!-- BEGIN LOGIN/LOGOUT SCRIPTS -->
			<?php if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { ?>
				<div id="logout">
					
					<form name="logout" id="logout" method="get" action="index.php">
						<?php echo 'hello, ' . $_SESSION['SESS_FIRST_NAME'];?>
						<input type="submit" name="loginSubmit" id="loginSubmit" value="logout" />
					</form>
				</div>
			<?php } else { ?>	
				<div id="login">
					<form name="login" id="login" method="get" action="index.php">
						<span id="userSpan" class="login">user:</span>
						<input type="text" id="userInput" name="userInput" />
						<span id="passSpan" class="login">pass:</span>
						<input type="text" id="passInput" name="passInput" />
						<input type="submit" name="loginSubmit" id="loginSubmit" value="login" />
					</form>
				</div>	
			<?php } ?>
			<!-- END LOGIN/LOGOUT SCRIPTS -->
			<div id="search">
				<form method="get" action="">
					<fieldset>
					<input type="text" id="search-text" name="s" value="" />
					</fieldset>
				</form>
			</div>
			<!-- end #logo -->
		</div>
		<!-- end #header -->
		<div id="menu">
			<ul>
				<li class="first"><a href="http://www.levsdelight.com">Home</a></li>
				<li><a href="http://www.levsdelight.com/october2011">October Pictures</a></li>
				<li><a href="http://www.levsdelight.com/november2011">November Pictures</a></li>
				<li><a href="http://www.levsdelight.com/january2012">January Pictures</a></li>
				<li><a href="http://www.levsdelight.com/february2012">February Pictures</a></li>
				<!-- <li><a href="#">Portfolio</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li> -->
			</ul>
		</div>
		<!-- end #menu -->
	</div>
	<!-- end #header-wrapper -->
	<div id="page">
		<div id="banner"><a href="#"><img src="images/img05.jpg" alt="" /></a></div> 
		<!-- <div id="banner"><a href="#"><img src="images/nat-on-tractor.jpg" alt="" /></a></div> -->
		<div id="page-bgcontent">
			<div id="content">
				<!--
				<div class="post">
					<h2 class="title">Welcome to Lev's Delight Farms </h2>
					<p class="byline">by Jason and Natty </p>
					
					<div class="entry">
						 <p><strong>Nimbuslike</strong> is a free template by <a href="http://www.nodethirtythree.com/">NodeThirtyThree</a> and <a href="http://www.freecsstemplates.org">Free CSS Templates</a> released under the <a href="http://creativecommons.org/">Creative Commons Attribution license</a>. The photo above is from <a href="http://www.pdphoto.org">PDPhoto.org</a>. You’re free to use this template for commercial or personal use provided you keep the footer links to our sites intact.  That’s all :)</p>
						<p>This template is also available as a <a href="http://www.freewpthemes.net">WordPress theme</a>. Check out more WordPress conversions of our templates at <a href="http://www.freewpthemes.net">Free WP Themes</a> and follow me on <a href="http://twitter.com/nodethirtythree">Twitter</a> for news and updates.</p>
					</div>
					<div class="meta">
						<p class="links"><a href="#" class="comments">Comments (64)</a> &nbsp;&nbsp;&nbsp; <a href="#" class="permalink">Full article</a></p>
					</div>
					
				</div> -->
				<div class="post">
					<h2 class="title">The 8,000 sqft. fence is underway</h2>
					<p class="byline">posted by Jason on March 12th, 2012</p>
					<div class="entry">
						<p>
							Nat and I have been hard at work trying to get our fence up before April.  We dug out 80 fence post holes last weekend
							and put in most of the fence posts.  We have about 75 left to go.  Hopefully we can find the time to get it all done.
						</p>
						<p>Check out our new Pictures on the <a href="http://www.levsdelight.com/february2012/">February Pictures Page</a> </p>
						
					</div>
					
					<div class="meta">
						<p class="links"><a href="#" class="comments">Comments (1)</a> Natty says "These are awesome!!" <a href="http://www.levsdelight.com/january2012/" class="permalink">Full article</a></p>
					</div>
					
					
				</div>

				<div class="post">
					<h2 class="title">New January Pictures are Up!</h2>
					<p class="byline">posted by Jason on January 27th, 2012</p>
					<div class="entry">
						<p>Check out our new Pictures on the <a href="http://www.levsdelight.com/january2012/">January Pictures Page</a> </p>
						
					</div>
					
					<div class="meta">
						<p class="links"><a href="#" class="comments">Comments (1)</a> Natty says "These are awesome!!" <a href="http://www.levsdelight.com/january2012/" class="permalink">Full article</a></p>
					</div>
					
					
				</div>
				<div class="post">
					<h2 class="title">Welcome to our new Site</h2>
					<p class="byline">posted by Jason on November 1st, 2011</p>
					<div class="entry">
						<p>Hello everyone and welcome to our new site about our farm.  Natty and I are very happy we could share all our farm adventures and hard work with you. </p>
						<p>Enjoy watching our projects and seeing all our farm pictures.</p>
					</div>
					<!--
					<div class="meta">
						<p class="links"><a href="#" class="comments">Comments (64)</a> &nbsp;&nbsp;&nbsp; <a href="#" class="permalink">Full article</a></p>
					</div>
					-->
					
				</div>

			</div>
			<!-- end #content -->
			<div id="sidebar">
				<ul>
					<?php 
						require_once('connect.php');
						$dafneyQuery = "SELECT * FROM frontpageposts where id = 1";
						$dafneyTitle = "";
						$dafneyText = "";
						$getDafney = $dbh->query($dafneyQuery);
							
						if(count($getDafney) == 1) {
							foreach($dbh->query($dafneyQuery) as $row) {
								$dafneyTitle = $row['title'];
								$dafneyText = $row['postText'];
								
							}
							
						} else {
							echo 'There was an error getting the Dafney Text.';
						}
						
						if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { 
					?>
					<script type="text/javascript">
						//Ext to update Dafney's text
						Ext.onReady(function() {
							var dafTitle = Ext.get('dafneyTitleDiv');
							var dafText = Ext.get('dafneyTextDiv');
							dafTitle.on('click', function(eventObj, elRef) {
								
								grabPage('updateDafney.php', 'dafneyTitleDiv');
								
								this.un('click');
							});

							dafText.on('click', function(eventObj, elRef) {
								
								grabPage('updateDafneyText.php', 'dafneyTextDiv');
								
								this.un('click');
							});

							
						});	
				
		
		
					</script>
					<li>
						<h2><a href="#" id="dafneyTitleDiv" style="text-decoration: none;"><?php echo $dafneyTitle; ?></a></h2>
						<img src="images/dafney.jpg" height="120" width="200" />
						<p><a href="#" id="dafneyTextDiv" style="text-decoration: none;"><?php echo $dafneyText; ?></a></p>
					</li> 
					<?php } else { ?>
						<h2><?php echo $dafneyTitle; ?></h2>
						<img src="images/dafney.jpg" height="120" width="200" />
						<p><?php echo $dafneyText; ?></p>
					<?php } ?>
					
				
					<li>
						<h2>Our Projects</h2>
						<ul>
							<li><a href="#">Building a Building</a></li>
							<li><a href="#">Raising Bitties</a></li>
							
								</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- end #sidebar -->
			<div style="clear: both;">&nbsp;</div>
		</div>
		<div id="footer">
			<p>(c) 2012 Levsdelight.com. Design by Jason</p>
		</div>
		<!-- end #footer -->
	</div>
	<!-- end #page -->
</div>
</body>
</html>