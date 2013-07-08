
$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/turnos.php",
		data: {
			funcion: "ListarTurnos"	
		},
		success: function(datos){
			var objeto = eval(datos);
			var texto = "";
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].nombre+"</td><td>"+objeto[key].subproyecto_nombre+"</td><td>"+objeto[key].proyecto_nombre+"</td>";
				texto += "<td>"+						
						"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
						"<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
					"</td></tr>";

				//tabla_body
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
		url: "modelo/proyectos.php",
		async: false,
		data: {
			funcion: "ListarProyectos"	
		},		
		success: function(datos){
			var objeto = eval(datos);
			var texto = "<option value='0'>Seleccione</option>";
			
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
				//tabla_body
			});
			
			$('#proyecto').html(texto);
			$('#mproyecto').html(texto);
			
		}
	});

	$('#proyecto').change(function (){
		$.ajax({
			type: "POST",
			url: "modelo/subproyectos.php",
			async: false,
			data: {
				funcion: "ListarSubProyectosPorProyecto",
				idproyecto: $('#proyecto').val()
			},		
			success: function(datos){
				$('#subproyecto').html('');
				var objeto = eval(datos);
				var texto = "<option value='0'>Seleccione</option>";
				
				$.each( objeto , function(key, item){
					//alert(objeto[key].nombre);
					texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
					//tabla_body
				});
				
				$('#subproyecto').html(texto);
				$('#msubproyecto').html(texto);
	
			}
		});
	});
	
	$('#mproyecto').change(function (){
		$.ajax({
			type: "POST",
			url: "modelo/subproyectos.php",
			async: false,
			data: {
				funcion: "ListarSubProyectosPorProyecto",
				idproyecto: $('#mproyecto').val()
			},		
			success: function(datos){
				$('#subproyecto').html('');
				var objeto = eval(datos);
				var texto = "<option value='0'>Seleccione</option>";
				
				$.each( objeto , function(key, item){
					//alert(objeto[key].nombre);
					texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
					//tabla_body
				});
				
				$('#subproyecto').html(texto);
				$('#msubproyecto').html(texto);
	
			}
		});
	});


	
	$.ajax({
		type: "POST",
		url: "modelo/usuarios.php",
		data: {
			funcion: "ListarEstados"	
		},
		success: function(datos){
			var objeto = eval(datos);
			var texto = "";
			
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<option value="+objeto[key].id+">"+objeto[key].nombre+"</option>";
				//tabla_body
			});
			
			$('#estados').html(texto);
			$('#mestados').html(texto);

		}
	});
	$('#btnNuevoAceptar').click(function(){
		$('.mensajes').css('display','none');
		if($('#NuevoNombre').val().length > 0 && $('#proyecto').val().length > 0 && $('#subproyecto').val().length > 0 ) {
			$.ajax({
				type: "POST",
				url: "modelo/turnos.php",
				data: {
					funcion: "GrabarNuevo",
					nombre: $('#NuevoNombre').val(),
					id_subproyecto: $('#subproyecto').val(),
					id_proyecto: $('#proyecto').val()	
				},
				success: function(datos){
					//alert(datos);
					if(datos>0) {					
						var row = '<tr class='+datos+'><td>'+$('#NuevoNombre').val()+'</td>' +
									'<td>'+$('#subproyecto').find('option:selected').text()+'</td><td>'+$('#proyecto').find('option:selected').text()+'</td>';
						row +=						
									"<td><a class='btn btn-warning' codigo='"+datos+"' onclick='dlgModificar("+datos+")'><i class='icon-pencil icon-white'></i></a> "+
									"<a class='btn btn-danger' codigo='"+datos+"' onclick='dlgEliminar("+datos+")'><i class='icon-remove icon-white'></i></a></td></tr>";
						
						var $row = $(row),
						resort = true,
						callback = function(table){
							//alert('rows have been added!');
						};
						
						$('table')
							.find('tbody').append($row)
							.trigger('addRows', [$row, resort, callback]);
						
						document.getElementById("form_nuevo").reset();				
						$('#dlgAgregar').modal('hide');
						
						//$('#estados').html(texto);
					}
				}
			});
		}
		else
		{
			$('.mensajes').show();
			$('#mensaje').html(" Por favor, Complete los datos del formulario.");
		}
	});
	
	$('#btnEditarAceptar').click(function(){
		$('.mensajes').css('display','none');
		if($('#msubproyecto').val()>0 && $('#mproyecto').val()>0 && $('#EditarNombre').val().length > 0 ) {
			$.ajax({
				type: "POST",
				url: "modelo/turnos.php",
				data: {
					funcion: "GrabarTurno",
					id: $('#IdRegistro').val(),
					nombre: $('#EditarNombre').val(),
					id_subproyecto: $('#msubproyecto').val()
				},
				success: function(datos){
					//alert(datos);
					if(datos>0) {						
						
						var row =						
							"<a class='btn btn-warning' codigo='"+$('#IdRegistro').val()+"' onclick='dlgModificar("+$('#IdRegistro').val()+")'><i class='icon-pencil icon-white'></i></a> "+
							"<a class='btn btn-danger' codigo='"+$('#IdRegistro').val()+"' onclick='dlgEliminar("+$('#IdRegistro').val()+")'><i class='icon-remove icon-white'></i></a>";

						var $row = $(row),
							resort = true,
							callback = function(table){
								//alert('rows have been added!');
							};
						
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(0)').text($('#EditarNombre').val());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(1)').text($('#msubproyecto option:selected').text());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(2)').text($('#mproyecto option:selected').text());
						$('table').find( 'tr.'+$('#IdRegistro').val() ).find('td:eq(5)').html(row);
						
						$("table").trigger("updateCell", [this, resort, callback]);
    
						document.getElementById("form_nuevo").reset();				
						$('#dlgModificar').modal('hide');
					}
				}
			});
		}
		else
		{
			$('.mmensajes').show();
			$('#mmensaje').html(" Por favor, Complete los datos del formulario.");
		}
	});
	
	$('#btnEliminarAceptar').click(function(){
		$('.mensajes').css('display','none');

			$.ajax({
				type: "POST",
				url: "modelo/turnos.php",
				data: {
					funcion: "Eliminar",
					id: $('#mIdRegistro').val()
				},
				success: function(datos){
					if(datos>0) { 					
						var t = $('table'); 
						var tmp = $('#mIdRegistro').val();
	
						t.trigger('disable.pager'); 
						$('.'+tmp).closest('tr').remove(); 
						t.trigger('enable.pager'); 
    		
						$('#dlgEliminar').modal('hide');
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
	
function dlgModificar(id){
	// PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
	//alert(id);
	/*$proyecto = $('.'+id).find('td:eq(2)').text();
	$subproyecto = $('.'+id).find('td:eq(1)').text();*/
	
	$('#IdRegistro').val( id );
	$('#EditarNombre').val( $('.'+id).find('td:eq(0)').text() );
	$("#mproyecto").val(0);
	$("#submproyecto").val(0);
	
	//alert($proyecto);
	/*var $valor = $("#mproyecto").find("option:contains('"+$proyecto +"')").val();
	$("#mproyecto ").val($valor);
		
	$valor = $("#msubproyecto").find("option:contains('"+$subproyecto +"')").val();
	$("#msubproyecto").val($valor);*/
	
	$('#dlgModificar').modal('show');
}

function dlgEliminar(id){
	// PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
	//alert(id);
	/*$perfil = $('.'+id).find('td:eq(3)').text();
	$estado = $('.'+id).find('td:eq(4)').text();
	
	$('#IdRegistro').val( id );
	$('#EditarNombre').val( $('.'+id).find('td:eq(0)').text() );
	$('#EditarApellido').val( $('.'+id).find('td:eq(1)').text() );
	$('#EditarRut').val( $('.'+id).find('td:eq(2)').text() );
	
	var $valor = $("#mperfiles").find("option:contains('"+$perfil+"')").val();
	$("#mperfiles").val($valor);
		
	$valor = $("#mestados").find("option:contains('"+$estado+"')").val();
	$("#mestados").val($valor);*/
	$('#mIdRegistro').val(id);
	$('#dlgEliminar').modal('show');
}

