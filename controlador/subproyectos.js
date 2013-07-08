var subproyectos = null;

$(window).load(function() {

    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        data: {
            funcion: "ListarSubProyectos"
        },
        success: function(datos) {
        //alert(datos);
            var objeto = eval(datos);
            var texto = "";
            subproyectos = objeto;
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id_subproyectos + " ><td>" +
                        objeto[key].nombre + "</td><td>" +
                        objeto[key].fecha_inicio + "</td><td>" +
                        objeto[key].fecha_termino + "</td><td>" +
                        objeto[key].monto + "</td><td>" +
                        objeto[key].moneda_simbolo + "</td><td>" +
                        objeto[key].proyecto_nombre + "</td><td>" +
                        objeto[key].ubicacion_nombre + "</td><td>" +
                        objeto[key].estado_nombre + "</td>";
                texto += "<td>" +
                        "<a class='btn btn-success' codigo='" + objeto[key].id + "' onclick='dlgVer(" + key + ")'><i class='icon-search icon-white'></i></a> " +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='"+objeto[key].id_proyecto+"' onclick='dlgEliminar("+objeto[key].id_subproyectos+")'><i class='icon-remove icon-white'></i></a> "+
                        "</td></tr>";
            });

            $('#tabla_body').html(texto);

            /////////////////////////////////////////////////////////////
            $.extend($.tablesorter.themes.bootstrap, {
                // these classes are added to the table. To see other table classes available,
                // look here: http://twitter.github.com/bootstrap/base-css.html#tables
                table: 'table table-bordered',
                header: 'bootstrap-header', // give the header a gradient background
                footerRow: '',
                footerCells: '',
                icons: '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
                sortNone: 'bootstrap-icon-unsorted',
                sortAsc: 'icon-chevron-up',
                sortDesc: 'icon-chevron-down',
                active: '', // applied when column is sorted
                hover: '', // use custom css here - bootstrap class may not override it
                filterRow: '', // filter row class
                even: '', // odd row zebra striping
                odd: ''  // even row zebra striping
            });

            // call the tablesorter plugin and apply the uitheme widget
            $("table").tablesorter({
                // this will apply the bootstrap theme if "uitheme" widget is included
                // the widgetOptions.uitheme is no longer required to be set
                theme: "bootstrap",
                sortList: [[0, 0], [1, 0]],
                widthFixed: true,
                headerTemplate: '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!

                // widget code contained in the jquery.tablesorter.widgets.js file
                // use the zebra stripe widget if you plan on hiding any rows (filter widget)
                widgets: ["uitheme", "filter", "zebra"],
                widgetOptions: {
                    // using the default zebra striping class name, so it actually isn't included in the theme variable above
                    // this is ONLY needed for bootstrap theming if you are using the filter widget, because rows are hidden
                    zebra: ["even", "odd"],
                    // reset filters button
                    filter_reset: ".reset"

                            // set the uitheme widget to use the bootstrap theme class names
                            // this is no longer required, if theme is set
                            // ,uitheme : "bootstrap"

                }
            }).tablesorterPager({
                // target the pager markup - see the HTML block below
                container: $(".pager"),
                // target the pager page select dropdown - choose a page
                cssGoto: ".pagenum",
                // remove rows from the table to speed up the sort of large tables.
                // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
                removeRows: false,
                // output string - default is '{page}/{totalPages}';
                // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
                output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

            });

            //$("tbody tr td").css("background-color", "orange");

        }
    });
    // LISTAR PROYECTOS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        async: false,
        data: {
            funcion: "ListarProyectos"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#proyecto').html(texto);
            $('#vproyecto').html(texto);
            $('#mproyecto').html(texto);
        }
    });
    // LISTAR MANDANTES PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/mandantes.php",
        async: false,
        data: {
            funcion: "ListarMandantes"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#mandante').html(texto);
            $('#vmandante').html(texto);
            $('#mmandante').html(texto);
        }
    });
    // LISTAR MONEDAS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/monedas.php",
        async: false,
        data: {
            funcion: "listar_monedas"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#moneda').html(texto);
            $('#moneda option:eq(1)').prop('selected', true);
            $('#vmoneda').html(texto);
            $('#mmoneda').html(texto);
        }
    });
    // LISTAR EMPRESAS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/empresas.php",
        async: false,
        data: {
            funcion: "listar_empresas"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#empresa').html(texto);
            $('#vempresa').html(texto);
            $('#mempresa').html(texto);
        }
    });
    // LISTAR ESTADOS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/estados.php",
        async: false,
        data: {
            funcion: "ListarEstados"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#estado').html(texto);
            $('#estado option:eq(1)').attr('selected', 'true');
            $('#vestado').html(texto);
            $('#mestado').html(texto);
        }
    });
    // LISTAR ESTADOS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/ubicaciones.php",
        async: false,
        data: {
            funcion: "listar_ubicaciones"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#ubicacion').html(texto);
            $('#vubicacion').html(texto);
            $('#mubicacion').html(texto);
        }
    });
    
    $('#btnVerCancelar').click(function() {
        $('#dlgVer').modal('hide');
    });
    $('#btnNuevoAceptar').click(function() {
        //alert('aaaa');
        $('.mensajes').css('display', 'none');
        if ($('#nombre').val().length > 0 && $('#fechainicio').val().length > 0 && $('#fechafinal').val().length > 0 &&
                $('#monto').val().length > 0 && $('#proyecto').val() > 0 && $('#ubicacion').val() > 0 && $('#moneda').val() > 0 &&
                $('#empresa').val() > 0 && $('#mandante').val() > 0 && $('#estado').val() > 0) {

            $.ajax({
                type: "POST",
                url: "modelo/subproyectos.php",
                data: {
                    funcion: "GrabarNuevo",
                    nombre: $('#nombre').val(),
                    fechainicio: $('#fechainicio').val(),
                    fechafinal: $('#fechafinal').val(),
                    monto: $('#monto').val(),
                    idproyecto: $('#proyecto').val(),
                    idubicacion: $('#ubicacion').val(),
                    idmoneda: $('#moneda').val(),
                    idempresa: $('#empresa').val(),
                    idmandante: $('#mandante').val(),
                    idestado: $('#estado').val()
                },
                success: function(datos) {
                    //alert(datos);
                    if (datos > 0) {
                    	location.reload();
                        /*var row = '<tr class="' + datos + '"><td>' + $('#nombre').val() + '</td><td>' +
                                $('#fechainicio').val() + '</td><td>' +
                                $('#fechafinal').val() + '</td><td>' +
                                $('#monto').val() + '</td><td>' +
                                $('#moneda option:selected').text() + '</td><td>' +
                                $('#proyecto option:selected').text() + '</td><td>' +
                                $('#ubicacion option:selected').text() + '</td><td>' +
                                $('#estado option:selected').text() + '</td>';

                        row += "<td>" +
                                "<a class='btn btn-success' codigo='" + datos + "' onclick='dlgVer(" + subproyectos.length + ")'><i class='icon-search icon-white'></i></a> " +
                                "<a class='btn btn-warning' codigo='" + datos + "' onclick='dlgModificar(" + subproyectos.length + ")'><i class='icon-pencil icon-white'></i></a> " +
                                //"<a class='btn btn-danger' codigo='"+datos+"' onclick='dlgEliminar("+proyectos.length+")'><i class='icon-remove icon-white'></i></a> "+
                                "</td></tr>";

                        var $row = $(row),
                                resort = true,
                                callback = function(table) {
                            //alert('rows have been added!');
                        };

                        $('table')
                                .find('tbody').append($row)
                                .trigger('addRows', [$row, resort, callback]);

                        document.getElementById("form_nuevo").reset();
                        $('#dlgAgregar').modal('hide');

                        //$('#estados').html(texto);*/
                    }
                    else
                    {
                    	alert('No se ha podido completar la solicitud. Verifique que est�n todos los datos.');
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

    $('#btnEditarAceptar').click(function() {
        $('.mensajes').css('display', 'none');
		//alert('ENTRA A EDITAR, regiostro: '+$('#midregistro').val());
        if ($('#mnombre').val().length > 0) {
			//alert('validador de campos en blanco OK');
            $.ajax({
                type: "POST",
                url: "modelo/subproyectos.php",
                data: {
                    funcion: "GrabarSubProyecto",
                    id: $('#midregistro').val(),
                    nombre: $('#mnombre').val(),
                    fechainicio: $('#mfechainicio').val(),
                    fechafinal: $('#mfechafinal').val(),
                    monto: $('#mmonto').val(),
                    idproyecto: $('#mproyecto').val(),
                    idubicacion: $('#mubicacion').val(),
                    idmoneda: $('#mmoneda').val(),
                    idempresa: $('#mempresa').val(),
                    idmandante: $('#mmandante').val(),
                    idestado: $('#mestado').val()
                },
                success: function(datos) 
                {
                    //alert(datos);
                    if (datos > 0) {

                        location.reload();
                        //document.getElementById("form_nuevo").reset();				
                        $('#dlgModificar').modal('hide');

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

    

});

function dlgModificar(nro) {
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO	
    $('#midregistro').val(subproyectos[nro].id_subproyectos);
    
    $('#mnombre').val(subproyectos[nro].nombre);
    $('#mfechainicio').val(subproyectos[nro].fecha_inicio);
    $('#mfechafinal').val(subproyectos[nro].fecha_termino);
    $('#mmonto').val(subproyectos[nro].monto);

    $('#mmandante').val(subproyectos[nro].id_mandante);
    $('#mmoneda').val(subproyectos[nro].id_moneda);
    $('#mempresa').val(subproyectos[nro].id_empresas);
    $('#mestado').val(subproyectos[nro].id_estado);
    $('#mproyecto').val(subproyectos[nro].id_proyectos);
    $('#mubicacion').val(subproyectos[nro].id_ubicacion);

    $('#dlgModificar').modal('show');
}

function dlgVer(nro) {

    $('#vnombre').val(subproyectos[nro].nombre);
    $('#vfechainicio').val(subproyectos[nro].fecha_inicio);
    $('#vfechafinal').val(subproyectos[nro].fecha_termino);
    $('#vmonto').val(subproyectos[nro].monto);

    $('#vmandante').val(subproyectos[nro].id_mandante);
    $('#vmoneda').val(subproyectos[nro].id_moneda);
    $('#vempresa').val(subproyectos[nro].id_empresas);
    $('#vestado').val(subproyectos[nro].id_estado);
    $('#vproyecto').val(subproyectos[nro].id_proyectos);

    $('#dlgVer').modal('show');
}

function dlgEliminar(id)
{
	var r=confirm("Está seguro que desea eliminar el subproyecto " + $('.'+id).find('td:eq(0)').text());
	if(r==true)
	{
		//alert('ID=' + id);
		$.ajax(
		{
			type: "POST",
			url: "modelo/subproyectos.php",
			data: 
			{
				funcion: "valida_dependencia",
				subproyecto: id
			},
			success: function(datos)
			{
				//alert(datos);
				if(datos==0)
				{
					$.ajax(
					{
						type: "POST",
						url: "modelo/subproyectos.php",
						data: 
						{
							funcion: "borra_subproyecto",
							subproyecto: id
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
					alert('No es posible eliminar el proyecto pues se encuentra asignada.');
				}
			}
		});
	}
}

