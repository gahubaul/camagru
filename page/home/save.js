


var canvas = document.getElementById('canvas'),
      context = canvas.getContext('2d'),
      oImage = new Image();
  // fonction sur le load
  oImage.onload = function() {
      var larg = this.width,
          haut = this.height,
          dataURL;
      // dimensionne le canvas
      canvas.width = larg;
      canvas.height = haut;
      // dessine image
      context.drawImage( this, 0, 0);
      // récup. data:image/png;base64
      dataURL = canvas.toDataURL();
      // juste pour voir
      window.open( dataURL, 'image');
  };
  // affectation source
  oImage.src = 'le_nom_de_l_image';