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
<meta name="description" content="Our petting zoo hobby farm in Villa Rica, GA is rich with life.  Home to two chilain llamas, eight various breeds of chickens, a flemish giant bunny rabbit, a pot-belly pig, and one sulcata tortiose." />
<link rel="stylesheet" type="text/css" href="extjs/ext-4-0-2a/resources/css/ext-all-scoped.css">
<link href="style.css" rel="stylesheet" type="text/css" media="screen" /> 
<link href="css/snow.css" rel="stylesheet" type="text/css"/>

<!--Icons CSS-->
<link href="icons.css" rel="stylesheet" type="text/css" media="screen" />
<!-- Edit Post Style -->
<link href="editPost.css" rel="stylesheet" type="text/css" media="screen" />


<!-- jQuery library -->
		           <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>

<!-- JavaScript -->
    <script type="text/javascript" src="extjs/ext-4-0-2a/ext-all.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/jquery-ninja.js"></script>
<!--        <script type="text/javascript" src="js/snow.js"></script> -->
	<script type="text/javascript">
		

		Ext.onReady(function() {
		$('#menu').load('page-pieces/navigation-block.html');
            $('#sidebar-menu').load('page-pieces/sidebar-menu.html');
		});
		//This sets the ExtJS CSS so it only applies to ext components
		//And does not mess with our other CSS rules **SWEETNESS**
		Ext.scopeResetCSS = true;
		
		//Required Classes
		Ext.require([
			'Ext.data.*',
			'Ext.tip.QuickTipManager',
			'Ext.window.MessageBox'
		]);
		
		//Edit Task Model
		Ext.define('editPostModel', {
			extend	: 'Ext.data.Model',
			fields	: [
				{
					name	: 'id',
					type	: 'int',
					useNull	: true
				},
				'title',
				'author',
				'posttext'
			],
			validations	: [
				{
					type	: 'length',
					field	: 'title',
					min		: 1
				}
			]
		});

		Ext.onReady(function() {
			
			function slider() {
				
				
				
				
				
				var aniOutConfigOne = {
					easing		: 'easeOut',
					duration	: 1000,
					callback	: function() {
						
						counter = (counter+1) % boxes.length;
						
						boxes[counter-1].dom.style.display = "none";
						boxes[counter].dom.style.display = "block";
						boxes[counter].setOpacity(1, {duration: 1000, easing: 'easeIn'});
					}
				};
				
				var aniOutConfigTwo = {
					easing		: 'easeOut',
					duration	: 1000,
					callback	: function() {
						counter = 0;
						boxes[boxes.length-1].dom.style.display = "none";
						boxes[counter].dom.style.display = "block";
						boxes[counter].setOpacity(1, {duration: 1000, easing: 'easeIn'});
					}
				};
				
				
				if (counter == boxes.length-1) {
					boxes[boxes.length-1].setOpacity(0, aniOutConfigTwo);

				} else {
					boxes[counter].setOpacity(0, aniOutConfigOne);
	
				}

			}
			
			setInterval(slider, 9000);
			
			
			var counter = 0;
			
				var boxes = new Array();
				
				<?php 
				require_once('connect.php');
		
				$slideQuery = "select id from meets";
				$slideStatement = $dbh->query($slideQuery);
		
				foreach($slideStatement as $slide) { ?>
			
					var meet<?php echo $slide['id']; ?> = Ext.get("meet<?php echo $slide['id']; ?>");
					
						<?php if($slide['id'] != 1) { ?>
							meet<?php echo $slide['id']; ?>.dom.style.display="none";
							meet<?php echo $slide['id']; ?>.setOpacity(0);
						<?php } ?>
					
					boxes.push(meet<?php echo $slide['id']; ?>);
				<?php } ?>

			
			//Display posts with Ajax
			var getPosts = Ext.get('content');
			   
		   /*************************************************************/
		   /*********************Edit Post Button - BEGIN*****************/
		   /*************************************************************/
			
			var editPostDiv = Ext.get('editPost');
			
			//Edit Post Template
			var editPostTemplate = new Ext.XTemplate(
				'<tpl for=".">',
					'<div class="proWrap" id="profile_{id}">',
						'<div class="proName">{title} - {author}</div>',
					'</div>',
				'</tpl>'
				
			);
			
			//Edit Post Data Store
			var editPostStore = Ext.create('Ext.data.Store', {
				model	: 'editPostModel',
				storeId	: 'editPostStore',
				autoLoad: true,
				proxy	: {
					type	: 'ajax',
					api		: {
						read	: 'jsonEditPostRead.php',
						create	: 'jsonEditPostCreate.php',
						update	: 'jsonEditPostUpdate.php',
						destroy	: 'jsonEditPostDestroy.php'
					},
					reader	: {
						type			: 'json',
						successProperty	: 'success',
						root			: 'editPostRoot',
						messageProperty	: 'message',
						totalProperty	: 'totalCount'
					}
				}
			});
			
			var editPostForm = Ext.create('Ext.form.Panel', {
				id			: 'editPostForm',
				title		: 'Update Post',
				labelWidth	: 50,
				url			: 'insertUpdatePost.php',
				frame		: true,
				width		: 500,
				height		: 200,
				items		: [
					{
						xtype		: 'fieldset',
						columnWidth	: 100,
						title		: 'Post Information',
						defaultType	: 'textfield',
						items		: [
							{
								fieldLabel	: 'Title',
								name		: 'title',
							},
							{
								xtype		: 'htmleditor',
								fieldLabel	: 'Message',
								name		: 'posttext'
							},
							{
								xtype		: 'hidden',
								name		: 'id',
								
							},
							{
								xtype		:'hidden',
								name		:'author'
							}
						]
					}
				],
				buttons		: [
					{
						text	: 'Update',
						handler	: function() {
							var thisForm = this.up('form');
							var modelInstance = thisForm.getRecord();
							var postId = modelInstance.get('id');
							thisForm.el.mask('Updating', 'x-mask-loading');
							thisForm.getForm().submit({
								params	: {
									postType	: 'updateMainPost'
								},
								success : function(form, action) {
									thisForm.el.unmask();
									thisForm.hide();
									thisForm.getForm().reset();
									Ext.MessageBox.show({
										title	: 'Post Updated',
										msg		: action.result.message,
										buttons	: Ext.Msg.OK,
										icon  		: Ext.MessageBox.INFO,
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
								},
								failure : function(form, action) {
									thisForm.el.unmask();
									Ext.MessageBox.show({
										title	: 'Error Updating',
										msg		: action.result.message,
										buttons	: Ext.Msg.OK,
										icon  		: Ext.MessageBox.ERROR,
										
									});
								}
							});
						}
					}
				]
				
			
			}).hide();
			
			//Edit Post Data View
			var editPostDataView = new Ext.create('Ext.view.View', {
				tpl				: editPostTemplate,
				store			: editPostStore,
				singleSelect	: true,
				trackOver		: true,
				itemSelector	: 'div.proWrap',
				selectedItemCls	: 'proSelected',
				overItemCls		: 'proOver',
				style			: 'overflow:auto; background-color: #FFFFFF;',
				listeners		: {
					itemclick	: function(thisView, theModel, theItem, index) {
						var model   = thisView.getStore().getAt(index);
						var theForm = Ext.getCmp('editPostForm');
						theForm.show();
						theForm.getForm().loadRecord(model);
					}
				}
			});
			
			
			
			//Edit Post Window
		   var editPostWin;
		   var editPostWindow = function(btn) {
				if(!editPostWin) {
					editPostWin = Ext.create('Ext.window.Window', {
						animateTarget		: btn.el,
						closeAction		: 'hide',
						title			: 'Edit Posts',
						id			: 'editPostWindow',
						height			: 400,
						width			: 600,
						constrain		: true,
						items			: [
							editPostDataView,
							editPostForm
						]
					
					});
				}
				editPostWin.show();
		   
		   }
			
		   //Edit Post Button
		   var editPostButton = Ext.create('Ext.Button',{
				renderTo	: editPostDiv,
				iconCls		: 'icon-email_edit',
				text 		: 'Edit Post',
				
				handler		: editPostWindow
		   });
			
		   /*************************************************************/
		   /*********************Edit Post Button - END*****************/
		   /*************************************************************/
			
			
           
			/*************************************************************/
			/*********************New Post Button - BEGIN*****************/
			/*************************************************************/
		   
		   
		   
		   var newPostDiv = Ext.get('newPost');
		   
		   //New Post Handler
		   var newPostHandler = function() {
				var newP = Ext.getCmp('newPostForm');
				
				if(newP.getForm().isValid()) {
					newP.el.mask('Adding New Post', 'x-mask-loading');
					newP.getForm().submit({
						params		: {
							postType	: 'mainPost'
						},

						success	: function(form, action) {
							newP.el.unmask();

							newPostWin.hide();

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
									newP.getForm().reset();
								}
							});
							
							
							
							
							
						},
						failure : function(form, action) {
									thisForm.el.unmask();
									Ext.MessageBox.show({
										title	: 'Error Updating',
										msg		: action.result.message,
										buttons	: Ext.Msg.OK,
										icon  		: Ext.MessageBox.ERROR,
										
									});
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
						name		: 'title',
						labelWidth	: 50,
						allowBlank	: false
					},
					{
						fieldLabel	: 'Message',
						labelWidth	: 50,
						xtype		: 'htmleditor',
						name		: 'posttext'
					},
					{
						xtype		: 'hidden',
						name		: 'author',
						value		: 'Natalie'
					}
				],
				buttons		: [
					{
							text	: 'Create Post',
							handler	: newPostHandler
					}
				]
				
		   
		   });
		   
		   //New Post Window
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
		   
		   
		   //New Post Button
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
@error_reporting(E_ALL);

//Start the session stuff
@session_start();

//Connect to the database
require_once('connect.php');


$title = 'Lev\'s Delight';


//Is the browser an iPad?
$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');

$browserAgent = $_SERVER['HTTP_USER_AGENT'];
$ipAddress = $_SERVER['REMOTE_ADDR'];
$currentTime = date("Y-m-d : H:i:s", time());

//Email when the site is visited
$browser = get_browser(null, true);

//Send an email when someone comes along
$to = "jason.levinsohn@gmail.com";
$subject = "LEVS DELIGHT - Visitor";
$message = "" .
		"Someone is checking out the Levs Delight Web Site at: <b>" . $_SERVER['REMOTE_ADDR'] . "</b> <br />" .
		"They are using the <b>" . $browser['browser'] . "</b> browser on the <b>" . $browser['platform'] . " </b> platform<br />";
	
$header = 'From: jlev711@gmail.com' . "\r\n" .
	'Reply-To: jlev711@gmail.com' . "\r\n" .
	'Content-Type: text/html';
	

if(mail($to, $subject, $message, $header)) {

} else {
	echo 'Less Amesome';
}




//Log when the site is visited
$logQuery = "insert into log(browserAgent, ipAddress, currentTime) VALUES (?, ?, ?)";
$logStatement = $dbh->prepare($logQuery);
$logStatement->execute(array($browserAgent, $ipAddress, $currentTime));



//Login Section
if(isset($_POST['userInput']) && isset($_POST['passInput'])) {
	
	//connect to the database
	require_once('connect.php');
	$login = $_POST['userInput'];
	$pass = md5($_POST['passInput']);
	$qry = "SELECT * FROM users where user = '$login' AND pass = '$pass'";
	
	$statement = $dbh->query($qry);
	
	
	if(count($statement) == 1) {
		foreach($dbh->query($qry) as $row) {
			
			@session_regenerate_id();
			$_SESSION['SESS_MEMBER_ID'] = $row['id'];
			$_SESSION['SESS_FIRST_NAME'] = $row['firstName'];
			
		}
	}
	
	
} else if(isset($_POST['loginSubmit']) && $_POST['loginSubmit'] == 'logout') {
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
					
					<form name="logout" id="logout" method="POST" action="index.php">
						<?php echo 'hello, ' . $_SESSION['SESS_FIRST_NAME'];?>
						<input type="submit" name="loginSubmit" id="loginSubmit" value="logout" />
					</form>
					<div id="newPost" style="float: right; margin-top: 5px;"></div>
					<div id="editPost" style="float: right; margin-top: 5px;"></div>

				</div>
				

			<?php } else { ?>	
				<div id="login">
					<form name="login" id="login" method="POST" action="index.php">
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
						
						
					?>
					<script type="text/javascript">
						//Ext to update Dafney's text
						Ext.onReady(function() {
							var dafTitle = Ext.get('dafneyTitleDiv');
							var dafText = Ext.get('dafneyTextDiv');
							

														var counter = 0;
			
							var boxes = new Array();
							<?php 
							require_once('connect.php');
					
							$slideQuery = "select id from meets";
							$slideStatement = $dbh->query($slideQuery);
					
							foreach($slideStatement as $slide) { ?>
						
								var meet<?php echo $slide['id']; ?> = Ext.get("meet<?php echo $slide['id']; ?>");
								
									<?php if($slide['id'] != 0) { ?>
										meet<?php echo $slide['id']; ?>.dom.style.display="none";
										meet<?php echo $slide['id']; ?>.setOpacity(0);
									<?php } ?>
								
								boxes.push(meet<?php echo $slide['id']; ?>);
							<?php } ?>

							
						});	
				
	                    var _gaq = _gaq || [];
                        _gaq.push(['_setAccount', 'UA-37351819-1']);
                        _gaq.push(['_trackPageview']);

                        (function() {
                            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                        })();
	
		
					</script>
					
						
						
						<?php 
							require_once('connect.php');
		
							$meetQuery = "select * from meets";
							$meetStatement = $dbh->query($meetQuery);
		
							foreach($meetStatement as $meet) { ?>
								<div id="meet<?php echo $meet['id']; ?>">
									<h2><?php echo $meet['title'];  ?></h2>
									<img src="images/<?php echo $meet['imagepath']; ?>" height="120" width="200" />
									<p><?php echo $meet['description']; ?> </p>
								</div>
						<?php } ?>
					
					<div id="sidebar-menu"></div>
				
					
				</ul>
			</div>
			<!-- end #sidebar -->
			<div style="clear: both;">&nbsp;</div>
		</div>
		<div id="footer">
			<p>(c) 2013 Levsdelight.com. Design by Jason</p>
		</div>
		<!-- end #footer -->
	</div>
	<!-- end #page -->
</div>
</body>
</html>
