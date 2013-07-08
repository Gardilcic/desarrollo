$(window).load(function() {
    $.ajax({
        type: "POST",
        url: "modelo/mensajes.php",
        data: {
            funcion: "listar_mensajes"
        },
        success: function(datos)
        {
            //alert(datos);
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            var texto = "";
            texto+="<option value='0'>Escoja</option>";
            $.each(objeto, function(key, item)
            {
                texto += "<option value=" + objeto[key].id + ">"+ objeto[key].estado + " - " + objeto[key].emisor +" ( "+ objeto[key].fecha + " ) - " + objeto[key].titulo + "</option>";
            });

            $('#lista_mensajes').html(texto);

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


        }
    });

    $('#btnNuevoAceptar').click(function()
    {
        if ($('#mensaje_titulo').val() != '' && $('#receptor').val() != 0)
        {
            $('.mensajes').css('display', 'none');
            /*if($('#Nueva_moneda_nombre').val()>0 && $('#Nueva_moneda_simbolo').val()>0)
             {*/
            $.ajax({
                type: "POST",
                url: "modelo/mensajes.php",
                data:
                {
                    funcion: "nuevo_mensaje",
                    receptor:$('#receptor').val(),
                    titulo:$('#mensaje_titulo').val(),
                    mensaje:$('#mensaje_mensaje').val()
                },
                success: function(datos)
                {
                    //alert(datos);
                    if (datos == 0)
                    {
                        alert('AcciÛn realizada. Gracias.');
                        location.reload();
                    }
                    else
                    {
                        alert('El nombre del perfil solicitado ya existe.');
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
        url: "modelo/perfiles.php",
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

            $('#Nuevo_estado').html(texto);
            $('#mNuevo_estado').html(texto);

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/permisos_perfil.php",
        data: {
            funcion: "listar_perfiles"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#perfiles').html(texto);
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
            var texto = "<option value=0>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + decodeURIComponent(escape(objeto[key].usuario)) + ">" + decodeURIComponent(escape(objeto[key].nombre)) + "</option>";
            });

            $('#receptor').html(texto);
        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/paginas.php",
        data: {
            funcion: "listar_modulos"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
                //tabla_body
            });

            $('#modulos').html(texto);

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/permisos_perfil.php",
        data: {
            funcion: "listar_permisos"
        },
        success: function(datos)
        {
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#lista_permisos').html(texto);
        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        data: {
            funcion: "ListarSubProyectosAdmin"
        },
        success: function(datos)
        {
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                texto += "<option value=" + objeto[key].id_subproyectos + ">" + objeto[key].empresa_nombre + " - " + objeto[key].nombre + " - " + objeto[key].proyecto_nombre + "</option>";
            });

            $('#subproyectos').html(texto);
            $('#susuarios').trigger('change');
        }
    });


    $('#permisos').click(function() {
        if ($('#permisos option:selected').hasClass('sombreado')) {
            $('#permisos option:selected').removeClass('sombreado');
        }
        else {
            $('#permisos option:selected').addClass('sombreado');
        }
    });

    $('#lista_mensajes').change(function() {
        $.ajax({
            type: "POST",
            url: "modelo/mensajes.php",
            data: {
                funcion: "muestra_mensaje",
                id_mensaje: $('#lista_mensajes').val()
            },
            success: function(datos)
            {
                //alert(datos);
                $('#info_mensaje').html(datos);
				/*var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
	            var texto = "";
                $.each(objeto, function(key, item)
	            {
	                //alert(objeto[key].nombre);
	                texto += "<tr><td>" + objeto[key].emisor + "</td><td>" + objeto[key].fecha+ "</td>";
	                texto += "<td>" + objeto[key].titulo + "</td><td>" + objeto[key].mensaje+ "</td></tr>";
	                        //"<a class='btn btn-warning' codigo='"+objeto[key].id+"' onclick='dlgModificar("+objeto[key].id+")'><i class='icon-pencil icon-white'></i></a> "+
	                        //"<a class='btn btn-danger' codigo='" + objeto[key].id + "' onclick='dlgEliminar(" + objeto[key].id + ")'><i class='icon-remove icon-white'></i></a> " +
	                        //"</td></tr>";
	            });
	            $('#info_mensaje').html(texto);*/
            }
        });
    });


    $('#subproyectos').click(function() {
        if ($('#subproyectos option:selected').hasClass('sombreado')) {
            $('#subproyectos option:selected').removeClass('sombreado');
        }
        else {
            $('#subproyectos option:selected').addClass('sombreado');
        }
    });

    $('#marca').change(function() {
        if ($('#marca').is(':checked')) {
            $('#subproyectos option').addClass('sombreado');
        }
        else {
            $('#subproyectos option').removeClass('sombreado');
        }
    });

    $('#susuarios').change(function() {
        //ListarUsuarioSubproyecto
        $('#marca').removeAttr("checked");
        $('#subproyectos option').removeClass('sombreado');
        $.ajax({
            type: "POST",
            url: "modelo/usuarios.php",
            data: {
                funcion: "ListarUsuarioSubproyecto",
                idUsuario: $('#susuarios option:selected').val()
            },
            success: function(datos)
            {
                var objeto = eval(datos);
                if (objeto != null && typeof objeto != 'undefined' && objeto.length > 0) {

                    $.each(objeto, function(key, item) {
                        $('#subproyectos').find("option[value='" + objeto[key].id_subproyecto + "']").addClass('sombreado');
                    });
                }
            }
        });
    });

    $('#btnEditarAceptar').click(function()
    {
        if ($('#mNuevo_nombre').val() != '')
        {
            $('.mensajes').css('display', 'none');
            $.ajax(
                    {
                        type: "POST",
                        url: "modelo/perfiles.php",
                        data:
                                {
                                    funcion: "updt_perfil",
                                    id: $('#mid').val(),
                                    nombre: $('#mNuevo_nombre').val(),
                                    estado: $('#mNuevo_estado').val()
                                },
                        success: function(datos)
                        {
                            //alert(datos);
                            if (datos == 1)
                            {
                                alert('Acci√≥n realizada. Gracias.');
                                location.reload();
                            }
                            else
                            {
                                alert('Por alguna razÛn su solicitud no pudo realizarse. Por favor revise los datos enviados.');
                            }
                        }
                    });
        }
        else
        {
            $('.mensajes').show();
            $('#mensaje').html(" Por favor, introduzca un nombre para el m&oacute;dulo.");
        }
    });


    $('#btnEliminarAceptar').click(function() {
        $('.mensajes').css('display', 'none');

        $.ajax({
            type: "POST",
            url: "modelo/usuarios.php",
            data: {
                funcion: "EliminarUsuario",
                id: $('#IdRegistro').val()
            },
            success: function(datos) {
                //alert(datos);
                if (datos > 0) {

                    var row =
                            "<a class='btn btn-warning' codigo='" + $('#IdRegistro').val() + "' onclick='dlgModificar(" + $('#IdRegistro').val() + ")'><i class='icon-pencil icon-white'></i></a> " +
                            "<a class='btn btn-danger' href='#'><i class='icon-remove icon-white'></i></a>";

                    var $row = $(row),
                            resort = true,
                            callback = function(table) {
                        //alert('rows have been added!');
                    };

                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(0)').text($('#EditarNombre').val());
                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(1)').text($('#EditarApellido').val());
                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(2)').text($('#EditarRut').val());
                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(3)').text($('#mperfiles option:selected').text());
                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(4)').text($('#mestados option:selected').text());
                    $('table').find('tr.' + $('#IdRegistro').val()).find('td:eq(5)').html(row);

                    $("table").trigger("updateCell", [this, resort, callback]);

                    document.getElementById("form_nuevo").reset();
                    $('#dlgModificar').modal('hide');
                }
            }
        });
    });

   

});

function dlgModificar(id)
{
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
    //alert(id);
    $nombre = $('.' + id).find('td:eq(0)').text();
    $estado = $('.' + id).find('td:eq(1)').text();

    $('#mid').val(id);
    $('#mNuevo_nombre').val($('.' + id).find('td:eq(0)').text());
    $("#mNuevo_estado option:contains(" + $estado + ")").attr('selected', 'selected');
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
    var r = confirm("Est√° seguro que desea eliminar el perfil " + $('.' + id).find('td:eq(0)').text());
    if (r == true)
    {
        //alert('ID:'+id);
        $.ajax(
                {
                    type: "POST",
                    url: "modelo/perfiles.php",
                    data:
                            {
                                funcion: "valida_dependencia",
                                perfil: id
                            },
                    success: function(datos)
                    {
                        //alert(datos);
                        if (datos == 0)
                        {
                            $.ajax(
                                    {
                                        type: "POST",
                                        url: "modelo/perfiles.php",
                                        data:
                                                {
                                                    funcion: "borra_perfil",
                                                    perfil: id
                                                },
                                        success: function(data)
                                        {
                                            //alert(data);
                                            if (data == 0)
                                            {
                                                alert('Solicitud realizada.');
                                                location.reload();
                                            }
                                            else
                                            {
                                                alert('Por alg√∫n motivo no ha resultado lo solicitado.');
                                            }
                                        }
                                    });
                        }
                        else
                        {
                            alert('No es posible eliminar el perfil pues se encuentra asignado.');
                        }
                    }
                });
    }
}