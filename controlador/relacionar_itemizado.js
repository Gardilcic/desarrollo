$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "modelo/itemizado_versiones.php",
        data: {
            funcion: "ListarVersiones"
        },
        success: function(datos){
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
                //tabla_body
            });

            $('#versiones').html(texto);
        }
    });
    
    // LISTAR PROYECTOS PARA LOS COMBOBOX
    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        async: false,
        data: {
            funcion: "ListarSubProyectos"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id_subproyectos + ">" + objeto[key].nombre + " - " + objeto[key].proyecto_nombre + "</option>";
            });

            $('#subproyectos').html(texto);
        }
    });    
            
    var itemizado_pmo = {};
    // DATOS PARA LA TABLA DE ITEMIZADO PROYECTO CON FILTRO DE ITEMIZADO PMO
    var subproyecto = {};
    
    $("#itemizadopmo").jqxGrid({
        width: 400,
        height: 340,
        source: itemizado_pmo,
        showfilterrow: true,
        filterable: true,        
        altrows: true,
        columns: [
            { text: 'ID', datafield: 'id', width: 50, hidden: true },
            { text: 'Código', datafield: 'codigo', width: 100, filtertype: 'textbox', filtercondition: 'starts_with' },
            { text: 'Descripción', datafield: 'descripcion', width: 300, filtertype: 'textbox', filtercondition: 'starts_with'  }
        ]
    });

    $("#itemizadoproyecto_relacionados").jqxGrid({
        selectionmode: 'multiplerows',
        width: 700,
        height: 200,
        source: subproyecto,
        theme: 'classic',
        showfilterrow: true,
        filterable: true,
        columns: [
            { text: 'ID', datafield: 'id', width: 50, hidden: true },
            { text: 'Código', datafield: 'codigo', width: 100, filtertype: 'textbox', filtercondition: 'starts_with' },
            { text: 'Descripción Items Relacionados', datafield: 'descripcion', width: 530, filtertype: 'textbox', filtercondition: 'starts_with' },
            { text: 'Unidad', datafield: 'unidad_abreviacion', width: 50, filtertype: 'textbox', filtercondition: 'starts_with' }
        ]
    });   
    
    $("#itemizadoproyecto").jqxGrid({
        selectionmode: 'multiplerows',
        width: 700,
        height: 200,
        source: subproyecto,
        theme: 'classic',
        showfilterrow: true,
        filterable: true,
        columns: [
            { text: 'ID', datafield: 'id', width: 50, hidden: true },
            { text: 'Código', datafield: 'codigo', width: 100, filtertype: 'textbox', filtercondition: 'starts_with' },
            { text: 'Descripción Itemizado de Proyecto', datafield: 'descripcion', width: 530, filtertype: 'textbox', filtercondition: 'starts_with' },
            { text: 'Unidad', datafield: 'unidad_abreviacion', width: 50, filtertype: 'textbox', filtercondition: 'starts_with' }
        ]
    });    
    
    $("#itemizadopmo").bind('rowselect', function (event) {
        var row = event.args.rowindex;
        var datarow = $("#itemizadopmo").jqxGrid('getcellvalue',row,'id');
        
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
                iditemizadopmo: datarow,
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
                iditemizadopmo: datarow,
                idsubproyecto: $('#subproyectos').val()
            }
        };
        
        $("#itemizadoproyecto_relacionados").jqxGrid({ source: subproyecto });
        $('#itemizadoproyecto_relacionados').jqxGrid('clearselection');
        
        $("#itemizadoproyecto").jqxGrid({ source: subproyecto_relacionado });
        $('#itemizadoproyecto').jqxGrid('clearselection');
    });    
    
    // FUNCIONALIDADES     
    $('#btnSubir').click(function() {
        var row_pmo = $("#itemizadopmo").jqxGrid('selectedrowindex');
        var row_id_pmo = $("#itemizadopmo").jqxGrid('getcellvalue',row_pmo,'id');
        //alert('PMO: '+row_id_pmo);
        
        var rows = $("#itemizadoproyecto").jqxGrid('selectedrowindexes');
        for (var m = 0; m < rows.length; m++) {
            var row_id_proyecto = $("#itemizadoproyecto").jqxGrid('getcellvalue',rows[m],'id');
            //alert('Proyecto: '+row_id_proyecto);
            $.ajax({
                type: "POST",
                url: "modelo/itemizado_proyecto.php",
                data: {
                    funcion: "RelacionarItemizado",
                    iditemizadopmo: row_id_pmo,
                    iditemizadoproyecto: row_id_proyecto
                },
                success: function(datos){
                    $("#itemizadoproyecto_relacionados").jqxGrid({ source: subproyecto });
                    $('#itemizadoproyecto_relacionados').jqxGrid('clearselection');

                    $("#itemizadoproyecto").jqxGrid({ source: subproyecto_relacionado });
                    $('#itemizadoproyecto').jqxGrid('clearselection');
                }
            });
            //selectedRecords[selectedRecords.length] = row;
        }
    });
    
    $('#btnBajar').click(function(){
        var row_pmo = $("#itemizadopmo").jqxGrid('selectedrowindex');
        var row_id_pmo = $("#itemizadopmo").jqxGrid('getcellvalue',row_pmo,'id');
        //alert('PMO: '+row_id_pmo);
        
        var rows = $("#itemizadoproyecto_relacionados").jqxGrid('selectedrowindexes');
        for (var m = 0; m < rows.length; m++) {
            var row_id_proyecto = $("#itemizadoproyecto_relacionados").jqxGrid('getcellvalue',rows[m],'id');
            //alert('Proyecto: '+row_id_proyecto);
            $.ajax({
                type: "POST",
                url: "modelo/itemizado_proyecto.php",
                data: {
                    funcion: "EliminarRelacionItemizado",
                    iditemizadopmo: row_id_pmo,
                    iditemizadoproyecto: row_id_proyecto
                },
                success: function(datos){
                    $("#itemizadoproyecto_relacionados").jqxGrid({ source: subproyecto });
                    $('#itemizadoproyecto_relacionados').jqxGrid('clearselection');

                    $("#itemizadoproyecto").jqxGrid({ source: subproyecto_relacionado });
                    $('#itemizadoproyecto').jqxGrid('clearselection');
                }
            });
            //selectedRecords[selectedRecords.length] = row;
        }
    });
    
    $('#versiones').change(function(){
        itemizado_pmo = {
            datatype: "json",
            type: "POST",
            datafields: [
                { name: 'id', type: 'string', visibity: 'false' },
                { name: 'codigo', type: 'string' },
                { name: 'descripcion', type: 'string' }
            ],
            url: 'modelo/itemizado_pmo.php',
            data: {
                funcion: "ListarVersionItemizadoPMO",
                idversion: $('#versiones').val()
            }
        };
        $("#itemizadopmo").jqxGrid({ source: itemizado_pmo });
        $('#itemizadopmo').jqxGrid('clearselection');
    });
    
    $('#subproyectos').change(function(){
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
    });
    
});
