var registro_datos = [];

var objetotitulos = [];
var titulos = new Array();
var columnas = [];
var tabladatos = new Array();
var fechas = [];

var cambios = [];

$(window).load(function() {

    /*$.datepicker.regional['es'] = {
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
    $.datepicker.setDefaults($.datepicker.regional['es']);*/

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
    
    
    $('#grilla').handsontable({
        width: 1100,
        height: 400,
        colHeaders: ["Fecha"],
        //startCols: 1,
        rowHeaders: true,
        cells: function (row, col, prop) {
            var cellProperties = {};
            if (row+1 == $('#grilla').handsontable('countRows') ) {
                cellProperties.readOnly = true;               
            }
            return cellProperties;
        },
        beforeChange: function (changes, source) {
            if(source=='edit'){
                //alert(changes);
                var row = changes[0][0];
                var col = changes[0][1];
                //var fecha_tabla = $('#grilla').handsontable('getDataAtCell', row, 0);               
                
                if(registro_datos[col-1][row].valor_real != changes[0][3]) {
                    var cambio = {};
                    cambio.id = registro_datos[col-1][row].id_registro;
                    cambio.fecha = $('#grilla').handsontable('getDataAtCell', row, 0);                    
                    cambio.valor = changes[0][3];                    
                    cambio.idpsdi = objetotitulos[col-1].id; 
                    cambios.push(cambio);
                    //console.log(cambios);
                }
                
            }
        }
    });

    $('#btn-generar').click(function() {       
        $('.mensajes').css('display', 'none');
        $('#grilla').showLoading();
        
        registro_datos = [];
        objetotitulos = [];
        titulos = new Array();
        columnas = [];
        tabladatos = new Array();
        fechas = [];
        cambios = [];
        
        var tipo = 0;
        // VERIFICO QUE ESE USUARIO TENGO ALGUN DATO-INDICADOR QUE MOSTRAR
        $.ajax({
            type: "POST",
            url: "modelo/rpt_registro_dato.php",            
            data: {
                funcion: "NumeroRegistros"
            },
            success: function(datos) {
                //alert(datos);
                var objeto = eval(datos);
                if(typeof objeto != null) {
                    $.each(objeto, function(key, item) {
                        //alert(item.respuesta);
                        if(item.respuesta>0) tipo = 1;
                        else tipo = 2;
                    });
                }
                //
            },
            async: false
        });
        if(tipo==1){
            $.ajax({
                type: "POST",
                url: "modelo/rpt_registro_dato.php",                
                data: {
                    funcion: "ListarTitulos"
                },
                success: function(datos) {
                    //alert(datos);
                    var objeto = eval(datos);
                    
                    /*$.each(datos,function(index){
                        ;
                    });*/
                    
                    if(typeof objeto != null) {
                        if (jQuery.inArray("Fecha", titulos) == -1) {                                                        
                            titulos.push("Fecha");
                            
                            columna = {};
                            columna.readOnly = true;
                            columnas.push(columna);
                        }
                        
                        $.each(objeto, function(key, item) {
                            //alert(key+1);
                            // OBTENGO LOS TITULOS DE LA TABLA DE LA BD
                            if (jQuery.inArray(item.dato_descripcion, titulos) == -1) {
                                titulos.push(item.dato_descripcion);

                                objetotitulo = {};
                                objetotitulo.id = item.id_psdi;
                                objetotitulo.descripcion = item.dato_descripcion;
                                objetotitulo.nivel = item.nivel_descripcion;
                                objetotitulo.formula = item.formula;
                                objetotitulo.id_indicador = item.id_indicador_dato;
                                objetotitulos.push(objetotitulo);
                                
                                // PARA INDICAR QUE EL TIPO DE DATOS A INGRESAR ES NUMERICO
                                columna = {};       
                                columna.readOnly = true;
                                columna.type = "numeric";
                                columna.format = "0,0.00";                                
                                columna.renderer = cambiarColor;
                                columnas.push(columna);
                            }
                        });
                        
                        //$('body').hideLoading();
                        
                        $('#grilla').handsontable({
                            width: 1100,
                            height: 400,
                            columns: columnas,
                            colHeaders: titulos,
                            startCols: titulos.length,
                            rowHeaders: true,
                            minSpareRows: 1
                        });
                        
                        
                    }
                },
                async: false
            });
            // GENERO LOS RANGOS DE FECHA SEGUN LO INGRESADO POR EL USUARIO
            $.ajax({
                type: "POST",
                url: "modelo/rpt_registro_dato.php",
                //async: false,
                data: {
                    funcion: "GenerarRangos",
                    fechainicial: $('#fechainicial').val(),
                    fechafinal: $('#fechafinal').val(),
                    columnas: titulos.length
                },
                success: function(datos) {
                    var objeto = eval(datos);
                    fechas = objeto;
                    //alert(objeto[0].fecha);
                    $('#grilla').handsontable('updateSettings', {
                        data: objeto
                    });
                },
                async: false
            });
            //console.log(objetotitulos);
            // TOMO LOS DATOS DE CADA COLUMNA ENVIO EL ID DE LA COLUMNA             
            $.each(objetotitulos, function(llave, obj) {

                // PARA LOS NIVELES 2+ EN ADELANTE
                if(obj.nivel != "Nivel 1") { 
                    
                    var filas = $('#grilla').handsontable('countRows') - 1;
                    //alert(filas);
                    for(var fila=0;fila<filas;fila++){
                        var formula = obj.formula;
                        
                        while(formula.indexOf("{")!=-1){
                            var pos_inicial = formula.indexOf("{");
                            var pos_final = formula.indexOf("}");
                            var id_indicador = formula.substring(pos_inicial+1, pos_final);
                            var contador = 0;
                            
                            $.each(objetotitulos, function(key,obj) {
                                contador = key;
                                if(obj.id_indicador == id_indicador)
                                    return false;
                            });

                            var valor = $('#grilla').handsontable('getDataAtCell', fila, contador+1);                            
                            if(!valor) { formula = ''; break; }
                            
                            formula = formula.replace(formula.substring(pos_inicial, pos_final+1), valor);
                        }
                        var valor_calculado = eval(formula);
                        console.log(formula + " - " + valor_calculado);
                        $('#grilla').handsontable('setDataAtCell', fila, llave+1, valor_calculado );                        
                    }                    
                }
                // PARA EL NIVEL 1
                else {
                    $.ajax({
                        type: "POST",
                        url: "modelo/rpt_registro_dato.php",
                        async: false,
                        data: {
                            funcion: "ListarDatos",
                            fechainicial: $('#fechainicial').val(),
                            fechafinal: $('#fechafinal').val(),
                            idpsdi:  obj.id
                        },
                        success: function(datos) {

                            //alert(datos);
                            //console.log()
                            //$('.cargando').css('display', 'none');
                            var objeto = eval(datos);

                            var filas = $('#grilla').handsontable('countRows');
                            //alert(filas)
                            if(objeto != null) {
                                registro_datos.push(objeto);

                                $.each(objeto, function(key, item) {                                
                                    //console.log(item);
                                    for(var i=0;i<filas-1;i++){
                                        //console.log("x "+i+" y "+(llave+1));
                                        //if(key < filas-1){
                                        var fecha_tabla = $('#grilla').handsontable('getDataAtCell', i, 0);
                                        var tmp = fecha_tabla.split('/');
                                        //alert(item.fecha_ingreso);
                                        //if(item.fecha_ingreso){
                                            //console.log(item.fecha_ingreso+" - "+fecha_tabla);
                                            if(item.fechas==fecha_tabla){
                                                //$('#grilla').handsontable('setDataAtCell', key, llave+1, item.id);

                                                $('#grilla').handsontable('setDataAtCell', i, llave+1, item.valor_real);
                                                //$('#grilla').handsontable('getCell',i, llave+1).style.background = "red";
                                                //$('#grilla').handsontable('getCell',i, llave+1).className = 'negative';
                                                break;
                                            }
                                        //}
                                    }
                                });
                            }                        

                        }
                    });
                }
                //$('#btn-generar').html("<i class='icon-file icon-white'></i>Generar Periodos");
            });
            
            setTimeout( "jQuery('#grilla').hideLoading()", 1000 );
            
            //document.getElementById('cuadro-cargando').style.display="none";
        }
        else{
            $('.mensajes').show();
            $('#mensaje').html("Usted no tiene ningun dato-indicador asociado.");
            jQuery('#grilla').hideLoading();
        }
    });

    $('#btnGuardar').click(function()
    {
        $('.mensajes').css('display', 'none');
        $('.cargando').css('display', 'none');
        var mensajes = [];
        //var idcalendario = $('#calendarios').val();
        if(cambios.length>0) {
            //alert('aaa');
            $.each(cambios, function(key, item) {
                //alert(item.id+" "+item.fecha+" "+item.valor);
                if(item.id == null){
                    //alert(item.id);
                    $.ajax({
                        type: "POST",
                        url: "modelo/rpt_registro_dato.php",
                        data: {
                            funcion: "NuevoDetalleDatoIndicador",
                            id: item.id,
                            fecha: item.fecha,
                            valor: item.valor,
                            idpsdi: item.idpsdi
                            //detalle: detallesglobal,
                            //columnas: titulos.length - 1
                        },
                        success: function(datos) {
                            //alert(datos);
                            if (datos <= 0) {
                                mensajes.push("Error al grabar dato "+item.valor+" con fecha "+item.fecha+"\n");
                            }                        
                        }
                    });
                }
                else if(item.id != null){
                    $.ajax({
                        type: "POST",
                        url: "modelo/registro_dato.php",
                        data: {
                            funcion: "ActualizarDetalleDatoIndicador",
                            id: item.id,
                            fecha: item.fecha,
                            valor: item.valor,
                            idpsdi: item.idpsdi
                            //detalle: detallesglobal,
                            //columnas: titulos.length - 1
                        },
                        success: function(datos) {
                            //alert(datos);
                            if (datos <= 0) {
                                mensajes.push("Error al grabar dato "+item.valor+" con fecha "+item.fecha+"\n");
                            }                        
                        }
                    });
                }
            });
            if(mensajes.length>0){
                $('.mensajes').show();
                $('#mensaje').html(mensajes[0]);
            }
            else{
                alert("Se grabo correctamente, actualizando tabla ...");
                jQuery('#btn-generar').trigger('click');
            }
        }
        else {
            $('.mensajes').show();
            $('#mensaje').html(" No ha realizado usted ningun cambio en el registro de datos. ");
        }
    });
    
    $('#btnReporte').click(function() {   
        var finicio  = $('#fechainicial').val();
        var ffinal  = $('#fechafinal').val();
        if(registro_datos.length>1) {
            $("<form action='rpt_registro_datos_pdf.php' target='_blank' method='POST'>" + 
                    "<input type='hidden' name='finicial' value='"+finicio+"'>"+ 
                    "<input type='hidden' name='ffinal' value='"+ffinal+"'>"+ 
                    "<input type='hidden' name='datos' value='"+JSON.stringify(registro_datos)+"'>"+ 
                    "<input type='hidden' name='titulos' value='"+JSON.stringify(titulos)+"'>"+ 
                    "</form>").submit();
        }
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

function cambiarColor(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.NumericCell.renderer.apply(this, arguments);
    if(row < $('#grilla').handsontable('countRows')-1 ){
        //alert(registro_datos.length +" - "+titulos.length);
        if (registro_datos != null && registro_datos.length == (titulos.length-1)) {
            //console.log(registro_datos[col-1][row]);
            td.style.color = registro_datos[col-1][row].color;//'#FD0000';//'#FD0000';                 
            //alert(registro_datos[col-1][row].color);
        }
    }
}
