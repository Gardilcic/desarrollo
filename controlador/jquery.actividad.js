(function($) {
    $.actividad = function() {
        var objeto = this;
        var settings = {
        };
        // FUNCIONES
        this.lista = function(opciones) {            
            var defaults = {
                funcion: 'ListarActividades',
                subproyecto: 0
            };
            var parametros = $.extend(defaults, opciones);
            return $.ajax({
                    type: "POST",
                    url: "modelo/actividades.php",
                    data: parametros,
                    dataType: "json",
                    async:false,
                    success: function(datos) {
                        //alert(datos);
                        /*var objeto = eval(datos);
                         var texto = "<option value='0'>Seleccione</option>";

                         $.each(objeto, function(key, item) {
                         texto += "<option value=" + objeto[key].id_subproyectos + ">" + objeto[key].nombre + ' - ' + objeto[key].proyecto_nombre + "</option>";
                         });

                         $('#subproyectos').html(texto);*/
                    }
                }).responseText;
            //};
            
            //return $.fn.alumnos_lista(settings); // lista.man
        };

        //this.listar = function(){

        //};
    };
})(jQuery);