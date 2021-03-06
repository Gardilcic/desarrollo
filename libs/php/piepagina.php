<div class="navbar navbar-fixed-bottom">
    <div class="barra">
        <div class="container" style="width:80%;"></div>
    </div>
</div>

<!-- LIBREARIA JQUERY -->
<script src="libs/js/jquery.js"></script>
<!-- LIBREARIAS PARA EL MENU -->
<script src="libs/js/jquery.roundabout.js"></script>
<script src="libs/js/jquery.roundabout-shapes.js"></script>
<!-- LIBREARIAS DEL BOOTSTRAP -->
<script src="libs/js/bootstrap-transition.js"></script>
<script src="libs/js/bootstrap-alert.js"></script>
<script src="libs/js/bootstrap-modal.js"></script>
<script src="libs/js/bootstrap-dropdown.js"></script>
<script src="libs/js/bootstrap-scrollspy.js"></script>
<script src="libs/js/bootstrap-tab.js"></script>
<script src="libs/js/bootstrap-tooltip.js"></script>
<script src="libs/js/bootstrap-popover.js"></script>
<script src="libs/js/bootstrap-button.js"></script>
<!--script src="libs/js/bootstrap-collapse.js"></script>
<script src="libs/js/bootstrap-carousel.js"></script>
<script src="libs/js/bootstrap-typeahead.js"></script-->

<!-- LIBREARIAS PARA EL PAGINADOR DE LAS TABLAS -->
<script type="text/javascript" src="libs/js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="libs/js/jquery.tablesorter.widgets.js"></script>
<script type="text/javascript" src="libs/js/jquery.tablesorter.pager.js"></script>

<script>
    //var modulos = null;
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            url: "modelo/modulos.php",
            async: false,
            data: {
                funcion: "listar_modulos"
            },
            success: function(datos) {
                var objeto = eval(datos);
                var texto = "";

                $.each(objeto, function(key, item) {
                    texto += "<li codigo='" + item.id + "' color='" + item.color + "'><img src='" + item.icono + "'/><p>Módulo de " + item.nombre + "</p></li>";
                });

                $('#carousel').append(texto);
                $('#carousel').roundabout({
                    shape: 'square',
                    tilt: 0,
                    duration: 500,
                    minOpacity: 0,
                    clickToFocus: true,
                    //startingChild: 4,
                    clickToFocusCallback: mostrarMenu
                });

                //$('#carousel li[codigo=' + trae_id_menu() + ']').click();
                mostrarMenu();
                $("#carousel li[codigo='<?php echo $_SESSION["usuario"]['modulo'] ?>']").click();
            }
        });
    });

    function mostrarMenu() {
        var color = $('#carousel').find('.roundabout-in-focus').attr('color');
        var codigo = $('#carousel').find('.roundabout-in-focus').attr('codigo');
        var permisos = [];
        //alert( 'Codigo del Modulo : ' + $('#carousel').find('.roundabout-in-focus').attr('codigo') );
        $.post("libs/php/control_modulo.php", {id: codigo});

        $('.navbar-inner').css("background", color);
        $('.navbar-inner').css({background: "-webkit-gradient(linear, left top, left bottom, from(#ffffff), to(" + color + "))"});

        //alert(codigo);

        $.ajax({
            type: "POST",
            url: "modelo/menus.php",
            async: false,
            data: {
                funcion: "ListarMenuCompleto",
                idmodulo: codigo
            },
            success: function(datos) {
                //alert(datos);
                if (datos && datos != null) {
                    var objeto = eval(datos);
                    permisos = objeto;
                } else {
                    $('.menuprincipal').html("");
                }
            }
        });

        $.ajax({
            type: "POST",
            url: "modelo/menus.php",
            async: false,
            data: {
                funcion: "GenerarMenu",
                idmodulo: codigo
            },
            success: function(datos) {
                //$('#mantenedores').html(datos);
                //alert(datos)
                var objeto = eval(datos);
                //alert(objeto);
                if (objeto) {
                    var objeto = eval(datos);
                    var texto = "";
                    $.each(objeto, function(key, item) {
                        //alert(item.id);
                        texto += "<li class='dropdown' id='accountmenu'>" +
                                "<a class='dropdown-toggle' data-toggle='dropdown' href='#'>" + item.nombre + "<b class='caret'></b></a>" +
                                "<ul class='dropdown-menu' id='mantenedores'>";

                        $.each(item.submenu, function(key2, item2) {
                            //alert(item.submenu);
                            texto += "<li class='dropdown-submenu'>" +
                                    "<a tabindex='-1' href='#'>" + item2.nombre + "</a>" +
                                    "<ul class='dropdown-menu'>";

                            $.each(permisos, function(key3, item3) {
                                if (item3.submenu_id == item2.id)
                                    texto += "<li><a tabindex='-1' href='" + item3.url + "'>" + item3.nombre + "</a></li>";
                            });

                            texto += "</ul>" +
                                    "</li>";
                        });

                        // AGREGO LOS ELEMENTOS SIN CLASIFICAR COMO PARTE DEL PRIMER MENU
                        if (key == 0) {
                            $.each(permisos, function(key3, item3) {
                                if (!item3.submenu_id) {
                                    texto += "<li><a tabindex='-1' href='" + item3.url + "'>" + item3.nombre + "</a></li>";
                                }
                            });
                        }

                        texto += "</ul>" +
                                "</li>";

                        //alert(sin_submenu);
                    });

                    //alert(texto);
                    $('.menuprincipal').html(texto);
                    // PARA FUNCIONAMIENTO CORRECTO DEL MENU
                    $('.dropdown').hover(function() {
                        $('.dropdown').removeClass('open');
                        $(this).addClass('open');
                    }, function() {
                        $('.dropdown').removeClass('open');
                    });
                }
                else {
                    //alert("aaa");
                    $('.menuprincipal').html("");
                }
            }
        });
        //$('.navbar-inner').css("background",color);
        /*$.ajax({
         type: "POST",
         url: "libs/php/genera_menu.php",
         async: false,
         data: {
         funcion: "generar_menu",
         idmodulo: codigo
         },
         success: function(datos) {
         $('#mantenedores').html(datos);
         }
         });*/
    }

    function trae_id_menu()
    {
        //var id_menu = <?php echo $_SESSION["usuario"]['modulo'] ?>;
        return 8;
    }

</script>
<script type="text/javascript">
    function popup_obj() {
        window.open("adm_help_obj.php?url=" + location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
    }

    function popup_det() {
        window.open("adm_help_det.php?url=" + location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
    }

    function popup_doc() {
        window.open("adm_help_archivo.php?url=" + location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=150,width=150,left=200,top=200")
    }
</script>
