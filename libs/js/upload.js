(function () {
	var input = [], 
		vista = $('#image-list'),
		formdata = false,
		j = 0; //  CONTADOR PARA EL NUMERO DE FORMULARIOS QUE SUBIRAN IMAGENES DE FORMA INDEPENDIENTE

		input = document.querySelectorAll("input.images");

	function showUploadedItem (source) {
		var obj = this.form.elements['image-list'];
		$(obj).html("<ur><li><img src="+source+" border='0' /></li></ul>");
	}   

	if (window.FormData) {
  		formdata = new FormData();
  		$("[id=btn]").css('display' , "none");
	}
	
	//alert($("[id=images]").size());    })
	


	for ( j=0 ; j < input.length; j++ ) {
		
		input[j].addEventListener("change", function (evt) { 		
			var divpreview = this.form.elements['preview'].value;
			var divmensaje = this.form.elements['mensaje'].value;
			var i = 0, img, len = this.files.length, reader, file;
			$("."+divpreview).html('');

			for ( ; i < len; i++ ) {
				file = this.files[i];
				if (!!file.type.match(/image.*/)) {
					if ( window.FileReader ) {
						reader = new FileReader();
						reader.onloadend = function (e) { 	
							//showUploadedItem(e.target.result, file.fileName);
							$("."+divpreview).html("<li><img src="+e.target.result+" border='0' width='100' /></li>");
						};
						reader.readAsDataURL(file);
					}
				}
			}
			
			if (formdata) {
				formdata.append("images", file);
				formdata.append("ruta", this.form.elements['ruta_destino'].value ); 
				formdata.append("peso", this.form.elements['peso_maximo'].value ); 
				formdata.append("extension", this.form.elements['extension'].value );
				formdata.append("identificador", this.form.elements['identificador'].value ); 
				formdata.append("preview", this.form.elements['preview'].value ); 
			}			
			
			if (formdata) {
				$.ajax({
					url: "libs/js/upload.php",
					type: "POST",
					data: formdata,
					processData: false,
					contentType: false,
					success: function (res) {
						$("."+divmensaje).html('');
						
						var respuesta = eval("("+res+")");
						$("."+divmensaje).html(respuesta.mensaje);
					}
				});
			}
		}, false);
	}
}());
