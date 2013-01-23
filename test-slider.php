<!DOCTYPE html>
<html>
<head>
    <title>Test Slider</title>

	<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="extjs/ext-4-0-2a/resources/css/ext-all.css">
	<style type="text/css">
		.test-box {
			border: 2px solid #000;
			width	: 250px;
			height	: 120px;
			float	: left;
		}
	
	</style>
	
	<!-- JavaScript -->
    <script src="extjs/ext-4-0-2a/ext-all-debug.js"></script>
	
	<script type="text/javascript" >
		Ext.onReady(function() {
			
			
			//Meet Animals Slideshow
			var meetDiv = Ext.get('meetAnimals');

			
		   	var meetButton = Ext.create('Ext.panel.Panel',{
				renderTo		: meetDiv,
				layout			: 'card',
				
				items			: [
					{
						id	: 'dafney',
						html	: 'Dafney'
					},
					{
						id	: 'norman',
						html	: 'Norman'
					}
				],
				tbar			: [
										{
						text	: 'Prev',
						handler: function()	{
							var ct = this.up('panel');
								layout = ct.getLayout(),
								first	= ct.getComponent(0),
								second = ct.getComponent(1),
							first.getEl().slideOut('l', {
								callback	: function() {
									layout.setActiveItem(first);
									first.hide();
									second.show();
									first.getEl().slideIn('r');
								}
							});

						}
					},
					{
						text	: 'Next',
						handler: function()	{
							var ct = this.up('panel');
								layout = ct.getLayout(),
								first	= ct.getComponent(0),
								second = ct.getComponent(1),
							first.getEl().slideOut('l', {
								callback	: function() {
									layout.setActiveItem(second);
									second.hide();
									first.show();
									second.getEl().slideIn('r');
								}
							});

						}
					}

				]	
				
							
				
				
				
		   	});	

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
			
			//testboxTwo.dom.style.display = "none";
			//testboxThree.dom.style.display = "none";
			//testboxTwo.setOpacity(0);
			//testboxThree.setOpacity(0);
			
			
				
			//boxes.push(testboxOne);
			//boxes.push(testboxTwo);
			//boxes.push(testboxThree);
			
			
			
			
			function slider() {
				
				counter = (counter+1) % boxes.length;
				
				console.log('Counter is: ' + counter);
				if (counter == 0) {
					boxes[counter].dom.style.display = "block";
					setTimeout(boxes[boxes.length-1].dom.style.display = "none", 3000);
					boxes[counter].setOpacity(1, {duration: 3000, easing: 'easeIn'});
					boxes[boxes.length-1].setOpacity(0, {duration: 3000, easing: 'easeOut'});
					
					
				} else {
					
					boxes[counter].dom.style.display = "block";
					setTimeout(boxes[counter - 1].dom.style.display = "none", 3000);
					boxes[counter-1].setOpacity(0, {duration: 3000, easing: 'easeOut'});
					boxes[counter].setOpacity(1, {duration: 3000, easing: 'easeIn'});
					
					
				}
				
				console.log('Length: ' + boxes.length);
				//counter++;
				
				
				
			}
			
			
			
			setInterval(slider, 3000);
			
			//setInterval(console.log(boxes.pop()), 20000);
			
			testboxOne.on('click', function () {
				
				slider();
				//testboxTwo.dom.style.visibility = "hidden";
				//testboxTwo.dom.style.display = "none";
				
				//console.log(testboxTwo);
				//console.log(testboxTwo.dom.style);
				
				
				
				//testboxTwo.slideOut('r');
				//testboxTwo.hide();
			});
			
			//console.log(testboxOne);
		});
	
	</script>
	
	
</head>
<body>
	Hello
	<div id="meetAnimals"> </div>
	
	<div id="testBoxOne" class="test-box">Test Box One</div>
	<div id="testBoxTwo" class="test-box">Test Box Two</div>
	<div id="testBoxThree" class="test-box">Test Box Three</div>
	
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
	

</body>
</html>