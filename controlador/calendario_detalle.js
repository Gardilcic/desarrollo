var calendario = null;
$(window).load(function() {

    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    fechai = new Date();
    fechaf = new Date();    
    fechai.setDate(fechaf.getDate()-15);
    
    $('#fechainicial').val( ("0" + fechai.getDate()).slice(-2) + '/' +
                        ("0" + (fechai.getMonth() + 1)).slice(-2) + '/' +
                        fechai.getFullYear() );
                
    $('#fechafinal').val( ("0" + fechaf.getDate()).slice(-2) + '/' +
                        ("0" + (fechaf.getMonth() + 1)).slice(-2) + '/' +
                        fechaf.getFullYear() );

    $('#fechainicial').glDatePicker({
        selectedDate: fechai,
        dateFormat: 'dd/mm/yy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        dowNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        onClick: function(target, cell, date, data) {
            target.val(("0" + date.getDate()).slice(-2) + '/' +
                        ("0" + (date.getMonth() + 1)).slice(-2) + '/' +
                        date.getFullYear());

            if(data != null) {
                alert(data.message + '\n' + date);
            }
        }
    });
    
    $('#fechafinal').glDatePicker({
        selectedDate: fechaf,
        dateFormat: 'dd/mm/yy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        dowNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        onClick: function(target, cell, date, data) {
            target.val(("0" + date.getDate()).slice(-2) + '/' +
                        ("0" + (date.getMonth() + 1)).slice(-2) + '/' +
                        date.getFullYear());

            if(data != null) {
                alert(data.message + '\n' + date);
            }
        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/calendario.php",
        async: false,
        data: {
            funcion: "ListarCalendarios"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].descripcion + "</option>";
            });

            $('#calendarios').html(texto);
            //$('#calendarios').trigger('change');
        }
    });
    
    $('#calendarios').change(function() {        
        $('.mensajes').css('display', 'none');
        $.ajax({
            type: "POST",
            url: "modelo/calendario_detalle.php",
            data: {
                funcion: "ListarDetalleCalendario",
                idcalendario: $('#calendarios').val()
            },
            success: function(datos) {
                //alert(datos);
                var objeto = eval(datos);
                //alert(objeto.length);
                if( objeto != null ){
                    //alert(objeto);
                    calendario = objeto;
                    $('#grilla').handsontable('updateSettings', {
                        data: objeto
                    });
                    $('#fechainicial').attr('disabled','disabled');
                    $('#fechafinal').attr('disabled','disabled');
                    $('#intervalo').attr('disabled','disabled');
                    $('#rango').attr('disabled','disabled');
                    $('#btn-generar').attr('disabled','disabled');
                } else {
                    $('#grilla').handsontable('updateSettings', {
                        data: []
                    });
                    $('#fechainicial').attr('disabled',false);
                    $('#fechafinal').attr('disabled',false);
                    $('#intervalo').attr('disabled',false);
                    $('#rango').attr('disabled',false);
                    $('#btn-generar').attr('disabled',false);
                }
            }
        });
    });

    $('#grilla').handsontable({
        width: 500,
        height: 400,
        colHeaders: ["Fecha", "Dia Semana"],
        colWidths: ["200", "200"],
        rowHeaders: true, //["First", "Second", "Third"],
        minSpareRows: 1,
        columns: [
            {
                type: 'date',
                dateFormat: 'dd/mm/yy'
            },
            {
            }
        ],
        beforeChange: function(changes, source) {            
            if (source === 'actualizardia') {
                return;
            }
            var valor = changes[0][3].split('/');
            var fecha = new Date(valor[2], valor[1] - 1, valor[0], 0, 0, 0);
            var dia = "";
            switch (fecha.getDay()) {
                case 0:
                    dia = "Domingo";
                    break;
                case 1:
                    dia = "Lunes";
                    break;
                case 2:
                    dia = "Martes";
                    break;
                case 3:
                    dia = "Miércoles";
                    break;
                case 4:
                    dia = "Jueves";
                    break;
                case 5:
                    dia = "Viernes";
                    break;
                case 6:
                    dia = "Sábado";
                    break;
            }
            $("#grilla").handsontable('setDataAtCell', changes[0][0], changes[0][1]+1, dia, 'actualizardia');
        },
        afterChange: function(changes, source) {
            if (source === 'actualizardia') {
                return;
            }            
        },
        cells: function(row, col, prop) {
            var cellProperties = {};
            var valor = $('#grilla').handsontable('getDataAtCell', row, col);

            if (col === 1) {
                if (valor == 'Domingo' || valor == 'Sábado') {
                    cellProperties.renderer = verificarNombre;
                }
                cellProperties.readOnly = true;
            }

            return cellProperties;
        }
    });
    
    $('#btn-generar').click(function() {
        $('.mensajes').css('display', 'none');
        if ($('#calendarios').val() > 0 && $('#intervalo').val() == 1 && $('#rango').val() > 0) {
            $.ajax({
                type: "POST",
                url: "modelo/calendario_detalle.php",
                data: {
                    funcion: "GenerarRangos",
                    fechainicial: $('#fechainicial').val(),
                    fechafinal: $('#fechafinal').val(),
                    rango: $('#rango').val()
                },
                success: function(datos) {
                    var objeto = eval(datos);
                    //alert(objeto[0].fecha);
                    $('#grilla').handsontable('updateSettings', {
                        data: objeto
                    });
                }
            });
        }
        else if ($('#calendarios').val() > 0 && $('#intervalo').val() == 2 && $('#rango').val() > 0) {
            $.ajax({
                type: "POST",
                url: "modelo/calendario_detalle.php",
                data: {
                    funcion: "GenerarRangosMensuales",
                    fechainicial: $('#fechainicial').val(),
                    fechafinal: $('#fechafinal').val(),
                    rango: $('#rango').val()
                },
                success: function(datos) {
                    var objeto = eval(datos);
                    //alert(objeto[0].fecha);
                    $('#grilla').handsontable('updateSettings', {
                        data: objeto
                    });
                }
            });
        } else {
            $('.mensajes').show();
            $('#mensaje').html("Debe seleccionar un calendario e ingresar las fechas y rango.");
            $('#grilla').handsontable('updateSettings', {
                data: []
            });
        }
    });


    $('#btnGuardar').click(function()
    {
        $('.mensajes').css('display', 'none');
        
        var detalles = [];
        var filas = $('#grilla').handsontable('countRows');            
            
        if ($('#calendarios').val() > 0 && $('#intervalo').val() >= 1 && $('#rango').val() > 0 && filas > 1) {
            

            // RECORRO LA TABLA PARA ARMAR UN OBJETO JSON CON TODOS DE LA ACTIVIDAD
            for (i = 0; i < filas - 1; i++) {
                var detalle = {};
                detalle.fecha = $('#grilla').handsontable('getDataAtCell', i, 0);
                detalles.push(detalle);
            }

            $.ajax({
                type: "POST",
                url: "modelo/calendario_detalle.php",
                data: {
                    funcion: "NuevoDetalleCalendario",
                    idcalendario: $('#calendarios').val(),
                    detalle: detalles
                },
                success: function(datos) {
                    //alert(datos);
                    if(datos>0){
                        $('.mensajes').show();
                        $('#mensaje').html("Se grabo correctamente el detalle del calendario.");
                        $('#grilla').handsontable('updateSettings', {
                            data: []
                        });
                    }
                }
            });
            
        } else {
            $('.mensajes').show();
            $('#mensaje').html("Debe seleccionar un calendario, ingresar las fechas, rango y generar los periodos de tiempo del calendario.");
            $('#grilla').handsontable('updateSettings', {
                data: []
            });
        }
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

function verificarNombre(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.TextCell.renderer.apply(this, arguments);
    //td.style.fontWeight = 'bold';
    td.style.color = '#FD0000';
    //td.style.background = 'red';
}