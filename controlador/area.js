
$(window).load(function(){
	$.ajax({
		type: "POST",
		url: "modelo/area.php",
		data: {
			funcion: "Listar_area"	
		},
		success: function(datos){
			var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
			var texto = "";
			$.each( objeto , function(key, item){
				//alert(objeto[key].nombre);
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].codigo+"</td><td>"+objeto[key].descripcion+"</td>";
				texto += "<td>" + objeto[key].nombre_estados+ "</td>"
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
        url: "modelo/frecuencias.php",
        data: {
            funcion: "listar_estados"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
                //tabla_body
            });

            $('#Nueva_area_estado').html(texto);
            $('#mNueva_area_estado').html(texto);

        }
    });
    
    /*$.ajax({
        type: "POST",
        url: "modelo/subclasificacion.php",
        data: {
            funcion: "listar_clasificaciones"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
                //tabla_body
            });

            $('#Nueva_subclasificacion_clasificacion').html(texto);
            $('#mNueva_subclasificacion_clasificacion').html(texto);
            //$('#mNueva_clasificacion_estado').html(texto);

        }
    });*/

	
	
	
	$('#btnNuevoAceptar').click(function()
	{
		$('.mensajes').css('display','none');
		
		if($('#Nueva_area_codigo').val().length >0 && $('#Nueva_area_nombre').val().length >0)
		{	
			$.ajax({
				type: "POST",
				url: "modelo/area.php",
				data: 
				{
					funcion: "nueva_area",
					codigo: $('#Nueva_area_codigo').val(),
					nombre: $('#Nueva_area_nombre').val(),
					estado: $('#Nueva_area_estado').val()
				},
				success: function(datos)
				{
					//alert(datos);
					if(datos>0)
					{
						alert('Acción realizada.');
						location.reload();
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
	
	$('#btnEditarAceptar').click(function()
	{
		if($('#mNueva_area_codigo').val().length >0 && $('#mNueva_area_nombre').val().length)
		{
			$('.mensajes').css('display','none');
				$.ajax(
				{
					type: "POST",
					url: "modelo/area.php",
					data: 
					{
						funcion: "updt_area",
						id: $('#mid').val(),
						codigo: $('#mNueva_area_codigo').val(),
						nombre: $('#mNueva_area_nombre').val(),
						estado: $('#mNueva_area_estado').val()
					},
				success: function(datos)
				{
					//alert(datos);
					alert('Solicitud realizada.');
					location.reload();
				}
			});
		}
		else
		{
			alert('No es posible realizar su solicitud por falta de nombre.');
		}
	});

});
	function dlgModificar(id)
{
	// PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
	//alert(id);
	//$nombre = $('.'+id).find('td:eq(3)').text();
	$estado = $('.'+id).find('td:eq(2)').text();
	//$clasificacion = $('.'+id).find('td:eq(1)').text();
	
	$('#mid').val(id);
	$('#mNueva_area_codigo').val( $('.'+id).find('td:eq(0)').text() );
	$('#mNueva_area_nombre').val( $('.'+id).find('td:eq(1)').text() );
	$("#mNueva_area_estado option:contains(" + $estado + ")").prop('selected', true);
	$('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
	var r=confirm("Está seguro que desea eliminar " + $('.'+id).find('td:eq(0)').text());
	if(r==true)
	{
		//alert('Ha solicitado eliminar.');
		$.ajax({
				type: "POST",
				url: "modelo/area.php",
				data: {
					funcion: "eliminar_area",
					//id: $('#mid').val()
					id: id
				},
				success: function(datos){
					//alert(datos);
					if(datos==0) {						
						
						alert('Solicitud realizada');
						location.reload();
					}
					else
					{
						alert('Por algún motivo su solicitud no ha podido ser realizada.');
					}
				}
			});
	}
}