var usuario = '';
var arr_datos=[];
$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/detalle_doc_tecnica.php",
		data: {
			funcion: "listar_paginas"	
		},
		success: function(datos){
			var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].usuario+"</td><td>"+objeto[key].fecha+"</td><td>"+objeto[key].detalle+"</td>";
				texto += "<td>"+						
						"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
						"<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
					"</td></tr>";
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
        url: "modelo/detalle_doc_tecnica.php",
        data: {
            funcion: "get_usuario"
        },
        success: function(datos)
        {
            //alert(datos);
            usuario= datos;
        }
    });
	
	var url_completa = document.location.href;
	
	$.ajax({
		        
        type: "POST",
        url: "modelo/detalle_doc_tecnica.php",
        data: {
            funcion: "listar_modulos_sel"
        },
        success: function(datos)
        {
            var objeto = eval(datos);
			var texto = "<option value='0'>Seleccione Modulo</option>";
			
			$.each( objeto , function(key, item)
			{
				//alert(objeto[key].nombre);
				texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
				//tabla_body
			});
			
			$('#lista_modulos').html(texto);
        }
    });
	
	$('#lista_modulos').change(function()
	{
		$.ajax({
		        
	        type: "POST",
	        url: "modelo/detalle_doc_tecnica.php",
	        data: {
	            funcion: "listar_paginas_sel",
	    		modulo: $('#lista_modulos').val()
	        },
	        success: function(datos)
	        {
	            var objeto = eval(datos);
				var texto = "<option value='0'>Seleccione Programa</option>";
				
				$.each( objeto , function(key, item)
				{
					//alert(objeto[key].nombre);
					texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
					//tabla_body
				});
				
				$('#lista_paginas').html(texto);
	        }
	    });
    });
    
    $('#lista_paginas').change(function()
	{
		//$('.mensajes').css('display','none');
		/*if($('#Nueva_moneda_nombre').val()>0 && $('#Nueva_moneda_simbolo').val()>0)
		{*/
		fecha= new Date();
			$.ajax({
				type: "POST",
				url: "modelo/detalle_doc_tecnica.php",
				data: 
				{
					funcion: "listar_detalle_filtro",
					filtro: $('#lista_paginas').val()
				},
				success: function(datos)
				{
					//alert(datos);
					if(datos!='')
					{
						
						var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
						arr_datos=objeto;
						var texto = "<tr><td><input type='text' id='usuario_ingreso' value='"+ usuario +"' readonly='readonly' style='margin-top:5px;'></td>" +
							"<td><input type='date' id='fecha_ingreso' style='margin-top:5px;'></td>" +
							"<td><input type='text' id='datos_ingreso' style='width:450px; margin-top:5px;'></td>"+
							"<td><button id='btnNuevoAceptar' class='btn btn-primary' onclick='ingresa_nuevo();' style='margin-top:6px;'>Guardar</button></td></tr>";
							//"<td><a class='btn btn-warning'><i class='icon-ok-sign icon-white' id='btnNuevoAceptar'></i></a></td></tr>";
						$.each( objeto , function(key, item){
							texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].usuario+"</td><td>"+objeto[key].fecha+"</td><td>"+objeto[key].detalle+"</td>";
							texto += "<td>"+						
									"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
									"<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
								"</td></tr>";
						});
						
						$('#tabla_body').html(texto);
						
					}
				}
				//$('#fecha_ingreso').val(fecha.getDate() +'-' +fecha.getMonth() + '-'+fecha.getFullYear());
			});
	});

    $.ajax({
		        
        type: "POST",
        url: "modelo/pais.php",
        data: {
            funcion: "get_detalle",
            url: url_completa
        },
        success: function(datos)
        {
            //alert(datos);
            $('#p_detalle').val(datos);
        }
    });
    
    $('#btnEditarAceptar').click(function()
	{
		//alert($('#mid').val());
		$('.mensajes').css('display','none');
			$.ajax(
			{
				type: "POST",
				url: "modelo/detalle_doc_tecnica.php",
				data: 
				{
					funcion: "updt_detalle",
					id: $('#mid').val(),
					usuario: $('#mod_nombre').val(),
					fecha: $('#mod_fecha').val(),
					info: $('#mod_detalle').val()
				},
			success: function(datos)
			{
				alert('Solicitud realizada');
				location.reload();
			}
		});
	});
	
	$('#btnEliminarAceptar').click(function(){
		$('.mensajes').css('display','none');

			$.ajax({
				type: "POST",
				url: "modelo/detalle_doc_tecnica.php",
				data: {
					funcion: "borra_detalle",
					id: $('#IdRegistro').val()
				},
				success: function(datos){
					//alert(datos);
					if(datos==0)
					{		
						location.reload();
					}
				}
			});
	});
	
	$('#btnReporte').click(function() {   
        var titulos = Array();
        var pagina = $('#lista_paginas option:selected').html();
        //alert(pagina);
        titulos[0]='ID';
        titulos[1]='Usuario';
        titulos[2]='Fecha';
        titulos[3]='Información';
        console.log(arr_datos);
        if(arr_datos.length>1) {
            $("<form action='detalle_doc_tecnica_pdf2.php' target='_blank' method='POST'>" + 
                    "<input type='hidden' name='datos' value='"+JSON.stringify(arr_datos)+"'>"+ 
                    "<input type='hidden' name='titulos' value='"+JSON.stringify(titulos)+"'>"+ 
                    "<input type='hidden' name='pagina' value='"+JSON.stringify(pagina)+"'>"+ 
                    "</form>").submit();
        }
    });
});

function ingresa_nuevo()
{
	var fecha=$('#fecha_ingreso').val();
	var usuario=$('#usuario_ingreso').val();
	var info=$('#datos_ingreso').val();
	var pag=$('#lista_paginas').val();
	$('.mensajes').css('display','none');
	if(pag!=0 && $('#fecha_ingreso').val().length >0 && $('#datos_ingreso').val().length > 0)
	{
		$.ajax(
		{
			type: "POST",
			url: "modelo/detalle_doc_tecnica.php",
			data: 
			{
				funcion: "add_info",
				fecha: $('#fecha_ingreso').val(),
				usuario: usuario,
				info: info,
				pag: pag
			},
			success: function(datos)
			{
				alert('Solicitud realizada');
				location.reload();
			}
		});
	}
	else
	{
		alert('Acción incorrecta.');
	}
}

function dlgModificar(id)
{
	// PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
	//alert(id);
	//$nombre = $('.'+id).find('td:eq(3)').text();
	//$simbolo = $('.'+id).find('td:eq(4)').text();
	
	$('#mid').val( id );
	$('#mod_nombre').val( $('.'+id).find('td:eq(0)').text() );
	$('#mod_fecha').val( $('.'+id).find('td:eq(1)').text() );
	$('#mod_detalle').val( $('.'+id).find('td:eq(2)').text() );
	$('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
	var r=confirm("Está seguro que desea eliminar la información?");
	if(r==true)
	{
		//alert('Ha solicitado eliminar.');
		$.ajax(
		{
			type: "POST",
			url: "modelo/detalle_doc_tecnica.php",
			data: 
			{
				funcion: "borra_detalle",
				id: id
			},
			success: function(datos)
			{
				//alert(datos);
				if(datos==0)
				{
					location.reload();
				}
				else
				{
					alert('Por alguna razón no ha sido posible realizar su solicitud.');
				}
			}
		});
	}
}