
function ajaxLoader() {
	//console.log(reader.result);
	


	var ajax = new XMLHttpRequest();
	ajax.open("POST", "../server/uploadFile.php", true);
	ajax.setRequestHeader('Content-type', 'application/upload');
	ajax.setRequestHeader('uploadfilename', window.files[0][0].name);
	ajax.setRequestHeader('uploadfilesize', window.files[0][0].size);
	ajax.setRequestHeader('uploadfiletype', window.files[0][0].type);
	
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200){
			//alert(ajax.responseText);
			//alert('what is going on');
			console.log('Picture has been loaded');
			//alert('Picture has been loaded');
			location.reload(true);
		} 
		console.log('Ready State: ' + ajax.readyState + ' Status: ' + ajax.status)
	}
	
	ajax.send(reader.result);
	
}

function ajaxLoader2(folderName, slideshowId) {
	//console.log(reader.result);
	


	var ajax = new XMLHttpRequest();
	ajax.open("POST", "../server/uploadFile2.php", true);
	ajax.setRequestHeader('Content-type', 'application/upload');
	ajax.setRequestHeader('uploadfilename', window.files[0][0].name);
	ajax.setRequestHeader('uploadfilesize', window.files[0][0].size);
	ajax.setRequestHeader('uploadfiletype', window.files[0][0].type);
	ajax.setRequestHeader('folderName', folderName);
	ajax.setRequestHeader('slideshowId', slideshowId);
	
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200){
			//alert(ajax.responseText);
			//alert('what is going on');
			console.log('Picture has been loaded');
			//alert('Picture has been loaded');
			location.reload(true);
		} 
		console.log('Ready State: ' + ajax.readyState + ' Status: ' + ajax.status)
	}
	
	ajax.send(reader.result);
	
}


function handleFileSelect(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	

	

	if (window.files) {
		window.files.push(evt.dataTransfer.files);
		window.imagePath.push(evt.target.result);
		var ourFiles = evt.dataTransfer.files;
		console.log(ourFiles);
		
	} else {
		window.files = evt.dataTransfer.files;
		window.imagePath.push(evt.target.result);
		
	}

	
	var output = [];
	
	var fileCount = window.files.length;
	var ourImage;

	//Start Drag and Drop File Capture and upload
	for (var i = 0, f; i < fileCount; i++) {
		
		f = window.files[i][0];

		//Test to see if the file is an image
		if (!f.type.match('image.*')) {
			continue;
		}
		
		//Create a File Reader
		reader = new FileReader();
		
		//Capture the file information
		reader.onload = (function(theFile) {
			return function(e) {
				//Render the thumbnail
				ourImage = window.imagePath[i];
				
				
				/*
				output.push('<li><strong>', escape(theFile.name), '</strong> (', theFile.type || 'n/a', ') - ',
					theFile.size, ' bytes, last modified: ',
					theFile.lastModifiedDate ? theFile.lastModifiedDate.toLocaleDateString() : 'n/a',
					//'<img src="', ourImage, '" />',
					'<img height="75" src="', e.target.result, '" />',
				'</li>');
				*/
				output.push('<td><strong>', escape(theFile.name), '</strong> - ',
					theFile.size, ' bytes <br />',
					'<img height="75" src="', e.target.result, '" />',
				'</td>');
				document.getElementById('dropzone').innerHTML = '<table><tr>' + output.join('') + '</tr></table>';
				

			};
		}) (f);
		
		//Read in the image file as a data URL
		reader.readAsDataURL(f);
		
	}
	
	document.getElementById('dropzone').innerHTML = '<ul>' + output.join('') + '</ul>';
}

function handleDragOver(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	evt.dataTransfer.dropEffect = 'copy'; //Explicitly show this is a copy
}

