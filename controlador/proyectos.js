var proyectos = null;

$(window).load(function() {

    $.ajax({
        type: "POST",
        url: "modelo/proyectos.php",
        data: {
            funcion: "ListarProyectosCompleto"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "";
            proyectos = objeto;
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id_proyecto + " ><td>" +
                        objeto[key].nombre_proyecto + "</td><td>" +
                        objeto[key].numero_contrato + "</td><td>" +
                        objeto[key].fecha_inicio + "</td><td>" +
                        objeto[key].fecha_fin + "</td><td>" +
                        objeto[key].monto + "</td><td>" +
                        objeto[key].moneda_nombre + "</td><td>" +
                        objeto[key].mandante_nombre + "</td><td>" +
                        objeto[key].estado_nombre + "</td>";
                texto += "<td>" +
                        "<a class='btn btn-success' codigo='" + objeto[key].id_proyecto + "' onclick='dlgVer(" + key + ")'><i class='icon-search icon-white'></i></a> " +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id_proyecto + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='"+objeto[key].id_proyecto+"' onclick='dlgEliminar("+objeto[key].id_proyecto+")'><i class='icon-remove icon-white'></i></a> "+
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
            funcion: "ListarMonedas"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#moneda').html(texto);
            $('#moneda option:eq(1)').attr('selected', 'true');
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

    $('#btnVerCancelar').click(function() {
        $('#dlgVer').modal('hide');
    });
    $('#btnNuevoAceptar').click(function() {
        $('.mensajes').css('display', 'none');
        if ($('#nombre').val().length > 0 && $('#numero').val().length > 0 && $('#firmante1').val().length > 0 &&
                $('#fechainicio').val().length > 0 && $('#fechafinal').val().length > 0 && $('#firmante2').val().length > 0 &&
                $('#empresa').val() > 0 && $('#mandante').val() > 0 && $('#estado').val() > 0) {

            $.ajax({
                type: "POST",
                url: "modelo/proyectos.php",
                data: {
                    funcion: "GrabarNuevo",
                    nombre: $('#nombre').val(),
                    numero: $('#numero').val(),
                    archivo: $('#archivo').val(),
                    firmante1: $('#firmante1').val(),
                    firmante2: $('#firmante2').val(),
                    fechainicio: $('#fechainicio').val(),
                    fechafinal: $('#fechafinal').val(),
                    idmoneda: $('#moneda').val(),
                    monto: $('#monto').val(),
                    idempresa: $('#empresa').val(),
                    idmandante: $('#mandante').val(),
                    idestado: $('#estado').val()
                },
                success: function(datos) {
                    //alert(datos);
                    if (datos > 0) {
                        /*var row = '<tr class="' + datos + '"><td>' + $('#nombre').val() + '</td><td>' +
                                $('#numero').val() + '</td><td>' +
                                $('#fechainicio').val() + '</td><td>' +
                                $('#fechafinal').val() + '</td><td>' +
                                $('#monto').val() + '</td><td>' +
                                $('#moneda option:selected').text() + '</td><td>' +
                                $('#mandante option:selected').text() + '</td><td>' +
                                $('#estado option:selected').text() + '</td>';

                        row += "<td>" +
                                "<a class='btn btn-success' codigo='" + datos + "' onclick='dlgVer(" + proyectos.length + ")'><i class='icon-search icon-white'></i></a> " +
                                "<a class='btn btn-warning' codigo='" + datos + "' onclick='dlgModificar(" + proyectos.length + ")'><i class='icon-pencil icon-white'></i></a> " +
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
                        */
                        document.getElementById("form_nuevo").reset();
                        $('#dlgAgregar').modal('hide');

                        //$('#estados').html(texto);
                        location.reload();
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
		
        if ($('#mnombre').val().length > 0 && $('#mnumero').val().length > 0 && $('#mfirmante1').val().length > 0 &&
                $('#mfechainicio').val().length > 0 && $('#mfechafinal').val().length > 0 && $('#mfirmante2').val().length > 0 &&
                $('#mempresa').val() > 0 && $('#mmandante').val() > 0 && $('#mestado').val() > 0) {


            $.ajax({
                type: "POST",
                url: "modelo/proyectos.php",
                data: {
                    funcion: "GrabarProyecto",
                    id: $('#midregistro').val(),
                    nombre: $('#mnombre').val(),
                    numero: $('#mnumero').val(),
                    firmante1: $('#mfirmante1').val(),
                    firmante2: $('#mfirmante2').val(),
                    fechainicio: $('#mfechainicio').val(),
                    fechafinal: $('#mfechafinal').val(),
                    idmoneda: $('#mmoneda').val(),
                    monto: $('#mmonto').val(),
                    idempresa: $('#mempresa').val(),
                    idmandante: $('#mmandante').val(),
                    idestado: $('#mestado').val()
                },
                success: function(datos) {
                    alert(datos);
                    if (datos > 0) {

                        var resort = true,
                                callback = function(table) {
                            //alert('rows have been added!');
                        };

                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(0)').text($('#mnombre').val());
                        //$('table').find( 'tr.'+$('#midregistro').val() ).find('td:eq(1)').text($('#mnumero').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(2)').text($('#mfechainicio').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(3)').text($('#mfechafinal').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(1)').text($('#mfechainicio').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(4)').text($('#mmonto').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(5)').text($('#mmoneda option:selected').text());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(6)').text($('#mmandante option:selected').text());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(7)').text($('#mestado option:selected').text());

                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(1)').text($('#mnumero').val());

                        $("table").trigger("updateCell", [this, resort, callback]);

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

function dlgEliminar(id)
{
	var r=confirm("Est� seguro que desea eliminar el proyecto " + $('.'+id).find('td:eq(0)').text());
	if(r==true)
	{
		//alert('Ha solicitado eliminar.');
		$.ajax(
		{
			type: "POST",
			url: "modelo/proyectos.php",
			data: 
			{
				funcion: "valida_dependencia",
				proyecto: id
			},
			success: function(datos)
			{
				//alert(datos);
				if(datos==0)
				{
					$.ajax(
					{
						type: "POST",
						url: "modelo/proyectos.php",
						data: 
						{
							funcion: "borra_proyecto",
							proyecto: id
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
								alert('Por alg�n motivo no ha resultado lo solicitado.');
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


function dlgModificar(nro) {
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO	
    if (proyectos[nro].archivo_contrato == null)
        archivo = "";
    else
        archivo = proyectos[nro].archivo_contrato;

    $('#midregistro').val(proyectos[nro].id_proyecto);

    $('#mnombre').val(proyectos[nro].nombre_proyecto);
    $('#mnumero').val(proyectos[nro].numero_contrato);
    //$('#marchivo').val(proyectos[nro].archivo_contrato);
    $('#mfirmante1').val(proyectos[nro].firmante1);
    $('#mfirmante2').val(proyectos[nro].firmante2);
    $('#mfechainicio').val(proyectos[nro].fecha_inicio);
    $('#mfechafinal').val(proyectos[nro].fecha_fin);
    $('#mmonto').val(proyectos[nro].monto);

    $('#dlgModificar').find('#image-list').html('<li>' + archivo + '</li>');

    $('#mmandante').val(proyectos[nro].id_mandante);
    $('#mmoneda').val(proyectos[nro].id_moneda);
    $('#mempresa').val(proyectos[nro].id_empresa_holding);
    $('#mestado').val(proyectos[nro].id_estados_proyecto);

    $('#dlgModificar').modal('show');
}

function dlgVer(nro) {

    if (proyectos[nro].archivo_contrato == null)
        archivo = "";
    else
        archivo = proyectos[nro].archivo_contrato;

    $('#vnombre').val(proyectos[nro].nombre_proyecto);
    $('#vnumero').val(proyectos[nro].numero_contrato);
    $('#varchivo').val(proyectos[nro].archivo_contrato);
    $('#vfirmante1').val(proyectos[nro].firmante1);
    $('#vfirmante2').val(proyectos[nro].firmante2);
    $('#vfechainicio').val(proyectos[nro].fecha_inicio);
    $('#vfechafinal').val(proyectos[nro].fecha_fin);
    $('#vmonto').val(proyectos[nro].monto);
    $('#varchivo').text(archivo);

    $('#vmandante').val(proyectos[nro].id_mandante);
    $('#vmoneda').val(proyectos[nro].id_moneda);
    $('#vempresa').val(proyectos[nro].id_empresa_holding);
    $('#vestado').val(proyectos[nro].id_estados_proyecto);

    $('#dlgVer').modal('show');
}

