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
<link rel="stylesheet" type="text/css" href="extjs/ext-4-0-2a/resources/css/ext-all-scoped.css">
<link href="style.css" rel="stylesheet" type="text/css" media="screen" /> 


<!--Icons CSS-->
<link href="icons.css" rel="stylesheet" type="text/css" media="screen" />
<!-- Edit Post Style -->
<link href="editPost.css" rel="stylesheet" type="text/css" media="screen" />


<!-- JavaScript -->
    <script type="text/javascript" src="extjs/ext-4-0-2a/ext-all.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
		
		//This sets the ExtJS CSS so it only applies to ext components
		//And does not mess with our other CSS rules **SWEETNESS**
		Ext.scopeResetCSS = true;
		

		Ext.onReady(function() {
			
			   
		   /*************************************************************/
		   /*********************Edit Post Button - BEGIN*****************/
		   /*************************************************************/
			
			var profileTemplate = new Ext.XTemplate(
				'<tpl for=".">',
					'<div class="proWrap" id="profile_{id}">',
						'<div class="proName">{title} - {author}</div>',
					'</div>',
				'</tpl>'
				
			);
			
		   /*************************************************************/
		   /*********************Edit Post Button - END*****************/
		   /*************************************************************/
			
			var newPostDiv = Ext.get('newPost');
           
			/*************************************************************/
			/*********************New Post Button - BEGIN*****************/
			/*************************************************************/
		   
		   var getPosts = Ext.get('content');
		   
		   //New Post Handler
		   var newPostHandler = function() {
				var newP = Ext.getCmp('newPostForm');
				console.log(newP);
				if(newP.getForm().isValid()) {
					newP.el.mask('Adding New Post', 'x-mask-loading');
					newP.getForm().submit({
						params		: {
							postType	: 'mainPost'
						},

						success	: function(form, action) {
							newP.el.unmask();
							console.log('made it here');
							newPostWin.hide();
							console.log('and here as well')
							Ext.MessageBox.show({
								title	: 'Post Added',
								msg		: action.result.message,
								buttons	: Ext.Msg.OK,
								fn		: function() {
									getPosts.load({
										url		: 'mainPosts.php',
										scripts	: true,
										params	: {
											postCount	: 3
										}
									});
								}
							});
							
							
							
							console.log('and here as well again');
						}
					});
				} else {
					Ext.MessageBox.alert('Your Post is incomplete');
				}
				
				
		   }
		   
		   //Form
		   var newPostForm = Ext.create('Ext.form.Panel', {
				id			: 'newPostForm',
				url			: 'insertUpdatePost.php',
				bodyPadding	: 10,
				defaultType	: 'textfield',
				items		: [
					{
						fieldLabel	: 'Title',
						labelWidth	: 50,
						name		: 'title',
						allowBlank	: false
					},
					{
						fieldLabel	: 'Message',
						labelWidth	: 50,
						xtype		: 'htmleditor',
						name		: 'message'
					}
				],
				buttons		: [
					{
							text	: 'Create Post',
							handler	: newPostHandler
					}
				]
				
		   
		   });
		   
		   //Window
		   var newPostWin;
		   var newPostWindow = function(btn) {
				if(!newPostWin) {
					newPostWin = Ext.create('Ext.window.Window', {
						animateTarget		: btn.el,
						closeAction		: 'hide',
						title			: 'New Post',
						id			: 'newPostWindow',
						height			: 270,
						width			: 680,
						constrain		: true,
						items			: [
							newPostForm
						]
					
					});
				}
				newPostWin.show();
		   
		   }
		   
		   
		   //Button
		   var newPostButton = Ext.create('Ext.Button',{
				renderTo	: newPostDiv,
				iconCls		: 'icon-add',
				text 		: 'New Post',
				
				handler		: newPostWindow
		   });
		   
		   
		   /*************************************************************/
		   /*********************New Post Button - END*****************/
		   /*************************************************************/
			
			
			//This loads the Posts using AJAX
			getPosts.load({
				url		: 'mainPosts.php',
				scripts	: true,
				params	: {
					postCount	: 3
				}
				
			});
			
			
		
		});
		
		
		
	</script>
</head>
<body class="levsClass">

<?php
//Report all errors
error_reporting(E_ALL);

//Start the session stuff
//session_start();

//Connect to the database
require_once('connect.php');


$title = 'Lev\'s Delight';


//Is the browser an iPad?
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');

$browser = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$currentTime = date("Y-m-d : H:i:s", time());




//Log when the site is visited
$logQuery = "insert into log(browser, ip, currentTime) VALUES (?, ?, ?)";
$logStatement = $dbh->prepare($logQuery);
$logStatement->execute(array($browser, $ip, $currentTime));




if(isset($_POST['userInput']) && isset($_POST['passInput'])) {
	
	//connect to the database
	require_once('connect.php');
	$login = $_POST['userInput'];
	$pass = md5($_POST['passInput']);
	$qry = "SELECT * FROM users where user = '$login' AND pass = '$pass'";
	
	$statement = $dbh->query($qry);
	
	
	if(count($statement) == 1) {
		foreach($dbh->query($qry) as $row) {
			
			//session_regenerate_id();
			$_SESSION['SESS_MEMBER_ID'] = $row['id'];
			$_SESSION['SESS_FIRST_NAME'] = $row['firstName'];
			
		}
	}
	
	
} else if(isset($_POST['loginSubmit']) && $_GET['loginSubmit'] == 'logout') {
	session_unset();
	session_destroy();
}

//Update Dafney Title Section
if(isset($_POST['dafneyUpdateText'])) {
	require_once('connect.php');
	$updateText = $_POST['dafneyUpdateText'];
	$updateQuery = "UPDATE frontpageposts SET title=? WHERE id=?";
	$updatePrep = $dbh->prepare($updateQuery);
	$updatePrep->execute(array($updateText, 1));
	
	
}

//Update Dafney Title Section
if(isset($_POST['dafneyUpdatePostText'])) {
	require_once('connect.php');
	$updateText = $_POST['dafneyUpdatePostText'];
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
					
					<form name="logout" id="logout" method="POST" action="indexLivePost.php">
						<?php echo 'hello, ' . $_SESSION['SESS_FIRST_NAME'];?>
						<input type="submit" name="loginSubmit" id="loginSubmit" value="logout" />
					</form>
					<div id="newPost" style="float: right;margin-top: 5px;"></div>

				</div>
				

			<?php } else { ?>	
				<div id="login">
					<form name="login" id="login" method="POST" action="indexLivePost.php">
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
				<form method="post" action="">
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
