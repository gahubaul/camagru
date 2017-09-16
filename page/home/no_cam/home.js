(function() {

  				var streaming = false,
      			video        = document.querySelector('#no_video'),
      			cover        = document.querySelector('#cover'),
      			canvas_rendu       = document.querySelector('#canvas_rendu'),
				canvas_valid       = document.querySelector('#canvas_valid'),
      			input       = document.querySelector('#input'),
				yolo			= document.querySelector('#yolo'),
				input2       = document.querySelector('#input2'),
      			photo        = document.querySelector('#photo'),
      			startbutton  = document.querySelector('#startbutton'),
				uploadbutton  = document.querySelector('#uploadbutton'),
      			width = 500,
      			height = 375;

  				function takepicture() {
					var img = document.getElementById('yolo');
    				canvas_rendu.width = width;
    				canvas_rendu.height = height;
					var left = (parseInt(img.style.left, 10) + (width / 2)) - (parseInt(img.style.height, 10) / 2);
					var top = parseInt(img.style.top, 10);
					var width_img = parseInt(img.style.width, 10);
					var height_img = parseInt(img.style.height, 10);
					canvas_rendu.style.backgroundImage = video.style.backgroundImage;
    				canvas_rendu.getContext('2d').drawImage(canvas_rendu, 0, 0, width, height);
					canvas_rendu.getContext('2d').drawImage(img, left, top, width_img, height_img);
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
    				canvas_valid.globalAlpha = 0.5;
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
					var res2 = video.src;
					res2 = res2.split("home/no");

					if (res[1] != "empty.png" && res2[1] != "_cam/")
						  takepicture();
	    			ev.preventDefault();
  				}, false);

})();