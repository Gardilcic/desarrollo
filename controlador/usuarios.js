$(window).load(function() {
    var orden = 0;
    //$("#menu_usuario").sortable();
    //$("#menu_usuario").disableSelection();

    $.ajax({
        type: "POST",
        url: "modelo/paginas.php",
        async: false,
        data: {
            funcion: "obtener_permisos_por_orden",
            idusuario: $('#idUsuario').val()
        },
        success: function(datos) {
            //alert(datos);
            var contador = 0;
            var objeto = eval(datos);
            var texto = "";
            
            for (contador = 1; contador <= 6; contador++) {
                texto += "<div id = 'permiso_usuario' orden='" + contador + "' style='color: #BBB; '><p>No Asignado</p><div></div></div>";
            }
            $('#menu_usuario').html(texto);
            
            $.each(objeto, function(key, item) {
                //alert(objeto[key].color);
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").find('p').text(objeto[key].nombrepermiso);
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").css('color', '#000');
                //alert(objeto[key].color);
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").css('background-color', objeto[key].color);
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").css({background: "-webkit-linear-gradient(top, #FFF, " + objeto[key].color + ")"});
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").find("div").css("background", "url('libs/img/folder.png') no-repeat center");
                
                $("#permiso_usuario[orden='" + objeto[key].ordenpermiso + "']").attr('url',objeto[key].url);
            });

        }
    });

    $.ajax({
        type: "POST",
        url: "modelo/paginas.php",
        async: false,
        data: {
            funcion: "listar_modulos"
        },
        success: function(datos) {
            //alert(datos);
            var objeto = eval(datos);
            var texto = "";//<option value='0'>Seleccione</option>";

            $.each(objeto, function(key, item)
            {
                //alert(objeto[key].nombre);
                texto += "<option value=" + objeto[key].id + ">" + objeto[key].nombre + "</option>";
            });

            $('#modulos').html(texto);

        }
    });

    $('#modulos').change(function() {
        $.ajax({
            type: "POST",
            url: "modelo/paginas.php",
            data: {
                funcion: "listar_permisos_por_modulo",
                idModulo: $('#modulos').val(),
                idUsuario: $('#idUsuario').val()
            },
            success: function(datos)
            {
                var objeto = eval(datos);
                var texto = "";
                var seleccionado = "";
                if (typeof objeto != 'undefined' && objeto.length > 0) {
                    $.each(objeto, function(key, item) {
                        if (typeof objeto[key].usuario != 'undefined' && objeto[key].usuario.length > 0) {
                            if (objeto[key].seleccionar == 1)
                                seleccionado = "class='sombreado'";
                            else
                                seleccionado = "";
                            texto += "<option value=" + objeto[key].id + " " + seleccionado + " >" + objeto[key].nombre + "</option>";
                        }
                    });
                }
                else {
                    texto += "<option value=0 >No dispone de permisos</option>";
                }
                $('#permisos').html(texto);
            }
        });
    });

    $('#btnAsignarAceptar').click(function() {
        $('.mensajes').css('display', 'none');
        //alert(orden);
        if ($('#modulos').val() > 0 && $('#permisos').val() > 0) {
            $.ajax({
                type: "POST",
                url: "modelo/paginas.php",
                data: {
                    funcion: "grabar_acceso_directo",
                    idusuario: $('#idUsuario').val(),
                    idpermiso: $('#permisos').val(),
                    orden: orden
                },
                success: function(datos) {
                    //alert(datos);                    
                    location.href = "adm_usuarios.php";
                }
            });
        }
        else
        {
            $('.mmensajes').show();
            $('#mmensaje').html(" Debe completar todos los datos del formulario.");
        }
    });


    $('#menu_usuario #permiso_usuario').single_double_click(function() {
        if (typeof $(this).attr('url') != 'undefined') {
            location.href = $(this).attr('url');
        }
    }, function() {
        orden = $(this).attr('orden');
        $('#modulos').trigger('change');
        $('#dlgAsignar').modal('show');
    });

});

