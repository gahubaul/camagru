(function() {

  				var streaming = false,
      			video        = document.querySelector('#video'),
				video2       = document.querySelector('#video2'),
      			cover        = document.querySelector('#cover'),
      			canvas_rendu       = document.querySelector('#canvas_rendu'),
				canvas_valid       = document.querySelector('#canvas_valid'),
      			input       = document.querySelector('#input'),
				yolo			= document.querySelector('#yolo'),
				input2       = document.querySelector('#input2'),
      			photo        = document.querySelector('#photo'),
      			startbutton  = document.querySelector('#startbutton'),
      			width = parseInt(document.getElementById('video').style.width),
      			height = 0;
  				navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

				navigator.getMedia(
				{
      				video: true,
      				audio: false
    			},
    			function(stream) {
      				if (navigator.mozGetUserMedia) {
						video.mozSrcObject = stream;
      				} else {
        			var vendorURL = window.URL || window.webkitURL;
        			video.src = vendorURL.createObjectURL(stream);
      				}
      				video.play();
    			},
    			function(err) {
      				console.log("An error occured! " + err);
				}
  				);

  				video.addEventListener('canplay', function(ev){
    			if (!streaming) {
      				height = video.videoHeight / (video.videoWidth/width);
      				video.setAttribute('width', width);
      				video.setAttribute('height', height);
      				canvas_rendu.setAttribute('width', width);
      				canvas_rendu.setAttribute('height', height);
      				streaming = true;
    			}
  				}, false);

  				function takepicture() {
					var img = document.getElementById('yolo');
    				canvas_rendu.width = width;
    				canvas_rendu.height = height;
					var left = (parseInt(img.style.left, 10) + (width / 2)) - (parseInt(img.style.height, 10) / 2);
					var top = parseInt(img.style.top, 10);
					var width_img = parseInt(img.style.width, 10);
					var height_img = parseInt(img.style.height, 10);
    				canvas_rendu.getContext('2d').drawImage(video, 0, 0, width, height);
					canvas_rendu.getContext('2d').drawImage(img, left, top, width_img, height_img);
					canvas_rendu.style.boxShadow = "0px 0px 15px black";
					takepicture2();
				}

				function takepicture2() {
					var img = document.getElementById('yolo');
    				canvas_valid.width = width;
    				canvas_valid.height = height;
					var left = (parseInt(img.style.left, 10) + (width / 2)) - (parseInt(img.style.height, 10) / 2);
					var top = parseInt(img.style.top, 10);
					var width_img = parseInt(img.style.width, 10);
					var height_img = parseInt(img.style.height, 10);
    				canvas_valid.getContext('2d').drawImage(video, 0, 0, width, height);
					var line = img.src;
					var res = line.split("img/png/");
					var data = canvas_valid.toDataURL("image/jpg");
					input.setAttribute('value', data);
					var vanessa = left + " " + top + " " + width_img + " " + height_img + " " + res[1];
					input2.setAttribute('value', vanessa);
  				}

  				startbutton.addEventListener('click', function(ev){
					var verif = document.getElementById('yolo');
					var line = verif.src;
					var res = line.split("img/png/");
					if (res[1] != "empty.png")
						  takepicture();
					else{

					}
	    			ev.preventDefault();
  				}, false);

})();