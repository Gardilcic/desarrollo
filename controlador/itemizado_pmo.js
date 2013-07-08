var pmo = null;

$(window).load(function() {

    $.ajax({
        type: "POST",
        url: "modelo/itemizado_pmo.php",
        data: {
            funcion: "ListarItemizadoPMO"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "";
            var combo = "";
            pmo = objeto;
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id + " ><td>" +
                        objeto[key].codigo + "</td><td>" +
                        objeto[key].descripcion + "</td><td>" +
                        objeto[key].unidad_abreviacion + "</td><td>" +
                        objeto[key].factor_equivalencia + "</td><td>" +
                        objeto[key].version_nombre + "</td><td>" +
                        objeto[key].estado_nombre + "</td>";                       
                texto += "<td>" +
                        //"<a class='btn btn-success' codigo='" + objeto[key].id + "' onclick='dlgVer(" + key + ")'><i class='icon-search icon-white'></i></a> " +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                        //"<a class='btn btn-danger' codigo='"+objeto[key].id_proyecto+"' onclick='dlgEliminar("+objeto[key].id_proyecto+")'><i class='icon-remove icon-white'></i></a> "+
                        "</td></tr>";
                        
                //para cargar los combos de itemizados
                combo += "<option value=" + objeto[key].id + " >" + objeto[key].codigo +" "+ objeto[key].descripcion + "</option>";

            });

            $('#tabla_body').html(texto);
            $('#padre').append(combo);
            $('#mpadre').append(combo);

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
                sortList: [[0, 0]],
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
 
     // OBTENER EL CORRELATIVO PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/itemizado_pmo.php",
        data: {
            funcion: "ObtenerCorrelativoPMO",
            idpadre: 0
        },
        success: function(datos) {
            var objeto = eval(datos);
            $('#codigo').val(objeto[0].codigo);
            $('#mcodigo').val(objeto[0].codigo);
        }
    });
 
    // LISTAR MONEDAS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/unidades.php",
        data: {
            funcion: "ListarUnidades"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + " simbolo=" + objeto[key].abreviacion + ">" + objeto[key].nombre + "</option>";
            });

            $('#unidades').html(texto);
            $('#unidades').html(texto);
            $('#vunidades').html(texto);
            $('#munidades').html(texto);
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
    
    // OBTENER EL CORRELATIVO PARA LOS COMBOBOX
    $('#padre').change(function(){
        //alert($('#padre option:selected').val());
        $.ajax({
            type: "POST",
            url: "modelo/itemizado_pmo.php",
            data: {
                funcion: "ObtenerCorrelativoPMO",
                idpadre: $('#padre option:selected').val()
            },
            success: function(datos) {
                //alert(datos);
                var objeto = eval(datos);
                $('#codigo').val(objeto[0].codigo);                
            }
        });
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

            $('#empresas').html(texto);
        }
    });
    
    // FUNCIONES DE LOS BOTONES DE LOS DIALOGOS
    $('#btnVerCancelar').click(function() {
        $('#dlgVer').modal('hide');
    });
    $('#btnNuevoAceptar').click(function() {
        //alert('aaaa');
        $('.mensajes').css('display', 'none');

        if ($('#codigo').val().length > 0 && $('#descripcion').val().length > 0 && $('#factor').val().length > 0 && 
                $('#padre').val() >= 0 && $('#unidades').val() > 0 && $('#estado').val() > 0 ) {

            $.ajax({
                type: "POST",
                url: "modelo/itemizado_pmo.php",
                data: {
                    funcion: "GrabarNuevo",
                    codigo: $('#codigo').val(),
                    descripcion: $('#descripcion').val(),
                    factor: $('#factor').val(),
                    idpadre: $('#padre').val(),
                    idunidad: $('#unidades').val(),
                    idestado: $('#estado').val(),
                    idempresa: $('#empresas').val(),
                    idversion: 4
                },
                success: function(datos) {
                    //alert(datos);                    
                    
                    var nombre = "";
                    
                    if($('#padre option:selected').val()==0) nombre = "";
                    else {
                        nombre = $('#padre option:selected').text();
                        nombre = nombre.split(' ');
                        nombre = nombre[0] + ".";
                    }
                    
                    if (datos > 0) {
                        var row = '<tr class="' + datos + '"><td>' + nombre + $('#codigo').val() + '</td><td>' +
                                $('#descripcion').val() + '</td><td>' +
                                $('#unidades option:selected').attr('simbolo') + '</td><td>' +
                                $('#factor').val() + '</td><td>' +
                                pmo[0].version_nombre + '</td><td>' +
                                $('#estado option:selected').text() + '</td>';

                        row += "<td>" +
                                //"<a class='btn btn-success' codigo='" + datos + "' onclick='dlgVer(" + pmo.length + ")'><i class='icon-search icon-white'></i></a> " +
                                "<a class='btn btn-warning' codigo='" + datos + "' onclick='dlgModificar(" + pmo.length + ")'><i class='icon-pencil icon-white'></i></a> " +
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

        if ($('#mdescripcion').val().length > 0 && $('#mfactor').val().length > 0 &&                
                $('#mestado').val() > 0 && $('#munidades').val() > 0 ) {

            $.ajax({
                type: "POST",
                url: "modelo/itemizado_pmo.php",
                data: {
                    funcion: "GrabarItemizadoPMO",
                    id: $('#midregistro').val(),
                    descripcion: $('#mdescripcion').val(),
                    factor: $('#mfactor').val(),
                    idunidad: $('#munidades').val(),
                    idestado: $('#mestado').val()
                },
                success: function(datos) {
                    //alert(datos);
                    if (datos > 0) {

                        var resort = true,
                                callback = function(table) {
                            //alert('rows have been added!');
                        };

                        //$('table').find('tr.' + $('#midregistro').val()).find('td:eq(0)').text($('mcodigo').val());
                        //$('table').find( 'tr.'+$('#midregistro').val() ).find('td:eq(1)').text($('#mnumero').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(1)').text($('#mdescripcion').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(2)').text($('#munidades option:selected').attr('simbolo'));
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(3)').text($('#mfactor').val());
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(4)').text(pmo[0].version_nombre);
                        $('table').find('tr.' + $('#midregistro').val()).find('td:eq(5)').text($('#mestado option:selected').text());

                        //$('table').find('tr.' + $('#midregistro').val()).find('td:eq(1)').text($('#mnumero').val());

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

    $('#btnEliminarAceptar').click(function() {
        $('.mensajes').css('display', 'none');

        $.ajax({
            type: "POST",
            url: "modelo/turnos.php",
            data: {
                funcion: "Eliminar",
                id: $('#mIdRegistro').val()
            },
            success: function(datos) {
                if (datos > 0) {
                    var t = $('table');
                    var tmp = $('#mIdRegistro').val();

                    t.trigger('disable.pager');
                    $('.' + tmp).closest('tr').remove();
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

function dlgModificar(nro) {
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO	
    $('#midregistro').val(pmo[nro].id);    
    
    $('#mcodigo').val(pmo[nro].codigo);
    $('#mdescripcion').val(pmo[nro].descripcion);
    $('#mfactor').val(pmo[nro].factor_equivalencia);
    
    $('#munidades').val(pmo[nro].id_unidad);
    $('#mestado').val(pmo[nro].id_estado);
    
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id) {
    $('#mIdRegistro').val(id);
    $('#dlgEliminar').modal('show');
}

function dlgVer(nro) {

    $('#vnombre').val(subproyectos[nro].nombre);
    $('#vfechainicio').val(subproyectos[nro].fecha_inicio);
    $('#vfechafinal').val(subproyectos[nro].fecha_termino);
    $('#vmonto').val(subproyectos[nro].monto);

    $('#vmandante').val(subproyectos[nro].id_mandante);
    $('#vmoneda').val(subproyectos[nro].id_moneda);
    $('#vempresa').val(subproyectos[nro].id_empresa);
    $('#vestado').val(subproyectos[nro].id_estado);
    $('#vproyecto').val(subproyectos[nro].id_proyectos);

    $('#dlgVer').modal('show');
}

