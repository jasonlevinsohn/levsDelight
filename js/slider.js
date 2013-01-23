function slider() {
				
				
				
				console.log('Counter is: ' + counter);
				
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