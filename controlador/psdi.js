var indicador = null;
var nivel= 1;
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
				texto += "<tr class="+objeto[key].id+"><td>"+objeto[key].nombre_proyecto+"</td><td>" + objeto[key].nombre_subproyecto+ "</td><td>"+ objeto[key].descripcion_indicador +"</td><td>"+ objeto[key].descripcion_frecuencia +"</td><td>" + objeto[key].descripcion_calendario + "</td><td>"+objeto[key].nombre_corto+"</td>";
				texto += "<td>" + objeto[key].descripcion_area+ "</td><td>" + objeto[key].descripcion_perspectiva+ "</td><td>" + objeto[key].ingresado_por+ "</td><td>" + objeto[key].supervisado_por + "</td>"
				texto += "<td>" + objeto[key].dato_de + "</td><td>"+objeto[key].correo+"</td><td>"+objeto[key].num_dias+"</td>"
				texto += "<td>"+ 						
						"<a class='btn btn-warning' codigo='"+key+"' onclick='dlgModificar("+key+")'><i class='icon-pencil icon-white'></i></a> "+
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
        url: "modelo/psdi.php",
        data: {
            funcion: "Listar_frecuencia"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "<option value='99999999'>Escoja opci&oacute;n</option>";
            texto += "<option value='0'>Por Calendario</option>";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].descripcion + "</option>";
                //tabla_body
            });

            $('#Nuevo_psdi_frecuencia').html(texto);
            $('#mNuevo_psdi_frecuencia').html(texto);
            //$('#mNuevo_indicador_estado').html(texto);
        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
        data: {
            funcion: "listar_area"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].descripcion + " (" + objeto[key].descripcion +")" + "</option>";
                //tabla_body
            });

            $('#Nuevo_psdi_area').html(texto);
            $('#mNuevo_psdi_area').html(texto);
            //$('#mNuevo_indicador_estado').html(texto);
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

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + decodeURIComponent(escape(objeto[key].usuario)) + ">" + decodeURIComponent(escape(objeto[key].nombre)) + "</option>";
                //tabla_body
            });

            $('#nuevo_psdi_propietario').html(texto);
            $('#nuevo_psdi_supervisor').html(texto);
            $('#nuevo_psdi_ingresado').html(texto);
            $('#mnuevo_psdi_propietario').html(texto);
            $('#mnuevo_psdi_supervisor').html(texto);
            $('#mnuevo_psdi_ingresado').html(texto);

        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
        data: {
            funcion: "listar_indicador"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + " nivel =" + objeto[key].nivel +">" + objeto[key].descripcion + "</option>";
                //tabla_body
            });

            $('#Nuevo_psdi_indicador').html(texto);
            $('#mNuevo_psdi_indicador').html(texto);
            //$('#mNuevo_indicador_unidad').html(texto);

        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
        data: {
            funcion: "listar_calendarios"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].descripcion + "</option>";
                //tabla_body
            });

            $('#nuevo_psdi_calendar').html(texto);
            $('#mnuevo_psdi_calendar').html(texto);
            //$('#mNuevo_indicador_unidad').html(texto);

        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
        data: {
            funcion: "listar_subproyectos"
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

            $('#Nuevo_psdi_subproyecto').html(texto);
            $('#mNuevo_psdi_subproyecto').html(texto);
            //$('#mNuevo_indicador_unidad').html(texto);

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
        data: {
            funcion: "listar_perspectiva"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].descripcion + "</option>";
                //tabla_body
            });

            $('#Nuevo_psdi_perspectiva').html(texto);
            $('#mNuevo_psdi_perspectiva').html(texto);
            //$('#mNuevo_indicador_unidad').html(texto);

        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/psdi.php",
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

            $('#Nuevo_psdi_estado').html(texto);
            $('#mNuevo_psdi_estado').html(texto);
            //$('#mNuevo_indicador_unidad').html(texto);

        }
    });
    

    $('#Nuevo_psdi_indicador').change(function()
    {
    	var nivel = 0;
    	//alert($('#Nuevo_psdi_indicador').val());
    	$.ajax({
			type: "POST",
			url: "modelo/psdi.php",
			data: 
			{
				funcion: "get_nivel",
				indicador: $('#Nuevo_psdi_indicador').val()
			},
			success: function(datos)
			{
				//alert(datos);
				nivel=datos;
				if(nivel !=1)
				{
					$('#capa_ingresado_por').css("display","none");
					$('#capa_ingresado_por').addClass('escondida');
					$('#capa_supervisado_por').css("display","none");
					$('#capa_supervisado_por').addClass('escondida');
					$('#capa_propietario').css("display","none");
					$('#capa_propietario').addClass('escondida');
					$('#capa_correo').css("display","none");
					$('#capa_correo').addClass('escondida');
					$('#capa_correo_dias').css("display","none");
					$('#capa_correo_dias').addClass('escondida');
					$('#chkbx_correo').prop('checked',false);
					$('#chkbx_correo').addClass('escondida');
					$('#Nuevo_psdi_cantdias').val(0);
					$('#Nuevo_psdi_cantdias').addClass('escondida');
				}
				else
				{
					$('#capa_ingresado_por').css("display","block");
					$('#capa_ingresado_por').removeClass('escondida');
					$('#capa_supervisado_por').css("display","block");
					$('#capa_supervisado_por').removeClass('escondida');
					$('#capa_propietario').css("display","block");
					$('#capa_propietario').removeClass('escondida');
					$('#capa_correo').css("display","block");
					$('#capa_correo').removeClass('escondida');
					$('#capa_correo_dias').css("display","block");
					$('#capa_correo_dias').removeClass('escondida');
				}
			}
		});

    });

	$('#btnNuevoAceptar').click(function()
	{		
		$('.mensajes').css('display','none');
		var fecha= 'NULL';
		var frecuencia = 0;
		if($('#Nuevo_psdi_frecuencia').val()==0)//si frecuencia es 0, hay fecha en calendario.
		{
			fecha=$('#nuevo_psdi_calendar').val();
		}
		else
		{
			frecuencia = $('#Nuevo_psdi_frecuencia').val();
		}
		var correo= 0;
		if(document.getElementById('chkbx_correo').checked == true)
		{
			correo=1;
		}
		var ingresado_por=$('#nuevo_psdi_ingresado').val();
		var supervisor=$('#nuevo_psdi_supervisor').val();
		var propietario=$('#nuevo_psdi_propietario').val();
		//alert($('#Nuevo_psdi_indicador option:selected').attr('nivel'));
		if($('#Nuevo_psdi_indicador option:selected').attr('nivel') == 0 )
		{
			ingresado_por='0';
			supervisor='0';
			propietario='0';
		}
		//alert(ingresado_por);
		$.ajax({
			type: "POST",
			url: "modelo/psdi.php",
			data: 
			{
				funcion: "nuevo_psdi",
				subproyecto: $('#Nuevo_psdi_subproyecto').val(),
				frecuencia:frecuencia,
				fecha: fecha,
				indicador: $('#Nuevo_psdi_indicador').val(),
				area: $('#Nuevo_psdi_area').val(),
				perspectiva: $('#Nuevo_psdi_perspectiva').val(),
				ingresado_por: ingresado_por,
				supervisor: supervisor,
				propietario: propietario,
				estado: $('#Nuevo_psdi_estado').val(),
				nombre_corto: $('#Nuevo_psdi_nombrecorto').val(),
				correo: correo,
				cant_dias: $('#Nuevo_psdi_cantdias').val()
			},
			success: function(datos)
			{
				//alert(datos);
				if(datos>0)
				{
					alert('Acción realizada.');
					//location.reload();
					//$('#estados').html(texto);
				}
				else
				{
					alert('Por algún motivo no ha sido posible realizar su solicitud.');
				}
			}
		});
	});
	
	$('#btnEditarAceptar').click(function()
	{
		var fecha='NULL';
		var frecuencia=0;
		if($('#mNuevo_psdi_frecuencia').val()==0)//si frecuencia es 0, hay fecha en calendario.
		{
			fecha=$('#mnuevo_psdi_calendar').val();
		}
		else
		{
			frecuencia = $('#mNuevo_psdi_frecuencia').val();
		}
		
		var correo= 0;
		if(document.getElementById('mchkbx_correo').checked == true)
		{
			correo=1;
		}
		var ingresado_por=$('#mnuevo_psdi_ingresado').val();
		var supervisor=$('#mnuevo_psdi_supervisor').val();
		var propietario=$('#mnuevo_psdi_propietario').val();
		//alert(ingresado_por);
		//alert(indicador[$('#mpos').val()].nivel);
		if(indicador[$('#mpos').val()].nivel != 1)
		{
			//alert($('#mpos').val());
			//alert(indicador[$('#mpos').val()].nivel);
			ingresado_por='0';
			supervisor='0';
			propietario='0';
		}
		if($('#mNuevo_psdi_nombrecorto').val().length >0)
		{
			$('.mensajes').css('display','none');
				$.ajax(
				{
					type: "POST",
					url: "modelo/psdi.php",
					data: 
					{
						funcion: "updt_psdi",
						id: $('#mid').val(),
						subproyecto:$('#mNuevo_psdi_subproyecto').val(),
						frecuencia:frecuencia,
						calendario:fecha,
						indicador: indicador[$('#mpos').val()].id_indicador,
						nombre_corto:$('#mNuevo_psdi_nombrecorto').val(),
						area:$('#mNuevo_psdi_area').val(),
						perspectiva:$('#mNuevo_psdi_perspectiva').val(),
						ingresado:ingresado_por,
						supervisor:supervisor,
						propietario:propietario,
						estado:$('#mNuevo_psdi_estado').val(),
						correo: correo,
						cant_dias: $('#mNuevo_psdi_cantdias').val()
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
	function dlgModificar(pos)
{
	$('#mid').val(indicador[pos].id);
	$('#mpos').val(pos);
	$("#mNuevo_psdi_subproyecto :contains(" + indicador[pos].nombre_subproyecto+ ")").prop('selected', true);
	$("#mNuevo_psdi_frecuencia option:contains(" + indicador[pos].descripcion_frecuencia + ")").prop('selected', true);
	$("#mnuevo_psdi_calendar option:contains(" + indicador[pos].descripcion_calendario+ ")").prop('selected', true);
	$('#mNuevo_psdi_nombrecorto').val( indicador[pos].nombre_corto);
	$("#mNuevo_psdi_area option:contains(" + indicador[pos].descripcion_area+ ")").prop('selected', true);
	$("#mNuevo_psdi_perspectiva option:contains(" + indicador[pos].descripcion_perspectiva+ ")").prop('selected', true);
	$('#mnuevo_psdi_ingresado').val( indicador[pos].ingresado_por );
	$('#mnuevo_psdi_supervisor').val( indicador[pos].supervisado_por );
	$('#mnuevo_psdi_propietario').val(indicador[pos].dato_de);
	$('#mnuevo_psdi_indicador').val( indicador[pos].descripcion_indicador );
	$('#mNuevo_psdi_cantdias').val(indicador[pos].num_dias);
	console.log(indicador);
	if(indicador[pos].nivel != 1)
	{
		$('#mcapa_ingresado_por').css("display","none");
		$('#mcapa_ingresado_por').addClass('escondida');
		$('#mcapa_supervisado_por').css("display","none");
		$('#mcapa_supervisado_por').addClass('escondida');
		$('#mcapa_propietario').css("display","none");
		$('#mcapa_propietario').addClass('escondida');
		$('#mcapa_correo').css("display","none");
		$('#mcapa_correo').addClass('escondida');
		$('#mcapa_correo_dias').css("display","none");
		$('#mcapa_correo_dias').addClass('escondida');
		$('#mchkbx_correo').prop('checked',false);
		$('#mchkbx_correo').addClass('escondida');
		$('#mNuevo_psdi_cantdias').val(0);
		$('#mNuevo_psdi_cantdias').addClass('escondida');
	}
	else
	{
		$('#mcapa_ingresado_por').css("display","block");
		$('#mcapa_ingresado_por').removeClass('escondida');
		$('#mcapa_supervisado_por').css("display","block");
		$('#mcapa_supervisado_por').removeClass('escondida');
		$('#mcapa_propietario').css("display","block");
		$('#mcapa_propietario').removeClass('escondida');
		$('#mcapa_correo').css("display","block");
		$('#mcapa_correo').removeClass('escondida');
		$('#mcapa_correo_dias').css("display","block");
		$('#mcapa_correo_dias').removeClass('escondida');
	}
	$('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
	var r=confirm("Está seguro que desea eliminar " + $('.'+id).find('td:eq(0)').text() + ' ' + $('.'+id).find('td:eq(1)').text());
	if(r==true)
	{
		//alert('Ha solicitado eliminar.');
		$.ajax({
				type: "POST",
				url: "modelo/psdi.php",
				data: {
					funcion: "eliminar_psdi",
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