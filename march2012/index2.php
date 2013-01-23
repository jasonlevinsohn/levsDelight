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

<!-- jQuery library -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

<!-- Gallerific JavaScript-->
		<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>


<!-- JavaScript -->
	
    <script type="text/javascript" src="../extjs/ext-4-0-2a/ext-all.js"></script>
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript">
		document.write('<style>.noscript { display: none; }</style>');
	</script>
	
	<!-- CSS for jQuery Picture Gallery -->
	<link rel="stylesheet" href="css/basic.css" type="text/css" />
	<link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />


</head>
<body>

<?php
//Report all errors
error_reporting(E_ALL);

//Start the session stuff
session_start();

$title = 'Lev\'s Delight';

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

//Update Picture Title Secion
if(isset($_GET['pictureUpdateTitle'])) {
	require_once('connect.php');
	$updateText = $_GET['pictureUpdateTitle'];
	$updateId = $_GET['pictureUpdateId'];
	$updateQuery = "UPDATE slideshows SET title=? WHERE id=?";
	$updatePrep = $dbh->prepare($updateQuery);
	$updatePrep->execute(array($updateText, $updateId));
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
				<!-- <li><a href="#">Portfolio</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li> -->
			</ul>
		</div>
		<!-- end #menu -->
	</div>
	<!-- end #header-wrapper -->
	<div id="page">
		<div id="banner"><a href="#"><img src="../images/img05.jpg" alt="" /></a></div> 
		<!-- <div id="banner"><a href="#"><img src="images/nat-on-tractor.jpg" alt="" /></a></div> -->
		<div id="page-bgcontent">
			<div id="content">
				<div id="gallery" class="content">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
						
						<?php
							
							/* Loop through all the pictures in the slideshow 
							 *	- slideshowId 1 is for November
							 *  - isActive is 1 if the picture is to be shown
							 */
							require_once('connect.php');
							

							$pictureShowQuery = "SELECT * FROM slideshows WHERE slideshowid = 1 and isActive = 1 ";
							$pictureShowStatement = $dbh->query($pictureShowQuery);
							?>
							<script>
								Ext.onReady(function() {
									

								});

							</script>
							<?php
				 			foreach($pictureShowStatement as $row) {
							?>
								<!-- If we are logged in, we can change the description, otherwise no. -->
								<?php if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { ?>
									
									<script>
										//EXTJS code to update the title and description for the slideshow pictures
										/*
									Ext.onReady(function() {
											
											var captionOne = Ext.get('caption').child('pictureTitle<?php echo $row['id'] ?>');
		
											captionOne.on('mouseover', function(eventObj, elRef) {
												console.log('the id is: ' + elRef.id);
												console.log("updatePictureTitle.php?id=<?php echo $row['id'] ?>");
												//grabPage('updatePictureTitle.php?id=<?php echo $row['id'] ?>', 'caption324');
												//this.un('click');
											});

											captionOne.on('click', function(eventObj, elRef) {
												
												grabPage('updatePictureTitle.php?id=<?php echo $row['id'] ?>', elRef.id);
												this.un('click');
											});

																			
											
											
										});
									*/
									</script>

									
									<li id="liDiv<?php echo $row['id'] ?>">
						
										<a class="thumb" name="leaf" href="<?php echo $row['pictureLocation'] ?>" height="70" width="70" title="<?php echo $row['title'] ?>">
											<img src="<?php echo $row['pictureLocation'] ?>" height="75" width="75" alt="The Chicks" />
											
										</a>
										<div class="caption">
											
											<div class="download">
											
												<a href="<?php echo $row['pictureLocation'] ?>" height="299" width="500">
												Download Original</a>
											</div>
											<div id="pictureTitle<?php echo $row['id'] ?>" class="image-title"><?php echo $row['title'] ?></div>
											<div id="pictureDesc<?php echo $row['id'] ?>" class="image-desc"><?php echo $row['desc'] ?></div>
										</div>
										
									</li>

	
								<?php } else { ?> 
									<li>
										<a class="thumb" name="leaf" href="<?php echo $row['pictureLocation'] ?>" height="70" width="70" title="<?php echo $row['title'] ?>">
											<img src="<?php echo $row['pictureLocation'] ?>" height="75" width="75" alt="The Chicks" />
											
										</a>
										<div class="caption">
											<div class="download">
												<a href="<?php echo $row['pictureLocation'] ?>" height="299" width="500">Download Original</a>
											</div>
											<div class="image-title"><?php echo $row['title'] ?></div>
											<div class="image-desc"><?php echo $row['desc'] ?></div>
										</div>
									</li>
								<?php } //End if statement to checked if logged in ?>
							<?php
							}
							
						?>
						<li>
							<a class="thumb" name="leaf" href="november2011-pictures/IMAG0825.jpg" height="70" width="70" title="The Chicks">
								<img src="november2011-pictures/IMAG0825.jpg" height="75" width="75" alt="The Chicks" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="november2011-pictures/IMAG0825.jpg" height="299" width="500">Download Original</a>
								</div>
								<div class="image-title">The Chicks</div>
								<div class="image-desc">Little Baby Chicks Runnin Around</div>
							</div>
						</li><!--
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-346-m.jpg" title="Little Chicks Again">
								<img src="images/thumbs/chicks-346-t.jpg" alt="Little Chicks Again" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-346-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Little Chicks Again</div>
								<div class="image-desc">Natty holding the Biddies</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-666-m.jpg" title="All Schooched up">
								<img src="images/thumbs/chicks-666-t.jpg" alt="All Schooched up" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-666-m.jpg">Download Original</a>
								</div>
								<div class="image-title">All Schooched up</div>
								<div class="image-desc">The chicks are full.</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-667-m.jpg" title="All Schooched up">
								<img src="images/thumbs/chicks-667-t.jpg" alt="All Schooched up" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-667-m.jpg">Download Original</a>
								</div>
								<div class="image-title">All Schooched up</div>
								<div class="image-desc">Biddes loving on one another</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-670-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-670-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-670-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Big Biddy</div>
								<div class="image-desc">She grew faster than most.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-677-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-677-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-677-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Biddies Again</div>
								<div class="image-desc">Four Ducks in a Row</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-691-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-691-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-691-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Biddies Again</div>
								<div class="image-desc">Their all so tiwed</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-700-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-700-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-700-m.jpg">Download Original</a>
								</div>
								<div class="image-title">It's Beep-beep</div>
								<div class="image-desc">Little Beep-beep.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-705-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-705-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-705-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Beep-Beep Again</div>
								<div class="image-desc">She is the slowest to grow.</div>
							</div>
						</li>




						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-721-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-721-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-721-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Two Ducks in a Row</div>
								<div class="image-desc">Hello little Biddies</div>
							</div>
						</li>


						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-722-m.jpg" title="Title #0">
								<img src="images/thumbs/chicks-722-t.jpg" alt="Title #0" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-722-m.jpg">Download Original</a>
								</div>
								<div class="image-title">They so tired</div>
								<div class="image-desc">The Biddies are very tired.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-736-m.jpg" title="Jason on a Tractor">
								<img src="images/thumbs/chicks-736-t.jpg" alt="Jason on a Tractor" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-736-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Jason on a Tractor</div>
								<div class="image-desc">Oh my goodness, is he gonna make it.</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-741-m.jpg" title="Dafney">
								<img src="images/thumbs/chicks-741-t.jpg" alt="Dafney" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-741-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Dafney</div>
								<div class="image-desc">Yo, whats up!!</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-743-m.jpg" title="Dafney, Livin it up">
								<img src="images/thumbs/chicks-743-t.jpg" alt="Dafney, Livin it up" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-743-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Dafney, Livin it up</div>
								<div class="image-desc">Yo, get outa my face</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-745-m.jpg" title="Dafney rides the Tractor">
								<img src="images/thumbs/chicks-745-t.jpg" alt="Dafney rides the Tractor" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-745-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Dafney rides the Tractor</div>
								<div class="image-desc">Dafney braves herself on the Yanmar 2000</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-748-m.jpg" title="Dafney, Tractor Lover">
								<img src="images/thumbs/chicks-748-t.jpg" alt="Dafney, Tractor Lover" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-748-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Dafney, Tractor Lover</div>
								<div class="image-desc">It's a brave new world for Dafney.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-749-m.jpg" title="Natty on a Tractor">
								<img src="images/thumbs/chicks-749-t.jpg" alt="Natty on a Tractor" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-749-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Natty on a Tractor</div>
								<div class="image-desc">Plowin' some dirt</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-754-m.jpg" title="Leo and TJ for Halloween">
								<img src="images/thumbs/chicks-754-t.jpg" alt="Leo and TJ for Halloween" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-754-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Leo and TJ for Halloween</div>
								<div class="image-desc">They're all dressed up in their little costumes.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-759-m.jpg" title="Waitin for some treats.">
								<img src="images/thumbs/chicks-759-t.jpg" alt="Waitin for some treats." />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-759-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Waitin for some treats.</div>
								<div class="image-desc">Gimme a bone, women.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-765-m.jpg" title="TJ">
								<img src="images/thumbs/chicks-765-t.jpg" alt="TJ" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-765-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Bumble Bee</div>
								<div class="image-desc">Look at me, I'm a giant bumble bee!!</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-766-m.jpg" title="TJ">
								<img src="images/thumbs/chicks-766-t.jpg" alt="TJ" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-766-m.jpg">Download Original</a>
								</div>
								<div class="image-title">TJ</div>
								<div class="image-desc">Bzzzzzzzzzzzzzzzzzzz!!!!</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/chicks-769-m.jpg" title="TJ">
								<img src="images/thumbs/chicks-769-t.jpg" alt="TJ" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/chicks-769-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Leo-Lantern</div>
								<div class="image-desc">Hungry, Hungry Lantern!!</div>
							</div>
						</li>

						<li>
							<a class="thumb" name="leaf" href="images/main/leo-776-m.jpg" title="Leo is a pumpkin">
								<img src="images/thumbs/leo-776-t.jpg" alt="Leo is a pumpkin" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/leo-776-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Leo is a pumpkin</div>
								<div class="image-desc">I finally got my bone.</div>
							</div>
						</li>
						<li>
							<a class="thumb" name="leaf" href="images/main/leo-777-m.jpg" title="Leo savors his bone.">
								<img src="images/thumbs/leo-777-t.jpg" alt="Leo savors his bone." />
							</a>
							<div class="caption">
								<div class="download">
									<a href="images/main/leo-776-m.jpg">Download Original</a>
								</div>
								<div class="image-title">Leo savors his bone.</div>
								<div class="image-desc">I love me some bones.</div>
							</div>
						</li>
						-->
					</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end #content -->			
<!-- If we are logged in, we can change the description, otherwise no. -->
				<?php if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { ?>
					
						Hello there :)
				
				 <?php }  ?>

			
		
			
			<div style="clear: both;">&nbsp;</div>
		</div>
		<div id="footer">
			<p>(c) 2011 Levsdelight.com. Design by Jason</p>
		</div>
		<!-- end #footer -->
	</div>
	<!-- end #page -->
</div>
<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.navigation').css({'width' : '300px', 'float' : 'left'});
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 15,
					preloadAhead:              10,
					enableTopPager:            true,
					enableBottomPager:         true,
					maxPagesToShow:            7,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             false,
					autoStart:                 false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});
			});
		</script>
</body>
</html>
