
$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/monedas.php",
		data: {
			funcion: "listar_monedas"	
		},
		success: function(datos){
			var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].nombre+"</td><td>"+objeto[key].simbolo+"</td><td>"+objeto[key].nombre+" ("+objeto[key].simbolo+")</td>";
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
	
	$('#btnNuevoAceptar').click(function()
	{
		$('.mensajes').css('display','none');
		/*if($('#Nueva_moneda_nombre').val()>0 && $('#Nueva_moneda_simbolo').val()>0)
		{*/
			$.ajax({
				type: "POST",
				url: "modelo/monedas.php",
				data: 
				{
					funcion: "nueva_moneda",
					nombre: $('#Nueva_moneda_nombre').val(),
					simbolo: $('#Nueva_moneda_simbolo').val()
				},
				success: function(datos)
				{
					//alert(datos);
					if(datos>0)
					{
						alert('Acción realizada. Gracias.');
						location.reload();
						//$('#estados').html(texto);
					}
				}
			});
		/*}
		else
		{
			$('.mensajes').show();
			$('#mensaje').html(" Por favor, Complete los datos del formulario.");
		}*/
	});
	
	$('#btnEditarAceptar').click(function()
	{
		//alert($('#mid').val());
		$('.mensajes').css('display','none');
			$.ajax(
			{
				type: "POST",
				url: "modelo/monedas.php",
				data: 
				{
					funcion: "updt_moneda",
					id: $('#mid').val(),
					nombre: $('#mNueva_moneda_nombre').val(),
					simbolo: $('#mNueva_moneda_simbolo').val()
				},
			success: function(datos)
			{
				alert('Solicitud realizada.');
				location.reload();
			}
		});
	});
	
	$('#btnEliminarAceptar').click(function(){
		$('.mensajes').css('display','none');

			$.ajax({
				type: "POST",
				url: "modelo/usuarios.php",
				data: {
					funcion: "EliminarUsuario",
					id: $('#IdRegistro').val()
				},
				success: function(datos){
					//alert(datos);
					if(datos>0) {						
						
						var row =						
							"<a class='btn btn-warning' codigo='"+$('#IdRegistro').val()+"' onclick='dlgModificar("+$('#IdRegistro').val()+")'><i class='icon-pencil icon-white'></i></a> "+
							"<a class='btn btn-danger' href='#'><i class='icon-remove icon-white'></i></a>";

						var $row = $(row),
							resort = true,
							callback = function(table){
								//alert('rows have been added!');
							};
						
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(0)').text($('#EditarNombre').val());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(1)').text($('#EditarApellido').val());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(2)').text($('#EditarRut').val());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(3)').text($('#mperfiles option:selected').text());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(4)').text($('#mestados option:selected').text());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(5)').html(row);
						
						$("table").trigger("updateCell", [this, resort, callback]);
    
						document.getElementById("form_nuevo").reset();				
						$('#dlgModificar').modal('hide');
					}
				}
			});
		/*}
		else
		{
			$('.mmensajes').show();
			$('#mmensaje').html(" Por favor, Complete los datos del formulario.");
		}*/
	});

});
	function dlgModificar(id)
{
	// PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
	//alert(id);
	$nombre = $('.'+id).find('td:eq(3)').text();
	$simbolo = $('.'+id).find('td:eq(4)').text();
	
	$('#mid').val( id );
	$('#mNueva_moneda_nombre').val( $('.'+id).find('td:eq(0)').text() );
	$('#mNueva_moneda_simbolo').val( $('.'+id).find('td:eq(1)').text() );
	$('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
	var r=confirm("Está seguro que desea eliminar la divisa " + $('.'+id).find('td:eq(0)').text());
	if(r==true)
	{
		//alert('Ha solicitado eliminar.');
		$.ajax(
		{
			type: "POST",
			url: "modelo/monedas.php",
			data: 
			{
				funcion: "valida_dependencia",
				moneda: id
			},
			success: function(datos)
			{
				//alert(datos);
				if(datos==0)
				{
					$.ajax(
					{
						type: "POST",
						url: "modelo/monedas.php",
						data: 
						{
							funcion: "borra_moneda",
							moneda: id
						},
						success: function(data)
						{
							//alert(data);
							if(data==0)
							{
								alert('Solicitud realizada.');
								location.reload();
							}
							else
							{
								alert('Por algún motivo no ha resultado lo solicitado.');
							}
						}
					});
				}
				else
				{
					alert('No es posible eliminar la divisa pues se encuentra asignada.');
				}
			}
		});
	}
}