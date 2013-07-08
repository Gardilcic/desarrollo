var calendario = null;
$(window).load(function() {
    $.ajax({
        type: "POST",
        url: "modelo/calendario.php",
        data: {
            funcion: "ListarCalendarios"
        },
        success: function(datos) {
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            var texto = "";
            calendario = objeto;
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id + "><td>" + objeto[key].descripcion + "</td><td>" + objeto[key].estado_nombre + "</td>";
                texto += "<td>" +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='" + objeto[key].id + "' onclick='dlgEliminar(" + key + ")'><i class='icon-remove icon-white'></i></a> " +
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

            $('#mestados').html(texto);
        }
    });

    $('#btnNuevoAceptar').click(function()
    {
        $('.mensajes').css('display', 'none');
        $.ajax({
            type: "POST",
            url: "modelo/calendario.php",
            data:
                    {
                        funcion: "NuevoCalendario",
                        descripcion: $('#nombre').val()
                    },
            success: function(datos)
            {
                if (datos > 0)
                {
                    alert('Acción realizada. Gracias.');
                    location.reload();
                }
            }
        });
    });

    $('#btnEditarAceptar').click(function()
    {
        //alert($('#mid').val());
        $('.mensajes').css('display', 'none');
        $.ajax({
            type: "POST",
            url: "modelo/calendario.php",
            data: {
                funcion: "ActualizarCalendario",
                id: $('#mid').val(),
                descripcion: $('#mnombre').val(),
                id_estado: $('#mestados').val()
            },
            success: function(datos) {
                alert('Solicitud realizada.');
                location.reload();
            }
        });
    });

});
function dlgModificar(item)
{
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
    //alert(id);

    $('#mid').val(calendario[item].id);
    $('#mnombre').val(calendario[item].descripcion);
    $('#mestados').val(calendario[item].id_estado);
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
    var r = confirm("Está seguro que desea eliminar este item " + calendario[id].descripcion + " ?");
    if (r == true)
    {
        //alert('Ha solicitado eliminar.');
        $.ajax({
            type: "POST",
            url: "modelo/calendario.php",
            data: {
                funcion: "EliminarCalendarios",
                id: calendario[id].id
            },
            success: function(datos) {
                if (datos > 0) {
                    alert('Solicitud realizada.');
                    location.reload();
                }
                else {
                    alert('No es posible eliminar la divisa pues se encuentra asignada.');
                }
            }
        });
    }
}