$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/empresas_profesionales.php",
		data: {
			funcion: "listar_personas_empresa"	
		},
		success: function(datos)
		{
			//alert(datos);
			var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			$.each( objeto , function(key, item)
			{
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].nombre+"</td><td>"+objeto[key].empresa+"</td><td>"+ objeto[key].estado +"</d>";
				texto += "<td>"+objeto[key].vigencia+"</td>";
				texto += "<td>"+						
						"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
						//"<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
					"</td></tr>";
			});
			
			
			
			//alert(datos);
			//datos="[{'id':'33','nombre':'de Arica y Parinacota','simbolo':'N/A','pais':'Chile'},{'id':'34','nombre':'de Tarapacá','simbolo':'N/A','pais':'Chile'},";
			/*var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			$.each( objeto , function(key, item)
			{
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].nombre+"</td>";
				texto += "<td>"+objeto[key].simbolo+"</td><td>"+objeto[key].pais+"</td>";
				//texto += "<td>"+						
				//		"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
						//"<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
				texto += "<td></td></tr>";
			});*/
			
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
		if($('#Nuevo_nombre').val() != '')
		{
			$('.mensajes').css('display','none');
			/*if($('#Nueva_moneda_nombre').val()>0 && $('#Nueva_moneda_simbolo').val()>0)
			{*/
				$.ajax({
					type: "POST",
					url: "modelo/empresas_profesionales.php",
					data: 
					{
						funcion: "nuevo_profesional",
						nombre: $('#Nuevo_nombre').val(),
						empresa: $('#Nuevo_empresa').val(),
						estado: $('#Nuevo_estado').val()
					},
					success: function(datos)
					{
						//alert(datos);
						if(datos>0)
						{
							alert('Acción realizada. Gracias.');
							location.reload();
						}
						else
						{
							alert('OOoppss! Ha ocurrido un problema. Reintenta, refresca la pantalla o contacta a un administrador.');
						}
					}
				});
		}
		else
		{
			$('.mensajes').show();
			$('#mensaje').html(" Por favor, introduzca un nombre para el perfil.");
		}
	});
	
	$.ajax({
		type: "POST",
		url: "modelo/empresas.php",
		data: {
			funcion: "listar_empresas"	
		},
		success: function(datos){
		//alert(datos);
			var objeto = eval(datos);
			var texto = "";
			
			$.each( objeto , function(key, item)
			{
				//alert(objeto[key].nombre);
				texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
				//tabla_body
			});
			
			$('#Nuevo_empresa').html(texto);
			$('#mNuevo_empresa').html(texto);

		}
	});
	
	$.ajax({
		type: "POST",
		url: "modelo/empresas.php",
		data: {
			funcion: "listar_estados"	
		},
		success: function(datos){
		//alert(datos);
			var objeto = eval(datos);
			var texto = "";
			
			$.each( objeto , function(key, item)
			{
				//alert(objeto[key].nombre);
				texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
				//tabla_body
			});
			
			$('#Nuevo_estado').html(texto);
			$('#mNuevo_estado').html(texto);

		}
	});
	
	
	$('#btnEditarAceptar').click(function()
	{
		//alert($('#mid').val());
		if($('#mNuevo_nombre').val() != '')
		{
			$('.mensajes').css('display','none');
				$.ajax(
				{
					type: "POST",
					url: "modelo/empresas_profesionales.php",
					data: 
					{
						funcion: "updt_profesional",
						id: $('#mid').val(),
						nombre: $('#mNuevo_nombre').val(),
						empresa: $('#mNuevo_empresa').val(),
						estado: $('#mNuevo_estado').val()
					},
					success: function(datos)
					{
						//alert(datos);
						if(datos==1)
						{
							alert('Acción realizada. Gracias.');
							location.reload();
						}
						else
						{
							alert('Por alguna razón su solicitud no pudo realizarse. Por favor revise los datos enviados.');
						}
					}
				});
		}
		else
		{
			$('.mensajes').show();
			$('#mensaje').html(" Por favor, introduzca un nombre.");
		}
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
	$empresa ="";
	$nombre = $('.'+id).find('td:eq(0)').text();
	$empresa = $('.'+id).find('td:eq(1)').text();
	$estado = $('.'+id).find('td:eq(2)').text();
	
	$('#mid').val( id );
	$('#mNuevo_nombre').val( $('.'+id).find('td:eq(0)').text() );
	$('#mNuevo_vigencia').val( $('.'+id).find('td:eq(3)').text() );
	$("#mNuevo_empresa option:contains(" + $empresa + ")").prop('selected', true);
	$("#mNuevo_estado option:contains(" + $estado + ")").prop('selected', true);
	$('#dlgModificar').modal('show');
	

}