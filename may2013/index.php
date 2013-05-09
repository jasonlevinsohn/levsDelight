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
<title>May 2013 Pictures - LevsDelight</title>
<meta name="keywords" content="May 2013 pictures, villa rica farm, llamas, petting zoo, pot-belly pig, donkey" />
<meta name="description" content="Natty and Jason's Petting Zoo with Llamas, chickens, pot-belly pigs, and a donkey." />
<!-- <link rel="stylesheet" type="text/css" href="extjs/ext-4-0-2a/resources/css/ext-standard.css"> -->
<link href="../css/style.css" rel="stylesheet" type="text/css" media="screen" /> 
<!-- Snow Layer  -->
<!-- <link href="../css/snow.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">


/* Resize the slideshow images to fit */
#slideshow img {
    width: 500px;
    height: 299px;

    /* This creates duration for image scaling on hover */
    -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
}

#slideshow img:hover {
  -webkit-transform: scale(1.7);
     -moz-transform: scale(1.7);
      -ms-transform: scale(1.7);
       -o-transform: scale(1.7);
          transform: scale(1.7);
          z-index: 100;

  /* This fixes the problem in Webkit where the thumbnail images */
  /* show through when scaling on a hover event */
  -webkit-backface-visibility: hidden;
  position: relative;
}

<?php
//Is the browser FireFox?
$isFireFox = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox');
?>

#contactus {
    <?php if ($isFireFox) {?>
        position:     relative;
        left:         -10px;
        /* left:         -10px; */
        top:          18px;
        float:        right;
        font-size:    20px;
        font-weight:  bold;
        color:        white;
    <?php } else {  ?>
        position:     absolute;
        left:         660px;
        /* left:         -10px; */
        top:          48px;
        font-size:    20px;
        font-weight:  bold;
        color:        white;
    <?php } ?>

    
}    
#contactus a {
    text-decoration: none;
}
#search {
    display: none;
}
</style>

<?php
//**********************************************************************************************
//**************************Change Variables here for each seperate slideshow*******************
//**********************************************************************************************
$slideshowId = "23"; //This is the id number for this slideshow.  Each one must be unique.  Also used to upload images
$folderName = "may2013" //Used for image upload.  Must be the folder name of the slideshow
//#####################DON'T FORGET TO ADD AN ENTRY TO THE monthMap TABLE#########################
//#####################ALSO MAKE SURE AND MAKE SLIDESHOW PICTURES FOLDER CHMOD 777################

?>

<!-- CSS for Twitter Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
	
<!-- CSS for jQuery Picture Gallery -->
	<link rel="stylesheet" href="css/basic.css" type="text/css" />
	<link rel="stylesheet" href="css/contactusmodal.css" type="text/css" />
    <link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />

<!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Gallerific JavaScript-->
	<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
    <script type="text/javascript" src="js/jquery.opacityrollover.js"></script>

<!-- Twitter Bootstrap -->
    <script type="text/javascript" src="../js/bootstrap.js"></script>


<!-- JavaScript -->
	
    <script type="text/javascript" src="../extjs/ext-4-0-2a/ext-all.js"></script>
    <script type="text/javascript" src="../js/ajax.js"></script>
    <script type="text/javascript" src="../js/addingFiles.js"></script>
    <!-- Snow Layer -->
	<!-- <script type="text/javascript" src="../js/snow.js"></script> -->
	<script type="text/javascript">
		document.write('<style>.noscript { display: none; }</style>');
    </script>


<body>


<?php
//Report all errors
error_reporting(E_ALL);

//Start the session stuff
session_start();

//*********************************************************
//**************** Analytics Section - BEGIN***************
//*********************************************************


//Is the browser an iPad?
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');

$browserAgent = $_SERVER['HTTP_USER_AGENT'];
$ipAddress = $_SERVER['REMOTE_ADDR'];
$currentTime = date("Y-m-d : H:i:s", time());

error_log("The current time is");
$thisTime = date("Y-m-d H:i:s");
error_log($thisTime);

//Email when the site is visited
$browser = get_browser(null, true);

//Send an email when someone comes along
$to = "jason.levinsohn@gmail.com";
$subject = "LEVS DELIGHT - February 2013 Visitor";
$message = "" .
		"Someone is checking out the Levs Delight Web Site at: <b>" . $_SERVER['REMOTE_ADDR'] . "</b> <br />" .
		"They are using the <b>" . $browser['browser'] . "</b> browser on the <b>" . $browser['platform'] . " </b> platform<br />";
	
$header = 'From: jlev711@gmail.com' . "\r\n" .
	'Reply-To: jlev711@gmail.com' . "\r\n" .
	'Content-Type: text/html';
	

if(mail($to, $subject, $message)) {
    error_log("Mail being sent from: " . $header);
    error_log("to: " . $to . " subject:  " . $message);
    error_log("Subject: " . $subject);

} else {
    echo 'Less Amesome';
    error_log("Error Sending Mail");
}

//*********************************************************
//**************** Analytics Section - END*****************
//*********************************************************





$title = 'Lev\'s Delight';

if(isset($_POST['userInput']) && isset($_POST['passInput'])) {
	
	//connect to the database
	require_once('../connect.php');
	
	
	$login = $_POST['userInput'];
	$pass = md5($_POST['passInput']);
	$qry = "SELECT * FROM users where user = '$login' AND pass = '$pass'";
	
	$statement = $dbh->query($qry);
	
	
	if(count($statement) == 1) {
		foreach($dbh->query($qry) as $row) {
			
			session_regenerate_id();
			$_SESSION['SESS_MEMBER_ID'] = $row['id'];
			$_SESSION['SESS_FIRST_NAME'] = $row['firstName'];
			
		}
	}
	
	
} else if(isset($_POST['loginSubmit']) && $_POST['loginSubmit'] == 'logout') {
	session_unset();
	session_destroy();
}

//Update Picture Title Secion
if(isset($_GET['numberOfPicsToUpdate'])) {
	$theCounter = $_GET['numberOfPicsToUpdate'];
	//**************Use this for testing Title and Description update problems******************
	//echo $_GET['numberOfPicsToUpdate'] .  ' update(s) should occur';
	require_once('../connect.php');
	for($i = 1; $i < $theCounter + 1; $i++) {
		$updateId = $_GET['pictureId' . $i];		
		//**************Use this for testing Title and Description update problems******************
		//echo "< /br>Picture ID: " . $updateId;
		// $updateTitle = mysql_real_escape_string($_GET['pictureTitle' . $i]);
		// $updateDesc = mysql_real_escape_string($_GET['pictureDesc' . $i]);
		$updateTitle = $_GET['pictureTitle' . $i];
		$updateDesc = $_GET['pictureDesc' . $i];
		
		//**************Use this for testing Title and Description update problems******************

		//echo "is picture " . $i . " active ?";
		if(isset($_GET['pictureActive' . $i])) {
			$isActive = 1;
			//echo "yes";
		} else {
			$isActive = 0;
			//echo "no";
		}

		
		//$updateQuery = "UPDATE `slideshows` SET `title`=?, `desc`=? WHERE id=?";
		$updateQuery = "UPDATE `slideshows` SET `title`=?, `desc`=?, isActive=? WHERE id=?";

		$updatePrep = $dbh->prepare($updateQuery);
		$updatePrep->execute(array($updateTitle, $updateDesc, $isActive, $updateId)) or die('Error executing the update');
	}

}




?>
<!-- Snow Layer Canvas -->
<!-- <canvas id="canvas"></canvas> -->
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
					
					<form name="logout" id="logout" method="post" action="index.php">
						<?php echo 'hello, ' . $_SESSION['SESS_FIRST_NAME'];?>
						<input type="submit" name="loginSubmit" id="loginSubmit" value="logout" />
					</form>
				</div>
			<?php } else { ?>	
				<div id="login">
					<form name="login" id="login" method="post" action="index.php">
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
            
            <!-- NEW TWITTER BOOTSTAP MODAL BOX FOR CONTACT US SECTION - BEGIN -->

            <!-- Button to Trigger Modal Box -->
            <div id="contactus">
            <a href="http://www.levsdelight.com/index.php">View our Latest Post</a><span> | </span>
            <a href="#contactUsModal" role="button" class="btn" data-toggle="modal" title="Whats on your mind?" alt="Contact Us">Contact Us Here!</a>
            </div>

            <!-- Modal -->
            <!-- TO ACTIVATE THE MODAL REPLACE # WITH contactUsModal> -->

            <div id="contactUsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="contactUsModalLabel" aria-hidden="true">
   <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <!-- <h3 id="contactUsModalLabel">Whats Up?</h3> -->
                </div>
                <div class="modal-body">
<form class="contact_form" action="" method="post" name="contact_form">
<ul>
    <li>
        <h2>Whats Up? </h2>
        <span class="required_notification">* Denotes Required Field</span>
    </li>
    <li>
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="Your Name" required pattern="^.{2,}$"/>
    </li>
    <li>
        <label for="email">Email: </label>
        <input type="email" name="email" required placeholder="yourname@example.com" />
        <!-- <span class="form_hint">Proper format "name@something.com"</span> -->
    </li>
    <li>
        <label for="message">Message: </label>
        <textarea name="message" required cols="40" rows="6" pattern="^.{5,}$"placeholder="What do you want to talk about?"></textarea>
    </li>
    <li>
        <button class="submit" type="submit">Send Message</button>
    </li>
</ul>
</form>
                </div>
                <div class="modal-footer">
                </div>

            </div>
            
        <!-- NEW TWITTER BOOTSTAP MODAL BOX FOR CONTACT US SECTION - END -->
            
			<!-- end #logo -->
		</div>
		<!-- end #header -->
		<div id="menu">
			<!-- ***************************************************************************************** -->
			<!-- ***************************Replace Links to Slideshows here****************************** -->
			<!-- ***************************************************************************************** -->
			
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#menu').load('../page-pieces/navigation-block.html');
                
                $('.contact_form').submit(function(form) {
                    
                    var contact = form.currentTarget;
                    var name = contact.name.value;
                    var email = contact.email.value;
                    var message = contact.message.value;

                    $.ajax({
                        type: 'POST',
                        url: 'contactusPost.php',
                        data: {
                            'name': name,
                            'email': email,
                            'message': message
                        },
                        success: function(data) {
                            var parsed = JSON.parse(data);
                            
                            var replyMessage = "<h2>Hey, " + parsed.name + "</h2><br />Great Talk. ";
                            replyMessage += "We will get back with you ASAP.  Have a good one. <br /><br />";
                            replyMessage += "<button type='button' class='submit' data-dismiss='modal' aria-hidden='true'>Close</button>";
                            
                            $('.modal-body').html(replyMessage); 
                            $('.modal-header').remove();

                        },
                        failure: function(data) {
                            var replyMessage = "<h2>Sorry!!</h2><br />";
                            replyMessage += "There must be something wrong with our system.  Please try again. <br /><br />";
                            replyMessage += "<button type='button' class='submit' data-dismiss='modal' aria-hidden='true'>Close</button>";
                            
                            $('.modal-body').html(replyMessage); 
                            $('#contactUsModal').removeClass('modal-header');

                        }

                    });

                    
                    form.preventDefault();
                });
			});
		</script>
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
							 *	- slideshowId 2 is for february
							 *  - isActive is 1 if the picture is to be shown
							 */
							require_once('../connect.php');
							
							//***************************CHANGE SLIDESHOWID HERE TO REFLECT THIS SLIDESHOW************************
							$pictureShowQuery = "SELECT * FROM slideshows WHERE slideshowid = $slideshowId and isActive = 1 ORDER BY `order` ASC";
							$pictureShowStatement = $dbh->query($pictureShowQuery);
							?>
													<?php
				 			foreach($pictureShowStatement as $row) {
							?>
								<!-- If we are logged in, we can change the description, otherwise no. -->
								<?php if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { ?>
									
									
									
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
						
					</ul>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end #content -->			
				
				<!-- If we are logged in, we can add image files and change the description, otherwise no. -->
				<?php if(isset($_SESSION['SESS_MEMBER_ID']) && isset($_SESSION['SESS_FIRST_NAME'])) { ?>
				
					<!-- Add New Image Files here -->
					<div id="noPicsSpacerDiv" style="height: 632px; width: 850px; border: 1px solid #000"></div>
					
					
					<div style="margin-top: 50px; font-size: 20pt;">Add Images:</div>
					<div id="dropbox">
						<div id="dropzone">
							<span id="droplabel">Drop files here...</span>
						</div>
					</div>
					<button name="uploadFiles" id="uploadFiles" onClick="javascript:ajaxLoader2('<?php echo $folderName; ?>', '<?php echo $slideshowId; ?>');">Upload Files</button>
					<script>
						var reader;
						window.files = [];
						window.imagePath = [];
						console.log(window.files);
						var dropBox = document.getElementById('dropbox');
						dropBox.addEventListener('dragover', handleDragOver, false);
						dropBox.addEventListener('drop', handleFileSelect, false);
						dropBox.addEventListener('change', handleFileSelect, false);
					</script>

					<!-- Update the Description here -->
				<?php							 
					echo "<div>Update the Descriptions for the pictures here: </div><br />  ";
					
					
					//***************************CHANGE SLIDESHOWID HERE TO REFLECT THIS SLIDESHOW************************
					$pictureShowQueryTwo = "SELECT * FROM slideshows WHERE slideshowid = $slideshowId ORDER BY `order` ASC ";
					
					$pictureShowStatementTwo = $dbh->query($pictureShowQueryTwo); 
					$pictureShowCountStatement = $dbh->query($pictureShowQueryTwo); 
					//Get a count for the sortOrder
					$sortCount = 0;
					foreach($pictureShowCountStatement as $count){
						$sortCount++;
					}
					
					$counter = 0;
					?>
					<form method="get" name="updateDafneyForm" id="updateDafneyForm" action="index.php" >
					<?php foreach($pictureShowStatementTwo as $row) { 
							$counter++;
					?>
					<div id="updateDesc<?php echo $counter; ?>" style="border: 1px solid #000; margin-bottom: 20px;">
						<h3><?php echo $counter . '.)' ?> </h3>
						<img src="<?php echo $row['pictureLocation']; ?>" width="100" height="100" />
						<input type="text" id="pictureTitle<?php echo $counter; ?>" name="pictureTitle<?php echo $counter; ?>" value="<?php echo $row['title']; ?>" />
						<input type="text" id="pictureDesc<?php echo $counter; ?>" name="pictureDesc<?php echo $counter; ?>" value="<?php echo $row['desc']; ?>" />
						<?php
							if($row['isActive'] == 1) {
								$checkYes = 'checked="yes"';
							} else {
								$checkYes = '';
							}
						?>
						IsActive? <input type="checkbox" id="pictureActive<?php echo $counter; ?>" name="pictureActive<?php echo $counter; ?>" value="<?php echo $row['isActive']; ?>" <?php echo $checkYes; ?>  />
						
						<!-- Sort Order Section - Updated 07.31.2012 -->
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								//Change the sort order in the database when the select drop down is changed
								$("#sortOrder<?php echo $counter; ?>").change(function(){
									
									var valueOfId = $("#sortOrder<?php echo $counter; ?>").val();
									
									
									$("#sortUpdateWaiting<?php echo $counter; ?>").show(500);
									$("#sortUpdateMessage<?php echo $counter; ?>").hide(0);
									//Load the new sort Order into the database
									$.ajax({
										type	: 'POST',
										url		: 'updateSortOrder.php',
										datatype: 'json',
										data	: {
											oldOrder	: '<?php echo $row['order']; ?>',
											newOrder	: $("#sortOrder<?php echo $counter; ?>").val(),
											recordId	: '<?php echo $row['id']; ?>',
											slideshowId	: '<?php echo $row['slideshowid'] ?>'
										},
										success	: function(data) {
											$("#sortUpdateWaiting<?php echo $counter; ?>").hide(500);
											
											//$("#sortUpdateMessage").removeClass().addClass((data.error === true) ? 'sortError' : 'sortSuccess').text(data.message).show(500);
											$("#sortUpdateMessage<?php echo $counter; ?>").removeClass().addClass((data.error === true) ? 'sortError' : 'sortSuccess');
											$("#sortUpdateMessage<?php echo $counter; ?>").show(500);
											
											
											
											var json = jQuery.parseJSON(data);
											$("#sortUpdateMessage<?php echo $counter; ?>").html(json.message);
											
											
											
										},
										error	: function(XMLHttpRequest, textStatus, errorThrown) {
											$("#sortUpdateWaiting<?php echo $counter; ?>").hide(500);
											$("#sortUpdateMessage<?php echo $counter; ?>").removeClass().addClass("sortError").text("There was an error.").show(500);
										}
										
									});
									return false;
									
								});
									
									
								
							});
						</script>
						Sort Order: <select id="sortOrder<?php echo $counter; ?>">
										<?php for($c = 1;$c <= $sortCount; $c++){ 
											if($c == $row['order']) { ?>
												<option value="<?php echo $c?>" selected><?php echo $c; ?></option>
											<?php } else { ?>
												<option value="<?php echo $c;?>"><?php echo $c; ?></option>
											<?php } //End IF statement to check for Selected sort Order?>
										<?php } //End FOR statement to generate SELECT tag for all sort orders?>
											
										
							
									</select>
									<div id="sortUpdateWaiting<?php echo $counter; ?>" class="sortMessage">Sorting...</div>
									<div id="sortUpdateMessage<?php echo $counter; ?>" class="sortMessage"></div>
						
						<input type="hidden" id="pictureId<?php echo $counter; ?>" name="pictureId<?php echo $counter; ?>" value="<?php echo $row['id']; ?>" /> 
					</div>
					<?php } ?>
						<input type="hidden" id="numberOfPicsToUpdate" name="numberOfPicsToUpdate" value=<?php echo $counter; ?> />
						
						<input type="submit" value="Update Pics" />
					</form>	
				 <?php }  ?>

			
		
			
			<div style="clear: both;">&nbsp;</div>
		</div>
		<div id="footer">
			<p>(c) 2013 Levsdelight.com. Design by Jason</p>
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
					delay:                     5500,
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
					autoStart:                 true,
					syncTransitions:           true,
					defaultTransitionDuration: 1900,
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

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37351819-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>