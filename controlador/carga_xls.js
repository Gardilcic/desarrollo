var pmo = null;
$(window).scroll(function() {
    var ttop = $('#buscador').position().top;
    var hcltb = $('#tabla_body').height()+500;
    var mtop = $(window).scrollTop();
    
    //alert(screen.height+" - "+ttop+" - "+hcltb);
    
    if (hcltb > screen.height) {
        $('#buscador').css('position', 'fixed');
        $('#buscador').css('bottom', '0px');
        $('#buscador').css('padding-bottom', '10px');
        /*if (mtop < (ttop + hcltb - 400))
        {
            
        }*/
    }
    else if (hcltb < screen.height){
        $('#buscador').css('position', 'relative');
        $('#buscador').css('bottom', 'auto');
        $('#buscador').css('padding-bottom', 'auto');
    }
    
});
$(window).load(function() {
    
    $('#tabla_body').html('');
    //$('#padre').append(combo);
    //$('#mpadre').append(combo);

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
    
    $.ajax({
        type: "POST",
        url: "modelo/subproyectos.php",
        data: {
            funcion: "ListarSubProyectos"
        },
        success: function(datos) {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id_subproyectos + ">" + objeto[key].nombre + ' - ' + objeto[key].proyecto_nombre + "</option>";
            });

            $('#subproyectos').html(texto);
        }
    });
    
    $('.pagesize').change(function(){
        var hcltb = $('table tbody').height()+500;

        if (hcltb >= screen.height) {
            $('#buscador').css('position', 'fixed');
            $('#buscador').css('bottom', '0px');
            $('#buscador').css('padding-bottom', '10px');
        }
        else if (hcltb < screen.height){
            $('#buscador').css('position', 'relative');
            $('#buscador').css('bottom', 'auto');
            $('#buscador').css('padding-bottom', 'auto');
        }
    });
    
    $('#subproyectos').change(function(){
        //alert('d');        
        $.ajax({
            type: "POST",
            url: "modelo/carga_xls.php",
            data: {
                funcion: "ListarItemizadoPMO",
                idsubproyecto: $('#subproyectos').val()
            },
            success: function(datos) {
                //alert(datos);
                var objeto = eval(datos);
                var texto = "";
                //alert(objeto[0].nombre);
                pmo = objeto;
                $.each(objeto, function(key, item) {
                    //alert(objeto[key].nombre);
                    texto += "<tr class=" + objeto[key].id + " ><td>" +
                            objeto[key].codigo + "</td><td>" +
                            objeto[key].descripcion + "</td><td>" +
                            objeto[key].unidad_abreviacion + "</td><td>" +
                            objeto[key].factor_equivalencia + "</td><td>" +
                            objeto[key].nombre + "</td><td>" +
                            objeto[key].estado_nombre + "</td>";

                    texto += "<td>" +
                            "<a class='btn btn-warning' codigo='" + key + "' onclick='dlgModificar(" + key + ")'><i class='icon-pencil icon-white'></i></a> " +
                            "<a class='btn btn-danger' codigo='"+objeto[key].id+"' onclick='dlgEliminar("+objeto[key].id+")'><i class='icon-remove icon-white'></i></a> "+
                            "</td></tr>";

                });
                $("table tbody").html(texto); 
                // let the plugin know that we made a update 
                $("table").trigger("update"); 
                // set sorting column and direction, this will sort on the first and third column 
                var sorting = [[0,0]]; 
                // sort on the first column 
                $("table").trigger("sorton",[sorting]); 
                //return false; 
                
                
            }
        });
        $('.pagesize option:first').prop('selected',true);
        $('.pagesize option').trigger('change');
    });
    
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
            $('#mod_unidades').html(texto);
            /*$('#vunidades').html(texto);
            $('#munidades').html(texto);*/
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
            $('#mod_estado').html(texto);
            $('#mestado').html(texto);
        }
    });
    
    // OBTENER EL CORRELATIVO PARA LOS COMBOBOX
    $('#padre').change(function(){
        //alert($('#nuevo_subproyectos option:selected').val());
        $.ajax({
            type: "POST",
            url: "modelo/itemizado_pmo.php",
            data: {
                funcion: "ObtenerCorrelativoPMO",
                idpadre: $('#padre option:selected').val()//,
                //subproyecto: $(' option:selected').val()
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

            $('#nueva_empresas').html(texto);
            $('#empresas').html(texto);
        }
    });
    
    $.ajax({
        type: "POST",
        url: "modelo/carga_xls.php",
        async: false,
        data: {
            funcion: "listar_itemizado_pmo"
        },
        success: function(datos) {
    //alert(datos);
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#nuevo_itm_pmo').html(texto);
            $('#mod_itm_pmo').html(texto);
        }
    });
     
     //FUNCION ACEPTAR PARA NUEVO ITEMIZADO
     $('#btnNuevoAceptar').click(function() {
        //alert('aaaa');
        $('.mensajes').css('display', 'none');

        if ($('#nuevo_codigo').val().length > 0 && $('#nueva_descripcion').val().length > 0 && $('#nueva_factor').val().length > 0 && 
                $('#nuevo_padre').val() >= 0 && $('#unidades').val() > 0 && $('#estado').val() > 0 ) {

            $.ajax({
                type: "POST",
                url: "modelo/itemizado_proyecto.php",
                data: {
                    funcion: "GrabarNuevo",
                    codigo: $('#nuevo_codigo').val(),
                    descripcion: $('#nueva_descripcion').val(),
                    factor: $('#nueva_factor').val(),
                    idpadre: $('#nuevo_padre').val(),
                    idunidad: $('#unidades').val(),
                    idestado: $('#estado').val(),
                    itemizado_pmo: $('#nuevo_itm_pmo').val(),
                    precio: $('#nuevo_precio').val(),
                    idversion: 4
                },
                success: function(datos) {
                    //alert(datos);   
                    if(datos>0)
                        {
                            alert('Solicitud realizada.');
                            location.reload();
                        }
                    else
                        {
                            alert('Por algún motivo su solicitud no ha podido realizarse. Revise los datos o contacte a un administrador.');
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
     
     //FUNCION PARA GUARDAR EL ITEMIZADO ACTUALIZADO
     
     $('#btnActualizarAceptar').click(function() {
        //alert('aaaa');
        $('.mensajes').css('display', 'none');
        precio = 0;
        
        if($('#mod_precio').val() == '')
            {
                precio=0;
            }
        if ($('#mod_itm_pmo').val()!=0 &&   $('#mod_descripcion').val().length >0) {

            $.ajax({
                type: "POST",
                url: "modelo/itemizado_proyecto.php",
                data: {
                    funcion: "actualiza_itemizado",
                    id: $('#midregistro').val(),
                    descripcion: $('#mod_descripcion').val(),
                    itm_pmo: $('#mod_itm_pmo').val(),
                    precio: $('#mod_precio').val(),
                    factor: $('#mod_factor').val(),
                    unidad: $('#mod_unidades').val(),
                    estado: $('#mod_estado').val()
                },
                success: function(datos) {
                    //alert(datos);   
                    if(datos=='')
                        {
                            alert('Solicitud realizada.');
                            location.reload();
                        }
                    else
                        {
                            alert('Por algún motivo su solicitud no ha podido realizarse. Revise los datos o contacte a un administrador.');
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
     
     
 
    // LISTAR subproyecto
    $.ajax({
        type: "POST",
        url: "modelo/carga_xls.php",
        data: {
            funcion: "listar_subproyectos"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#subproyecto').html(texto);
            $('#xls_subproyecto').html(texto);
            $('#nuevo_subproyectos').html(texto);
            /*$('#unidades').html(texto);
            $('#vunidades').html(texto);
            $('#munidades').html(texto);*/
        }
    });
    
    $('#nuevo_subproyectos').change(function(){
    $.ajax({
    	type: "POST",
        url: "modelo/carga_xls.php",
        data: {
            funcion: "listar_itemizado_subproyecto",
            subproyecto: $('#nuevo_subproyectos').val()
        },
        success: function(datos)
        {
            var objeto = eval(datos);
            var texto = "<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item) {
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#nuevo_padre').html(texto);
        }
        })
    });
    
    $('#nuevo_padre').change(function(){
    $.ajax({
    	type: "POST",
        url: "modelo/carga_xls.php",
        data: {
            funcion: "entregar_nuevo_id",
            padre: $('#nuevo_padre').val()
        },
        success: function(datos)
        {
            //alert(datos);
            $('#nuevo_codigo').val(datos);
        }
        })
    });
    
    $('#btnEliminarAceptar').click(function() {
        $('.mensajes').css('display', 'none');
//alert($('#mIdRegistro').val());
        $.ajax({
            type: "POST",
            url: "modelo/carga_xls.php",
            data: {
                funcion: "Eliminar",
                id: $('#mIdRegistro').val()
            },
            success: function(datos) {
                alert(datos);
                if (datos > 0)
                {
                    alert('No es posible realizar lo solicitado pues el itemizado posee relaciones.');
                }
                else
                {
                    alert('Itemizado eliminado. Gracias.');
                    location.reload();
                }
            }
        });
    });
});

function dlgModificar(nro) {
    // PRE CARGAR LOS VALORES DE LA TABLA EN LOS CAMPOS DEL FORMULARIO
    //alert((pmo[nro].id));
    $('#midregistro').val(pmo[nro].id);    
    $('#mod_descripcion').val(pmo[nro].descripcion);
    $('#mod_precio').val(pmo[nro].precio);
    $('#mod_factor').val(pmo[nro].factor_equivalencia);
    $('#mod_unidades').val(pmo[nro].id_unidad);
    $('#mod_estado').val(pmo[nro].id_estado);
    $('#mod_itm_proy').val(pmo[nro].codigo);
    $('#mod_itm_pmo').val(pmo[nro].itemizado_pmo);
    
    $('#dlgModificar').modal('show');
}

function dlgEliminar(id) {
    $('#mIdRegistro').val(id);
    $('#dlgEliminar').modal('show');
    /*$('#dlgEliminar').modal('show');
    $('#dlgEliminar').modal('show');*/
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

