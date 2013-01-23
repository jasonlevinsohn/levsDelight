

<?php



//Get the posts 

require_once('connect.php');

$postQuery	   = "SELECT * FROM mainposts ORDER BY sortOrder DESC";



$postStatement = $dbh->query($postQuery);

?>

<?php foreach($postStatement as $post) { ?>

	<?php 
		$theDate = new DateTime($post['timestamp']);
		$formattedDate = $theDate->format('l F jS Y');
		
	?>
	
	<div class="post">
		<h2 class="title"><?php echo $post['title']; ?></h2>
		<p class="byline">posted by <?php echo $post['author'] . " on " . $formattedDate; ?></p>
		<div class="entry">
			<p>
				<?php echo $post['posttext'];
					
				 ?>
			</p>
			
			
		</div>
		<!-- These are the comments 
		<div class="meta">
			<p class="links"><a href="#" class="comments">Comments (1)</a> Natty says "These are awesome!!" <a href="http://www.levsdelight.com/january2012/" class="permalink">Full article</a></p>
		</div>
		-->
		
		
	</div>



<?php } ?>









		
	
			
