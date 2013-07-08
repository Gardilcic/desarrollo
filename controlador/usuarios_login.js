$(window).load(function() {
    
    $('#btn_entrar').click(function() {
        $('.mensajes').css('display', 'none');
        if ($('#nombre_usuario').val().length > 4 && $('#clave_usuario').val().length > 1) {
            $.ajax({
                type: "POST",
                url: "modelo/usuarios.php",
                async: false,
                data: {
                    funcion: "ValidarUsuario",
                    nombre: $('#nombre_usuario').val(),
                    clave: $('#clave_usuario').val()
                },
                success: function(datos) {
                    //alert(datos);
                    var objeto = eval(datos);
                    $.each(objeto, function(key, item) {
                        if (item.error == 0) {
                            location.href = "adm_usuarios.php";
                        } else {
                            $('.mensajes').show();
                            $('#mensaje').html(item.mensaje);
                        }
                    });
                }
            });
        }
        else
        {
            $('.mensajes').show();
            $('#mensaje').html(" Por favor, debe completar todos los datos del formulario.");
        }
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

});
