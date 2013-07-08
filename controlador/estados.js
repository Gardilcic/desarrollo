$(window).load(function() {
    $.ajax({
        type: "POST",
        url: "modelo/estados_usuarios.php",
        data: {
            funcion: "listar_estados"
        },
        success: function(datos) {
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            var texto = "";
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id + "><td>" + objeto[key].nombre + "</td>";
                texto += "<td>" +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + objeto[key].id + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='" + objeto[key].id + "' onclick='dlgEliminar(" + objeto[key].id + ")'><i class='icon-remove icon-white'></i></a> " +
                        "</td></tr>";
            });

            $('#tabla_body').html(texto);

            /////////////////////////////////////////////////////////////
            $.extend($.tablesorter.themes.bootstrap, {
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

            $("table").tablesorter({
                theme: "bootstrap",
                sortList: [[0, 0], [1, 0]],
                widthFixed: true,
                headerTemplate: '{content} {icon}',
                widgets: ["uitheme", "filter", "zebra"],
                widgetOptions: {
                    zebra: ["even", "odd"],
                    filter_reset: ".reset"
                }
            }).tablesorterPager({
                container: $(".pager"),
                cssGoto: ".pagenum",
                removeRows: false,
                output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

            });


        }
    });

    $('#btnNuevoAceptar').click(function()
    {
        $('.mensajes').css('display', 'none');
        $.ajax({
            type: "POST",
            url: "modelo/estados_usuarios.php",
            data:
                    {
                        funcion: "nuevo_estado",
                        nombre: $('#Nuevo_estado_nombre').val()
                    },
            success: function(datos)
            {
                //alert(datos);
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
        $.ajax(
                {
                    type: "POST",
                    url: "modelo/estados_usuarios.php",
                    data:
                            {
                                funcion: "updt_estado",
                                id: $('#mid').val(),
                                nombre: $('#mNuevo_estado_nombre').val()
                            },
                    success: function(datos)
                    {
                        alert('Solicitud realizada');
                        location.reload();
                    }
                });
    });



});
function dlgModificar(id)
{
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
    $('#mid').val(id);
    $('#mNuevo_estado_nombre').val($('.' + id).find('td:eq(0)').text());
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id)
{
    var r = confirm("Está seguro que desea eliminar el estado " + $('.' + id).find('td:eq(0)').text());
    if (r == true)
    {
        //alert('Ha solicitado eliminar.');
        $.ajax({
            type: "POST",
            url: "modelo/estados_usuarios.php",
            data: {
                funcion: "valida_dependencia",
                estado: id
            },
            success: function(datos) {
                //alert(datos);
                if (datos == 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "modelo/estados_usuarios.php",
                        data: {
                            funcion: "borra_estado",
                            estado: id
                        },
                        success: function(data) {
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
                    alert('No es posible eliminar el estado pues se encuentra asignada.');
                }
            }
        });
    }
}