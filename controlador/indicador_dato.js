var indicador = null;
$(window).load(function() {
    var sortableIn = 0;
    $("#sortable").sortable({
        revert: true,
        receive: function(event, ui) {
            sortableIn = 1;
        },
        over: function(e, ui) {
            sortableIn = 1;
        },
        out: function(e, ui) {
            sortableIn = 0;
        },
        beforeStop: function(e, ui) {
            if (sortableIn == 0) {
                ui.item.remove();
            }
        }
        //axis: "x"
    });
    $(".drag").draggable({
        connectToSortable: "#sortable",
        helper: "clone",
        revert: "invalid"
    });
    $(".drag1").draggable({
        connectToSortable: "#sortable",
        helper: "clone",
        revert: "invalid"
    });
    $("ul, li").disableSelection();


    $.ajax({
        type: "POST",
        url: "modelo/indicador_dato.php",
        data: {
            funcion: "Listar_indicadores"
        },
        success: function(datos) {
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            var texto = "";
            var combobox = "<option value='0'>Seleccione</option>";
            indicador = objeto;
            $.each(objeto, function(key, item) {
                //alert(objeto[key].nombre);
                texto += "<tr class=" + objeto[key].id + "><td>" + objeto[key].descripcion + "</td><td>" + objeto[key].nombre + "(" + objeto[key].abreviacion + ")" + "</td><td>" + objeto[key].descripcion_nivel + "</td>";
                texto += "<td>" + objeto[key].detalle_nivel + "</td><td>" + objeto[key].tolerancia1 + "</td><td>" + objeto[key].tolerancia2 + "</td>"
                texto += "<td>" + retorna_tipo_texto(objeto[key].tipo) + "</td><td>" + objeto[key].nombre_estados + "</td>"
                texto += "<td>" +
                        "<a class='btn btn-warning' codigo='" + objeto[key].id + "' onclick='dlgModificar(" + objeto[key].id + ")'><i class='icon-pencil icon-white'></i></a> " +
                        "<a class='btn btn-danger' codigo='" + objeto[key].id + "' onclick='dlgEliminar(" + objeto[key].id + ")'><i class='icon-remove icon-white'></i></a> " +
                        "</td></tr>";

                if (objeto[key].id_Nivel > 2)
                    combobox += "<option value='" + objeto[key].id + "' nivel='" + objeto[key].id_Nivel + "'>" + objeto[key].descripcion + " (" + objeto[key].descripcion_nivel + ")</option>";
            });

            $('#indicadores').html(combobox);
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

            $('#Nuevo_indicador_estado').html(texto);
            $('#mNuevo_indicador_estado').html(texto);

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/indicador_dato.php",
        data: {
            funcion: "listar_niveles"
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

            $('#Nuevo_indicador_nivel').html(texto);
            $('#mNuevo_indicador_nivel').html(texto);

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/indicador_dato.php",
        data: {
            funcion: "listar_unidad"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + " (" + objeto[key].abreviacion + ")" + "</option>";
                //tabla_body
            });

            $('#Nuevo_indicador_unidad').html(texto);
            $('#mNuevo_indicador_unidad').html(texto);

        }
    });

    $('#indicadores').change(function() {
        var texto = "";
        if ($('#indicadores').val() > 0) {
            var nivel = $('#indicadores option:selected').text();
            nivel = nivel.split("(");
            nivel = nivel[1].split(")");
            nivel = nivel[0].split(" ");

            $('.formula').html(texto);

            //console.log();
            $.each(indicador, function(key, item) {
                //console.log(item.descripcion_nivel + " - " + ("Nivel " + (nivel[1] - 1)));
                if (item.descripcion_nivel == ("Nivel " + (nivel[1] - 1)))
                    texto += "<li id='draggable_" + key + "' class='drag1' codigo='{" + item.id + "}'>" + item.descripcion + "</li>";
            });

            $('.campos').html(texto);

            $(".drag1").draggable({
                connectToSortable: "#sortable",
                helper: "clone",
                revert: "invalid"
            });
            $("ul, li").disableSelection();

            // RECUPERO LA FORMULA SI TUVIERA UNA YA INGRESADA
            $.ajax({
                type: "POST",
                url: "modelo/indicador_dato.php",
                data: {
                    funcion: "ObtenerFormula",
                    indicador: $('#indicadores').val()
                },
                success: function(data) {
                    var objeto = eval(data);
                    if (objeto) {
                        $.each(objeto, function(key, item) {
                            $('.formula').html(item.formula_html);
                        });
                    }
                }
            });
        }
        else {
            $('.campos').html(texto);
            $('.formula').html(texto);
        }
    });

    $('#btnGrabarFormula').click(function() {
        var texto = "";
        var texto_llave = "";
        var texto_html = "";
        
        if($('#indicadores').val()>0){            
            $('.formula li').each(function(index) {
                //console.log($(this));
                texto += $(this).attr('codigo');
                texto_html += $(this).text();
            });

            try {
                texto_llave = texto.replace(/{/g,' ').replace(/}/g,' ');
                //texto_llave = texto_llave;
                //alert(texto_llave);
                eval(texto_llave);
                $.ajax({
                    type: "POST",
                    url: "modelo/indicador_dato.php",
                    data: {
                        funcion: "GrabarFormula",
                        indicador: $('#indicadores').val(),
                        formula: texto,
                        formula_html: $.trim($('.formula').html())
                    },
                    success: function(data) {
                        $('.mensajes-formula').show().delay(3000).fadeOut(800);
                        $('#mensajes-formula').html(" Se ha grabado la fórmula ingresada para este indicador.");                                                
                    }
                });
            } catch (e) {
                if (e instanceof SyntaxError) {
                    $('.mensajes-formula').show().delay(2500).fadeOut(800);
                    $('#mensajes-formula').html(" La fórmula ingresada no es correcta, por favor verifique.");
                }
            }
        }
    });

    $('#btnNuevoAceptar').click(function()
    {
        $('.mensajes').css('display', 'none');

        if ($('#Nuevo_indicador_descripcion').val().length > 0)
        {
            $.ajax({
                type: "POST",
                url: "modelo/indicador_dato.php",
                data: {
                    funcion: "nuevo_indicador",
                    descripcion: $('#Nuevo_indicador_descripcion').val(),
                    unidad: $('#Nuevo_indicador_unidad').val(),
                    nivel: $('#Nuevo_indicador_nivel').val(),
                    detalle: $('#Nuevo_indicador_detallenivel').val(),
                    tole1: $('#Nuevo_indicador_tolerancia1').val(),
                    tole2: $('#Nuevo_indicador_tolerancia2').val(),
                    tipo: $('#Nuevo_indicador_tipo').val(),
                    estado: $('#Nuevo_indicador_estado').val()
                },
                success: function(datos)
                {
                    //alert(datos);
                    if (datos > 0)
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
        if ($('#mNuevo_indicador_descripcion').val().length > 0)
        {
            $('.mensajes').css('display', 'none');
            $.ajax(
                    {
                        type: "POST",
                        url: "modelo/indicador_dato.php",
                        data:
                                {
                                    funcion: "updt_indicador",
                                    id: $('#mid').val(),
                                    descripcion: $('#mNuevo_indicador_descripcion').val(),
                                    unidad: $('#mNuevo_indicador_unidad').val(),
                                    nivel: $('#mNuevo_indicador_nivel').val(),
                                    detalle: $('#mNuevo_indicador_detallenivel').val(),
                                    tole1: $('#mNuevo_indicador_tolerancia1').val(),
                                    tole2: $('#mNuevo_indicador_tolerancia2').val(),
                                    tipo: $('#mNuevo_indicador_tipo').val(),
                                    estado: $('#mNuevo_indicador_estado').val()
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
    $estado = $('.' + id).find('td:eq(7)').text();
    $unidad = $('.' + id).find('td:eq(1)').text();
    $nivel = $('.' + id).find('td:eq(2)').text();
    $tipo = $('.' + id).find('td:eq(6)').text();
    //$clasificacion = $('.'+id).find('td:eq(1)').text();



    $('#mid').val(id);
    $('#mNuevo_indicador_descripcion').val($('.' + id).find('td:eq(0)').text());
    $("#mNuevo_indicador_unidad option:contains(" + $unidad + ")").prop('selected', true);
    $("#mNuevo_indicador_nivel option:contains(" + $nivel + ")").prop('selected', true);
    $('#mNuevo_indicador_detallenivel').val($('.' + id).find('td:eq(3)').text());
    $('#mNuevo_indicador_tolerancia1').val($('.' + id).find('td:eq(4)').text());
    $('#mNuevo_indicador_tolerancia2').val($('.' + id).find('td:eq(5)').text());
    $("#mNuevo_indicador_tipo option:contains(" + $tipo + ")").prop('selected', true);
    $("#mNuevo_indicador_estado option:contains(" + $estado + ")").prop('selected', true);


    $('#dlgModificar').modal('show');
}

function retorna_tipo_texto(tipo)
{
	if(tipo==1)
	{
		tipo='Directo';
	}
	else
	{
		tipo='Indirecto';
	}
	return tipo;
}

function dlgEliminar(id)
{
    var r = confirm("Está seguro que desea eliminar " + $('.' + id).find('td:eq(0)').text());
    if (r == true)
    {
        //alert('Ha solicitado eliminar.');
        $.ajax({
            type: "POST",
            url: "modelo/indicador_dato.php",
            data: {
                funcion: "eliminar_indicador",
                //id: $('#mid').val()
                id: id
            },
            success: function(datos) {
                //alert(datos);
                if (datos == 0) {

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