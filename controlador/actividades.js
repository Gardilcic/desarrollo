var unidades = null;
var itemizado_subpro = null;
var subclasificacion = null;

$(window).load(function() {

    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        data: {
            funcion: "ListarSubProyectos"
        },
        async: false,
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id_subproyectos + ">" + objeto[key].nombre + ' - ' + objeto[key].proyecto_nombre + "</option>";
            });

            $('#subproyectos').html(texto);
        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/unidades_registro.php",
        async: false,
        data: {
            funcion: "listar_unidades"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            unidades = objeto;
        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/subclasificacion.php",
        async: false,
        data: {
            funcion: "ListarSubClasificacion"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
            subclasificacion = objeto;
        }
    });

    $('#subproyectos').change(function() {
        $('.mensajes').css('display', 'none'); //oculto la barra de mensajes de error
        $.ajax({
            type: "POST",
            url: "modelo/itemizado_proyecto.php",
            async: false,
            data: {
                funcion: "ListarItemizadoProyectoFiltro",
                idsubproyecto: $('#subproyectos').val()
            },
            success: function(datos) {
                //alert(datos);
                var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
                itemizado_subpro = objeto;
            }
        });
        $('#grilla').handsontable('updateSettings', {
            columns: [
                {
                    data:0
                },
                {
                    data:1
                },
                {
                    data:2
                },
                {
                    data:3
                },
                {
                    data:4,
                    // UNIDAD DE REGISTRO
                    type: {editor: Handsontable.AutocompleteEditor},
                    source: function(query, process) {
                        var $array = [];
                        $.each(unidades, function(key, item) {
                            $array.push(item.abreviacion);
                        });
                        process($array);
                    },
                    strict: true
                },
                {
                    data:5,
                    // UNIDAD DE CONTROL
                    type: {editor: Handsontable.AutocompleteEditor},
                    source: function(query, process) {
                        var $array = [];
                        $.each(unidades, function(key, item) {
                            $array.push(item.abreviacion);
                        });
                        process($array);
                    },
                    strict: true
                },
                {
                    data:6,
                    // ITEMIZADO DE SUB PROYECTO
                    type: {editor: Handsontable.AutocompleteEditor},
                    source: function(query, process) {
                        var $array = [];
                        $.each(itemizado_subpro, function(key, item) {
                            $array.push(item.codigo + ' - ' + item.descripcion);
                        });
                        process($array);
                    },
                    strict: false
                },
                {
                    data:7,
                    // ITEMIZADO DE SUB PROYECTO
                    type: {editor: Handsontable.AutocompleteEditor},
                    source: function(query, process) {
                        var $array = [];
                        $.each(subclasificacion, function(key, item) {
                            $array.push(item.nombre_subclasificacion + ' - ' + item.nombre);
                        });
                        process($array);
                    },
                    strict: false
                }
            ]
        });

        //countRows ()
        var numero = $('#grilla').handsontable('countRows');
        var actividad = eval( new $.actividad().lista({ subproyecto: $('#subproyectos').val() }) );
        //console.log(actividad);
        //alert(numero);
        if(actividad != null && actividad.length>0){
            for (i = 0; i < actividad.length; i++) {
                $('#grilla').handsontable('setDataAtCell', i, 6, '');
                $('#grilla').handsontable('setDataAtCell', i, 0, actividad[i].nombre);
                $('#grilla').handsontable('setDataAtCell', i, 1, actividad[i].nombre_referencia);
                $('#grilla').handsontable('setDataAtCell', i, 2, actividad[i].alcance);
                $('#grilla').handsontable('setDataAtCell', i, 3, actividad[i].responsable);
                $('#grilla').handsontable('setDataAtCell', i, 4, actividad[i].unidad_registro_abbr);
                $('#grilla').handsontable('setDataAtCell', i, 5, actividad[i].unidad_control_abbr);
                $('#grilla').handsontable('setDataAtCell', i, 6, actividad[i].codigo);
                $('#grilla').handsontable('setDataAtCell', i, 8, actividad[i].id);
            }
        }
        else{
            //var contador = $('#grilla').handsontable('countRows');
            for (i = 0; i < numero; i++) {
                $('#grilla').handsontable('alter', 'remove_row', 0);                
            }
        }
        //alert($('#grilla').handsontable('getDataAtCell', 0, 8));
    });

    $('#grilla').handsontable({
        width: 1160,
        colHeaders: ["Nombre", "Descripcion", "Alcance", "Responsable", "UN Registro", "UN Control", "Itemizado SubProyecto", "Clasificacion"],
        colWidths: ["200", "200", "60", "100", "100", "100", "200", "150"],
        rowHeaders: true, //["First", "Second", "Third"],
        minSpareRows: 1,
        minCols: 8,
        //contextMenu: true ,
        contextMenu: ['row_above', 'row_below', 'remove_row'],
        cells: function(row, col, prop) {
            var cellProperties = {};
            var valor = $('#grilla').handsontable('getDataAtCell', row, col);

            if (col === 2) {
                if (isNaN(valor) || valor < 0) {
                    //valor = valor.replace(",",".");
                    //changes[i][3] = valor;
                    cellProperties.renderer = verificarCantidad;
                }
            }
            else if ((col === 0 || col === 3 || col === 4 || col === 5) && valor != null) {
                if (valor.length <= 0) {
                    cellProperties.renderer = verificarUnidades;
                }
                else if (valor.length > 0) {
                }
                else
                    cellProperties.renderer = verificarUnidades;
            }
            else if ((col === 0 || col === 3 || col === 4 || col === 5) && valor == null && $('#grilla').handsontable('countRows') !== (row + 1)) {
                cellProperties.renderer = verificarUnidades;
            }
            return cellProperties;
        },
        columns: [
            {
                data:0
            },
            {
                data:1
            },
            {
                data:2
            },
            {
                data:3
            },
            {
                // UNIDAD DE REGISTRO
                data:4,
                type: {editor: Handsontable.AutocompleteEditor},
                source: function(query, process) {
                    var $array = [];
                    $.each(unidades, function(key, item) {
                        $array.push(item.abreviacion);
                    });
                    process($array);
                },
                strict: true
            },
            {
                data:5,
                // UNIDAD DE CONTROL
                type: {editor: Handsontable.AutocompleteEditor},
                source: function(query, process) {
                    var $array = [];
                    $.each(unidades, function(key, item) {
                        $array.push(item.abreviacion);
                    });
                    process($array);
                },
                strict: true
            },
            {
                data:6
            },
            {
                // ITEMIZADO DE SUB PROYECTO
                data:7,
                type: {editor: Handsontable.AutocompleteEditor},
                source: function(query, process) {
                    var $array = [];
                    $.each(subclasificacion, function(key, item) {
                        $array.push(item.nombre_subclasificacion + ' - ' + item.nombre);
                    });
                    process($array);
                },
                strict: false
            }
        ],
        beforeChange: function(changes, source) {
            for (var i = changes.length - 1; i >= 0; i--) {
                var valor = changes[i][3];
                if (isNaN(valor)) {
                    valor = valor.replace(",", ".");
                    changes[i][3] = valor;
                }
            }
        }
    });

    $('#btn-guardar').click(function() {
        $('.mensajes').css('display', 'none'); //oculto la barra de mensajes de error
        
        var filas = $('#grilla').handsontable('countRows');
        
        if( $('#subproyectos').val() > 0 && filas > 1 ) {
            if(!$('td').hasClass('grilla-error')){
                
                var actividades = [];
                // RECORRO LA TABLA PARA ARMAR UN OBJETO JSON CON TODOS DE LA ACTIVIDAD
                for (i = 0; i < filas - 1; i++) {
                    var actividad = {};
                    actividad.id = $('#grilla').handsontable('getDataAtCell', i, 8);
                    actividad.nombre = $('#grilla').handsontable('getDataAtCell', i, 0);
                    actividad.referencia = $('#grilla').handsontable('getDataAtCell', i, 1);
                    actividad.alcance = $('#grilla').handsontable('getDataAtCell', i, 2);
                    actividad.responsable = $('#grilla').handsontable('getDataAtCell', i, 3);
                    actividad.subproyecto = $('#subproyectos').val();    

                    //alert(actividad.indexOf("John Arisaca"));
                    jQuery.grep(unidades, function(obj) {
                        //alert($('#grilla').handsontable('getDataAtCell', i, 4)+' : '+obj.nombre);
                        if (obj.abreviacion == $('#grilla').handsontable('getDataAtCell', i, 4)){
                            actividad.unidadregistro = obj.id;
                        }
                    });

                    jQuery.grep(unidades, function(obj2) {
                        if (obj2.abreviacion == $('#grilla').handsontable('getDataAtCell', i, 5)){
                            actividad.unidadcontrol = obj2.id;
                        }
                    });
                    
                    // BUSCADOR PARA LA EL ITEMIZADO DEL SUBPROYECTO
                    var nombre = $('#grilla').handsontable('getDataAtCell', i, 6);
                    var coincide = false;
                    if(typeof nombre != 'undefined' && nombre != null) {
                        nombre = nombre.split("-");
                        jQuery.grep(itemizado_subpro, function(obj) {
                            //alert($.trim(nombre[0])+' - '+obj.codigo);
                            //console.log(obj);
                            if (obj.codigo == $.trim(nombre[0])) {
                                coincide = true;
                                actividad.itemizado = obj.id;
                                return false;
                            }
                        });
                    }
                    if(!coincide) {
                        actividad.itemizado = 'null';
                    }                    

                    // BUSCADOR PARA LA CLASIFICACION
                    var nombre = $('#grilla').handsontable('getDataAtCell', i, 7);
                    var coincide = false;
                    if(typeof nombre != 'undefined' && nombre != null) {
                        nombre = nombre.split("-");                
                        jQuery.grep(subclasificacion, function(obj) {
                            //alert($.trim(nombre[0])+' - '+obj.nombre_subclasificacion);
                            if (obj.nombre_subclasificacion === $.trim(nombre[0])) {
                                coincide = true;
                                actividad.subclasificacion = obj.id_subclasificacion;
                            }
                        });
                    }
                    if(!coincide) {
                        actividad.subclasificacion = 'null';
                    }                   
                    
                    // INDICO QUE ACCION REALIZAR
                    if($('#grilla').handsontable('getDataAtCell', i, 8)>0) {
                        actividad.accion = "actualizar";
                    } else {
                        actividad.accion = "crear";
                    }

                    //console.log(actividades);
                    actividades.push(actividad);
                }
                // GRABO EL OBJETO ACTIVIDADES
                $.ajax({
                    type: "POST",
                    url: "modelo/actividades.php",
                    data: {
                        funcion: "GrabarActividades",
                        actividades: actividades
                    },
                    success: function(datos) {
                        //alert(datos);                
                        var objeto = eval(datos);//se transfora el objeto datos (json) en arreglo javascript
                        var posicion = 0;
                        $.each(objeto, function(key, item) {                    
                            if(item > 0) {
                                //alert(key+1);
                                $('#grilla').handsontable('alter', 'remove_row', posicion );
                                //alert($('#grilla').handsontable('countRows'));
                            }
                            else 
                                posicion ++;
                        });
                        if(posicion == 0) {
                            $('.mensajes').show().delay(800).fadeIn(400).delay(2500).fadeOut(400);
                            $('#mensaje').html("Se han grabado satisfactoriamente todos los datos.");
                            $('#subproyectos option:selected').trigger('change');
                        }
                        else {
                            $('.mensajes').show();
                            $('#mensaje').html("Error al grabar los datos, estos items no se han podido grabar.");
                        }
                        //subclasificacion = objeto;
                    }
                });
            } else {
                $('.mensajes').show();
                $('#mensaje').html("La tabla contiene aún errores de ingreso, datos en blanco o inválidos, por favor verifique los datos de la tabla.");
            } 
        } else {
            $('.mensajes').show();
            $('#mensaje').html("Para continuar debe seleccionar un subproyecto, y al menos ingresar un dato en la tabla.");
        } 
    });    
});

function verificarCantidad(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.TextCell.renderer.apply(this, arguments);
    //td.style.fontWeight = 'bold';
    td.style.color = 'red';
    $(td).addClass('grilla-error');
    //td.style.background = 'red';
}
function verificarUnidades(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.TextCell.renderer.apply(this, arguments);
    td.style.fontWeight = 'bold';
    $(td).css('border', 'red');
    $(td).css('border-width', '1px');
    $(td).css('border-style', 'solid');
    $(td).addClass('grilla-error');
}