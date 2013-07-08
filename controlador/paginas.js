var permisos = "";

$(window).load(function() {

    /* INICIO DE SUBMENUS */
    $.ajax({
        type: "POST",
        url: "modelo/modulos.php",
        async: false,
        data: {
            funcion: "listar_modulos"
        },
        success: function(datos)
        {
            var objeto = eval(datos);
            var texto = "<option value=0>Seleccione un Modulo</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + item.id + ">" + item.nombre + "</option>";
            });

            $('#modulos').html(texto);
        }
    });

    // CARGO LAS OPCIONES DEL MENU
    $('#modulos').change(function() {
        $.ajax({
            type: "POST",
            url: 'modelo/menus.php',
            data: {
                funcion: "ListarMenu",
                modulo: $('#modulos').val()
            },
            async: false,
            success: function(datos) {
                var objeto = eval(datos);
                var texto = "";
                if (objeto) {
                    var texto = "<option>Seleccione Menu</option>";
                    $.each(objeto, function(key, item) {
                        texto += "<option value=" + item.id + ">" + item.nombre + "</option>";
                    });
                    //$('#menu').html(texto);
                }
                else {
                    texto += "<option value='0' >Sin Menu Asociado</option>";
                }
                $('#menu').html(texto);
                $('#menu option').trigger('change');
            }
        });
    });

    // CARGAR EL LISTADO DE PERMISOS O PAGINAS
    $('#menu').change(function() {
        $.ajax({
            type: "POST",
            url: 'modelo/paginas.php',
            data: {
                funcion: "ListarPermisosMenu",
                modulo: $('#modulos').val()
            },
            async: false,
            success: function(datos) {
                var objeto = eval(datos);
                var texto = "";
                permisos = objeto;
                $.each(objeto, function(key, item) {
                    //console.log(item);
                    if (!item.submenu_id)
                        texto += "<li value=" + item.id + ">" + item.nombre + "</li>";
                });
                $('#paginas').html(texto);
            }
        });

        $.ajax({
            type: "POST",
            url: 'modelo/menus.php',
            data: {
                funcion: "ListarSubMenu"
            },
            async: false,
            success: function(datos) {
                var objeto = eval(datos);
                if(objeto){
                    var texto = "";
                    //console.log(objeto);
                    $.each(objeto, function(key, item) {
                        //console.log(item);
                        if (item.menu_id == $('#menu').val()) {
                            texto += "<div codigo='" + item.id + "' class='submenus'><p>" + item.nombre + "</p><ul id='submenu-" + item.id + "' class='droptrue' >";
                            $.each(permisos, function(key, subitem) {
                                //console.log(subitem);
                                if (subitem.submenu_id == item.id)
                                    texto += "<li value=" + subitem.id + ">" + subitem.nombre + "</li>";
                            });
                            texto += "</ul></div>";
                        }
                    });

                    $('#submenus').html(texto);
                    // HACER QUE LAS LISTAS PUEDAN MOVERSE
                    $("ul.droptrue").sortable({
                        connectWith: "ul",
                        items: "> li",
                        stop: function(event, ui) {
                            //console.log(ui.item.parent().attr('id'));
                            if(ui.item.parent().attr('id')=="paginas"){
                                $.ajax({
                                    type: "POST",
                                    url: "modelo/paginas.php",
                                    data: {
                                        funcion: "DesvincularPaginaDelMenu",
                                        pagina: ui.item.attr('value')
                                    },
                                    success: function(datos) {
                                        //alert(datos);
                                        $('.mensajes_menu').show();
                                        $('#mensaje_menu').html(" Se ha desvinculado del menu a : "+ui.item.text());
                                        $('.mensajes_menu').fadeIn(400).delay(3000).fadeOut(400);
                                        $('#menu option').trigger('change');
                                    }
                                });
                            }
                            //alert($( "#submenus" ).sortable( "option", "items" ));
                        }
                    });

                    $("#submenus").sortable({
                    }).disableSelection();
                }
            }
        });
    });
    $('#btnNuevoSubMenu').click(function() {
        $('#form-nuevo-submenu').fadeIn(400).css('display', 'block');
    });
    $('#btnCerrarNuevoSubMenu').click(function() {
        $('#form-nuevo-submenu').fadeOut(400);
    });

    $('#btnGrabarNuevoSubMenu').click(function() {
        $.ajax({
            type: "POST",
            url: "modelo/menus.php",
            data: {
                funcion: "NuevoSubMenu",
                nombre: $('#nombreSubMenu').val(),
                menu: $('#menu').val()
            },
            success: function(datos) {
                //alert(datos);
                //$('.mensajes').show();
                //$('#mensaje').html(" Por favor, introduzca un nombre válido.");
                $('#menu option').trigger('change');
                //LIMPIO EL FORMULARIO DE NUEVO SUBMENU
                $('#nombreSubMenu').val('');
                $('#form-nuevo-submenu').fadeOut(400).css('display', 'none');
            }
        });
    });

    $('#btnGabarMenus').click(function() {
        var menus = [];
        var orden_submenus = [];
        $('.submenus').each(function(key, item) {
            var id_submenu = $(this).attr('codigo');
            $(this).find('ul li').each(function(key, item) {
                var menu = {};
                menu.id_submenu = id_submenu;
                menu.id_permiso = $(this).attr('value');
                menu.orden = key + 1;
                menus.push(menu);
            });

            var orden_submenu = {};
            orden_submenu.id_submenu = id_submenu;
            orden_submenu.orden = key + 1;
            orden_submenus.push(orden_submenu);
        });
        $.ajax({
            type: "POST",
            url: "modelo/menus.php",
            data: {
                funcion: "ActualizarMenu",
                datos: menus
            },
            success: function(datos) {
                if (datos >= 1) {
                    $('.mensajes_menu').show();
                    $('#mensaje_menu').html(" Se ha grabado correctamente los cambios.");
                    $('.mensajes_menu').fadeIn(400).delay(3000).fadeOut(400);
                    $('#menu option').trigger('change');
                }
                else
                    alert('Error no se pudo grabar los cambios realizados.');
            }
        });
        // ACTUALIZAR EL ORDEN DE LOS SUBMENU
        $.ajax({
            type: "POST",
            url: "modelo/menus.php",
            data: {
                funcion: "ActualizarSubMenu",
                datos: orden_submenus
            },
            success: function(datos) {
                if (datos >= 1) {
                    //$('#menu option').trigger('change');
                } else
                    alert('Error no se pudo grabar los cambios realizados.');
            }
        });
    });
    /* FIN DE SUBMENUS */

    $.ajax({
        type: "POST",
        url: "modelo/paginas.php",
        data: {
            funcion: "listar_paginas"
        },
        success: function(datos)
        {
            //alert(datos);
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            data = objeto;
            var texto = "";
            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id + "><td>" + objeto[key].nombre + "</td><td>" + objeto[key].url + "</td><td>" + objeto[key].modulo + "</td><td>" + objeto[key].estado + "</td>";
                //texto += "<td>"+objeto[key].objetivo+"</td><td>"+objeto[key].detalle+"</td><td>"+objeto[key].documento+"</td>"
                texto += "<td>" +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='" + objeto[key].id + "' onclick='dlgEliminar(" + objeto[key].id + ")'><i class='icon-remove icon-white'></i></a> " +
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


        }
    });


    $('#btnNuevoAceptar').click(function()
    {
        if ($('#Nuevo_nombre').val() != '')
        {
            $('.mensajes').css('display', 'none');
            /*if($('#Nueva_moneda_nombre').val()>0 && $('#Nueva_moneda_simbolo').val()>0)
             {*/
            $.ajax({
                type: "POST",
                url: "modelo/paginas.php",
                data:
                        {
                            funcion: "nuevo_permiso",
                            nombre: $('#Nuevo_nombre').val(),
                            url: $('#Nuevo_url').val(),
                            modulo: $('#Nuevo_modulo').val(),
                            estado: $('#Nuevo_estado').val(),
                            objetivo: $('#Nuevo_objetivo').val(),
                            detalle: $('#Nuevo_detalle').val()
                        },
                success: function(datos)
                {
                    //alert(datos);
                    if (datos == 0)
                    {
                        alert('Acción realizada. Gracias.');
                        location.reload();
                    }
                    else
                    {
                        alert('El nombre solicitado ya existe.');
                    }
                }
            });
        }
        else
        {
            $('.mensajes').show();
            $('#mensaje').html(" Por favor, introduzca un nombre válido.");
        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/paginas.php",
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
        url: "modelo/paginas.php",
        data: {
            funcion: "listar_modulos"
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

            $('#Nuevo_modulo').html(texto);
            $('#mNuevo_modulo').html(texto);

        }
    });

    $('#btnEditarAceptar').click(function()
    {
        if ($('#mNuevo_nombre').val() != '')
        {
            $('.mensajes').css('display', 'none');
            $.ajax(
                    {
                        type: "POST",
                        url: "modelo/paginas.php",
                        data:
                                {
                                    funcion: "updt_pagina",
                                    id: $('#mid').val(),
                                    nombre: $('#mNuevo_nombre').val(),
                                    url: $('#mNuevo_url').val(),
                                    modulo: $('#mNuevo_modulo').val(),
                                    estado: $('#mNuevo_estado').val(),
                                    objetivo: $('#mNuevo_objetivo').val(),
                                    detalle: $('#mNuevo_detalle').val()
                                },
                        success: function(datos)
                        {
                            //alert(datos);
                            if (datos == 1)
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
            $('#mensaje').html(" Por favor, introduzca un nombre válido.");
        }
    });

    $('#btnEliminarAceptar').click(function() {
        $('.mensajes').css('display', 'none');

        $.ajax({
            type: "POST",
            url: "modelo/paginas.php",
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
    //console.log(data);
    $nombre = $('.' + id).find('td:eq(0)').text();
    //$url =$('.'+data[id].url).find('td:eq(1)').text();
    $modulo = $('.' + id).find('td:eq(2)').text();
    $estado = $('.' + id).find('td:eq(3)').text();

    $('#mid').val(data[id].id);
    $('#mNuevo_nombre').val($('.' + data[id].id).find('td:eq(0)').text());
    $('#mNuevo_url').val(data[id].url);
    $("#mNuevo_modulo option:contains(" + data[id].modulo + ")").prop('selected', true);
    $("#mNuevo_estado option:contains(" + data[id].estado + ")").prop('selected', true);
    $('#mNuevo_objetivo').val(data[id].objetivo);
    $('#mNuevo_detalle').val(data[id].detalle);
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
    var r = confirm("Está seguro que desea eliminar la página " + $('.' + id).find('td:eq(0)').text());
    if (r == true)
    {
        //alert('Ha solicitado eliminar.');
        $.ajax({
            type: "POST",
            url: "modelo/paginas.php",
            data: {
                funcion: "valida_dependencia",
                pagina: id
            },
            success: function(datos) {
                //alert(datos);
                if (datos == 0) {
                    $.ajax({
                        type: "POST",
                        url: "modelo/paginas.php",
                        data: {
                            funcion: "borra_pagina",
                            pagina: id
                        },
                        success: function(data) {
                            //alert(data);
                            if (data == 0) {
                                alert('Solicitud realizada.');
                                location.reload();
                            }
                            else {
                                alert('Por algún motivo no ha resultado lo solicitado.');
                            }
                        }
                    });
                }
                else
                {
                    alert('No es posible eliminar la página pues se encuentra asignada.');
                }
            }
        });
    }
}