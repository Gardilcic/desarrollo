$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/psdi.php",
		data: {
			funcion: "Listar_indicadores"	
		},
		success: function(datos){
			var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			indicador=objeto;
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td><input type='checkbox' class='chkbx' id='" +objeto[key].id+"'></td><td>" + objeto[key].nombre_subproyecto+ "</td><td>"+ objeto[key].nombre_corto +"</td><td>" + objeto[key].descripcion_indicador + "</td></tr>";
			});
			
			$('#tabla_body').html(texto);
			
			/////////////////////////////////////////////////////////////
			$.extend($.tablesorter.themes.bootstrap, {
			    // these classes are added to the table. To see other table classes available,
			    // look here: http://twitter.github.com/bootstrap/base-css.html#tables
			    table      : 'table table-bordered',
			    header     : 'bootstrap-header', // give the header a gradient background
			    footerRow  : '',
			    footerCells: '',
			    icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
			    sortNone   : 'bootstrap-icon-unsorted',
			    sortAsc    : 'icon-chevron-up',
			    sortDesc   : 'icon-chevron-down',
			    active     : '', // applied when column is sorted
			    hover      : '', // use custom css here - bootstrap class may not override it
			    filterRow  : '', // filter row class
			    even       : '', // odd row zebra striping
			    odd        : ''  // even row zebra striping
			  });
			
			  // call the tablesorter plugin and apply the uitheme widget
			  $("table").tablesorter({
			    // this will apply the bootstrap theme if "uitheme" widget is included
			    // the widgetOptions.uitheme is no longer required to be set
			    theme : "bootstrap",
			    
			    sortList: [[0,0],[1,0]],
			
			    widthFixed: true,
			
			    headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
			
			    // widget code contained in the jquery.tablesorter.widgets.js file
			    // use the zebra stripe widget if you plan on hiding any rows (filter widget)
			    widgets : [ "uitheme", "filter", "zebra" ],
			
			    widgetOptions : {
			      // using the default zebra striping class name, so it actually isn't included in the theme variable above
			      // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
			      zebra : ["even", "odd"],
			
			      // reset filters button
			      filter_reset : ".reset"
			
			      // set the uitheme widget to use the bootstrap theme class names
			      // this is no longer required, if theme is set
			      // ,uitheme : "bootstrap"
			
			    }
			  }).tablesorterPager({

			    // target the pager markup - see the HTML block below
			    container: $(".pager"),
			
			    // target the pager page select dropdown - choose a page
			    cssGoto  : ".pagenum",
			
			    // remove rows from the table to speed up the sort of large tables.
			    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
			    removeRows: false,
			
			    // output string - default is '{page}/{totalPages}';
			    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
			    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
			
			  });
		}
	});
	
	$.ajax({
        type: "POST",
        url: "modelo/usuarios.php",
        data: {
            funcion: "ListarUsuarios"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";
			texto+="<option value='0'>Escoja</option>";
            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + decodeURIComponent(escape(objeto[key].usuario)) + ">" + decodeURIComponent(escape(objeto[key].nombre)) + "</option>";
                //tabla_body
            });

            $('#lista_usuarios').html(texto);
        }
    });
    
    $('#lista_usuarios').change(function()
	{		
		$('.chkbx').prop("checked", false);
		if(document.getElementById('lista_usuarios').value != 0)
		{
			$.ajax({
				type: "POST",
				url: "modelo/psdi_usuarios.php",
				data: 
				{
					funcion: "recupera_relacion_usuario",
					usuario: document.getElementById('lista_usuarios').value
				},
				success: function(datos)
				{
					retorno = datos.split(',');
					var lista_checkbox=Array();
					lista_checkbox=$('.chkbx');
					largo_arr=$('.chkbx').length;
					largo_retorno=retorno.length;
					var contador = 0;
					var contador2 =0;
					while(contador<largo_retorno)
					{
						$('.chkbx[id="' +retorno[contador]+'"]').prop("checked", true);
						contador++;
					}
				}
			});
		}
	});
    
    $('#btn_guardar').click(function()
	{
		$('.mensajes').css('display','none');
		var fecha= null;
		//var codigo = $('.chkbx').find('.roundabout-in-focus').attr('codigo');
		var frecuencia = 0;
		var lista_checkbox=Array();
		lista_checkbox=$('.chkbx');
		var arr_checked= lista_checkbox.attr(':checked');
		//lista_checkbox;
		largo_arr=$('.chkbx').length;
		var cont= 0;
		usuario = document.getElementById('lista_usuarios').value;
		//alert(usuario);
		var arreglo_enviar="";
		var control=0;
		while(cont <largo_arr)
		{
			if(lista_checkbox[cont].checked)
			{
				//alert(lista_checkbox[cont].id);
				arreglo_enviar+=lista_checkbox[cont].id + ',';
				control=1;
			}
			cont++;
		}
		if(control==1)
		{
			arreglo_enviar=arreglo_enviar.substring(0,arreglo_enviar.length-1)
		}
		$.ajax({
	        type: "POST",
	        url: "modelo/psdi_usuarios.php",
	        data:
	        {
	            funcion: "agregar_relaciones", usuario: usuario, id: arreglo_enviar
	        },
	        });
		$('.chkbx').prop("checked", false);
		//alert('Solicitud realizada.');
		
	});
})