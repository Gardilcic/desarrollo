$(document).ready(function() {
    var relacion_actividad = {};
    var subproyecto = {};
    var itemizado_proyecto = {};

    // LISTAR PROYECTOS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/relacionar_actividades_itemizado.php",
        async: false,
        data: {
            funcion: "listar_subproyectos"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });
            $('#subproyectos').html(texto);
        }
    });

    $("#itemizado_proyecto").jqxGrid({
        width: 400,
        height: 340,
        source: itemizado_proyecto,
        showfilterrow: true,
        filterable: true,
        altrows: true,
        columns: [
            {text: 'ID', datafield: 'id', width: 50, hidden: true},
            {text: 'Código', datafield: 'codigo', width: 100, filtertype: 'textbox', filtercondition: 'starts_with'},
            {text: 'Descripción', datafield: 'descripcion', width: 300, filtertype: 'textbox', filtercondition: 'starts_with'}
        ]
    });

    $("#relaciones").jqxGrid({
        selectionmode: 'multiplerows',
        width: 700,
        height: 200,
        source: relacion_actividad,
        theme: 'classic',
        showfilterrow: true,
        filterable: true,
        columns: [
            {text: 'ID', datafield: 'id', width: 50, hidden: true},
            {text: 'Itemizado', datafield: 'nombre', width: 350, filtertype: 'textbox', filtercondition: 'starts_with'},
            {text: 'Actividad', datafield: 'descripcion', width: 350, filtertype: 'textbox', filtercondition: 'starts_with'}
        ]
    });

    $("#actividades").jqxGrid({
        selectionmode: 'multiplerows',
        width: 700,
        height: 200,
        source: subproyecto,
        theme: 'classic',
        showfilterrow: true,
        filterable: true,
        columns: [
            {text: 'ID', datafield: 'id', width: 50, hidden: true},
            {text: 'Nombre', datafield: 'nombre', width: 350, filtertype: 'textbox', filtercondition: 'starts_with'},
            {text: 'Nombre de referencia ', datafield: 'nombre_referencia', width: 350, filtertype: 'textbox', filtercondition: 'starts_with'}/*,
             { text: 'Unidad', datafield: 'unidad_abreviacion', width: 50, filtertype: 'textbox', filtercondition: 'starts_with' }*/
        ]
    });

    /* $.ajax({
     type: "POST",
     url: "modelo/relacionar_actividades_itemizado.php",
     data: {
     funcion: "listar_empresas"
     },
     success: function(datos){
     
     var objeto = eval(datos);
     var texto = "<option value='0'>Seleccione</option>";
     
     $.each(objeto, function(key, item)
     {
     //alert(objeto[key].nombre);
     texto += "<option value=" + item.id + ">" + item.nombre + "</option>";
     //tabla_body
     });
     
     $('#empresa').html(texto);
     }
     });*/

    $('#subproyectos').change(function()
    {
        itemizado_proyecto = {
            datatype: "json",
            type: "POST",
            async: false,
            datafields: [
                {name: 'id', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'nombre_referencia', type: 'string'}
            ],
            url: 'modelo/relacionar_actividades_itemizado.php',
            data: {
                funcion: "listar_actividades",
                subproyectos: $('#subproyectos').val()
            }
        };
        $("#actividades").jqxGrid({source: itemizado_proyecto});
        $('#actividades').jqxGrid('clearselection');

        /*relacion_actividad = {
            datatype: "json",
            type: "POST",
            async: false,
            datafields: [
                {name: 'id', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'descripcion', type: 'string'}
            ],
            url: 'modelo/relacionar_actividades_itemizado.php',
            data: {
                funcion: "listar_relaciones",
                subproyectos: $('#subproyectos').val()
            }
        };
        $("#relaciones").jqxGrid({source: relacion_actividad});
        $('#relaciones').jqxGrid('clearselection');*/
    });
    /****************************************************************************/

    /*$('#subproyectos').change(function() {
     $.ajax({
     type: "POST",
     url: "modelo/relacionar_actividades_itemizado.php",
     data: {
     funcion: "listar_relaciones",
     empresa: $('#empresa').val()
     },
     success: function(datos)
     {
     //alert(datos);
     var objeto = eval(datos);
     var texto = "<option value='0'>Seleccione</option>";
     
     $.each(objeto, function(key, item) {
     texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
     });
     
     $('#versiones').html(texto);
     }
     });
     });*/


    $("#itemizado_proyecto").bind('rowselect', function(event) {
        var row = event.args.rowindex;
        var datarow = $("#itemizado_proyecto").jqxGrid('getcellvalue', row, 'id');
        //alert(datarow);
        relacionados = {
            datatype: "json",
            type: "POST",
            datafields: [
                {name: 'id', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'descripcion', type: 'string'}
            ],
            url: 'modelo/relacionar_actividades_itemizado.php',
            data: {
                funcion: "ListarActividadesRelacionadas",
                iditemizado: datarow
            }
        };

        /*subproyecto_relacionado = {
         datatype: "json",
         type: "POST",
         datafields: [
         {name: 'id', type: 'string'},
         {name: 'nombre', type: 'string'},
         {name: 'nombre_referencia', type: 'string'}
         ],
         url: 'modelo/itemizado_proyecto.php',
         data: {
         funcion: "ListarItemizadoProyectoNoRelacionado",
         iditemizadopmo: datarow,
         idsubproyecto: $('#subproyectos').val()
         }
         };*/

        $("#relaciones").jqxGrid({source: relacionados});
        $('#relaciones').jqxGrid('clearselection');

        //$("#itemizadoproyecto").jqxGrid({source: subproyecto_relacionado});
        //$('#itemizadoproyecto').jqxGrid('clearselection');
    });

    // FUNCIONALIDADES     
    $('#btnSubir').click(function() {
        var row_pmo = $("#itemizado_proyecto").jqxGrid('selectedrowindex');
        var row_id_proyecto = $("#itemizado_proyecto").jqxGrid('getcellvalue', row_pmo, 'id');

        var rows = $("#actividades").jqxGrid('selectedrowindexes');
        for (var m = 0; m < rows.length; m++) {
            //var row_id_proyecto = $("#itemizado_proyecto").jqxGrid('selectedrow');
            var actividad = $("#actividades").jqxGrid('getcellvalue', rows[m], 'id');
            //alert('itemizado: '+row_id_proyecto);
            $.ajax({
                type: "POST",
                url: "modelo/relacionar_actividades_itemizado.php",
                data: {
                    funcion: "relacionar_itm_actividad",
                    itm: row_id_proyecto,
                    id: actividad
                },
                success: function(datos) {
                    //alert(datos);
                    if (datos >= 1)
                    {
                        alert("Solicitud realizada.");
                        itemizado_proyecto = {
                            datatype: "json",
                            type: "POST",
                            async: false,
                            datafields: [
                                {name: 'id', type: 'string'},
                                {name: 'nombre', type: 'string'},
                                {name: 'nombre_referencia', type: 'string'}
                            ],
                            url: 'modelo/relacionar_actividades_itemizado.php',
                            data: {
                                funcion: "listar_actividades",
                                subproyectos: $('#subproyectos').val()
                            }
                        };
                        $("#actividades").jqxGrid({source: itemizado_proyecto});
                        $('#actividades').jqxGrid('clearselection');

                        relacionados = {
                            datatype: "json",
                            type: "POST",
                            datafields: [
                                {name: 'id', type: 'string'},
                                {name: 'nombre', type: 'string'},
                                {name: 'descripcion', type: 'string'}
                            ],
                            url: 'modelo/relacionar_actividades_itemizado.php',
                            data: {
                                funcion: "ListarActividadesRelacionadas",
                                iditemizado: row_id_proyecto
                            }
                        };
                        $("#relaciones").jqxGrid({source: relacionados});
                        $('#relaciones').jqxGrid('clearselection');
                    }
                    else
                    {
                        alert('Por alguna razón su solicitud no ha podido ser generada.');
                    }
                }
            });
            //selectedRecords[selectedRecords.length] = row;
        }
    });

    $('#btnBajar').click(function()
    {
        var row_pmo = $("#relaciones").jqxGrid('selectedrowindex');
        var row_id_proyecto = $("#relaciones").jqxGrid('getcellvalue', row_pmo, 'id');
        
        var row_pmo2 = $("#itemizado_proyecto").jqxGrid('selectedrowindex');
        var row_id_proyecto2 = $("#itemizado_proyecto").jqxGrid('getcellvalue', row_pmo2, 'id');
        //alert(row_id_proyecto2);
        
        var rows = $("#relaciones").jqxGrid('selectedrowindexes');
        for (var m = 0; m < rows.length; m++) {
            var row_id_proyecto = $("#relaciones").jqxGrid('getcellvalue', rows[m], 'id');
            //alert('Proyecto: '+row_id_proyecto);
            $.ajax({
                type: "POST",
                url: "modelo/relacionar_actividades_itemizado.php",
                data: {
                    funcion: "desrelacionar_itm_actividad",
                    id: row_id_proyecto
                },
                success: function(datos) {
                    //alert(datos);
                    if (datos >= 1)
                    {
                        //alert('Solicitud realizada.');
                        //location.reload();
                    }
                    else
                    {
                        alert('Por alguna razón su solicitud no ha podido ser generada.');
                    }
                    itemizado_proyecto = {
                        datatype: "json",
                        type: "POST",
                        async: false,
                        datafields: [
                            {name: 'id', type: 'string'},
                            {name: 'nombre', type: 'string'},
                            {name: 'nombre_referencia', type: 'string'}
                        ],
                        url: 'modelo/relacionar_actividades_itemizado.php',
                        data: {
                            funcion: "listar_actividades",
                            subproyectos: $('#subproyectos').val()
                        }
                    };
                    $("#actividades").jqxGrid({source: itemizado_proyecto});
                    $('#actividades').jqxGrid('clearselection');

                    relacionados = {
                        datatype: "json",
                        type: "POST",
                        datafields: [
                            {name: 'id', type: 'string'},
                            {name: 'nombre', type: 'string'},
                            {name: 'descripcion', type: 'string'}
                        ],
                        url: 'modelo/relacionar_actividades_itemizado.php',
                        data: {
                            funcion: "ListarActividadesRelacionadas",
                            iditemizado: row_id_proyecto2
                        }
                    };
                    $("#relaciones").jqxGrid({source: relacionados});
                    $('#relaciones').jqxGrid('clearselection');
                }
            });
            //selectedRecords[selectedRecords.length] = row;
        }
    });

    $('#subproyectos').change(function() {
        itemizado_proyecto = {
            datatype: "json",
            type: "POST",
            datafields: [
                {name: 'id', type: 'string'},
                {name: 'codigo', type: 'string'},
                {name: 'descripcion', type: 'string'}
            ],
            url: 'modelo/relacionar_actividades_itemizado.php',
            data: {
                funcion: "listar_itemizado_subproyecto",
                subproyectos: $('#subproyectos').val()
            }
        };
        $("#itemizado_proyecto").jqxGrid({source: itemizado_proyecto});
        $('#itemizado_proyecto').jqxGrid('clearselection');
    });

    /*$('#subproyectos').change(function(){
     var pmo_seleccionado = $("#itemizadopmo").jqxGrid('selectedrowindex');
     var pmo_seleccionado_id = $("#itemizadopmo").jqxGrid('getcellvalue',pmo_seleccionado,'id');
     if(pmo_seleccionado_id != -1){
     subproyecto = {
     datatype: "json",
     type: "POST",
     datafields: [
     { name: 'id', type: 'string', visibity: 'false' },
     { name: 'codigo', type: 'string' },
     { name: 'descripcion', type: 'string' },
     { name: 'unidad_abreviacion', type: 'string' }
     ],
     url: 'modelo/itemizado_proyecto.php',
     data: {
     funcion: "ListarItemizadoProyectoRelacionado",
     iditemizadopmo: pmo_seleccionado_id,
     idsubproyecto: $('#subproyectos').val()
     }
     };
     
     subproyecto_relacionado = {
     datatype: "json",
     type: "POST",
     datafields: [
     { name: 'id', type: 'string', visibity: 'false' },
     { name: 'codigo', type: 'string' },
     { name: 'descripcion', type: 'string' },
     { name: 'unidad_abreviacion', type: 'string' }
     ],
     url: 'modelo/itemizado_proyecto.php',
     data: {
     funcion: "ListarItemizadoProyectoNoRelacionado",
     iditemizadopmo: pmo_seleccionado_id,
     idsubproyecto: $('#subproyectos').val()
     }
     };
     
     $("#itemizadoproyecto_relacionados").jqxGrid({ source: subproyecto });
     $('#itemizadoproyecto_relacionados').jqxGrid('clearselection');
     
     $("#itemizadoproyecto").jqxGrid({ source: subproyecto_relacionado });
     $('#itemizadoproyecto').jqxGrid('clearselection');
     }
     });*/

});
