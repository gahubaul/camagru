function change_img_zoom(){
    var yolo = document.getElementById("yolo");
	yolo.style.height = (parseInt(yolo.style.height, 10) + 10) + "px";
	yolo.style.width = (parseInt(yolo.style.width, 10) + 10) + "px";
}

function change_img_dezoom(){
    var yolo = document.getElementById("yolo");
	yolo.style.height = (parseInt(yolo.style.height, 10) - 10) + "px";
	yolo.style.width = (parseInt(yolo.style.width, 10) - 10) + "px";
}
function change_img_left(){
    var yolo = document.getElementById("yolo");
	yolo.style.left = (parseInt(yolo.style.left, 10) - 10) + "px";
}
function change_img_right(){
    var yolo = document.getElementById("yolo");
	yolo.style.left = (parseInt(yolo.style.left, 10) + 10) + "px";
}

function change_img_top(){
    var yolo = document.getElementById("yolo");
	yolo.style.top = (parseInt(yolo.style.top, 10) - 10) + "px";
}
function change_img_bot(){
    var yolo = document.getElementById("yolo");
	yolo.style.top = (parseInt(yolo.style.top, 10) + 10) + "px";
}

function change_img(elem){
    var yolo = document.getElementById("yolo");
	yolo.src = elem.src;
}
