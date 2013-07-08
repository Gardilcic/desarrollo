<?php
session_start();
include('libs/php/valida_pagina_usuario.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="es-pe" http-equiv="Content-Language">
        <meta charset="utf-8">
        <title>Gardilcic :: SIGP Usuario: <?php echo $_SESSION['nombre'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="libs/img/logo.png" />
        <link href="libs/css/bootstrap.css" rel="stylesheet">
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet">
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="libs/js/html5shiv.js"></script>
        <![endif]-->	
        <script type="application/javascript">

            function valida_detalle_nivel()
            {
            var numero = document.getElementById('Nuevo_indicador_detallenivel').value;
            if(numero > 6 || numero <0)
            {
            //alert('La numeración debe estar entre 0 y 6');
            document.getElementById('Nuevo_indicador_detallenivel').value = 0;
            }
            }

            function valida_detalle_nivel_2(caja)
            {
            if(document.getElementById(caja).value > 100 || document.getElementById(caja).value < 0)
            {
            //alert('No se permiten valores mayores a 100 ni menores a 0');
            document.getElementById(caja).value=0;
            }
            }

        </script>
    </head>
    <body>

        <?php include('libs/php/encabezado.php'); ?>

        <div class="container">
            <legend>Mantenedor de Indicadores</legend>

            <p style="text-align:right;">
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'><i class='icon-file icon-white'></i> Nuevo Indicador</a>
                <a class='btn btn-info' href='#dlgFormula' data-toggle='modal'><i class='icon-edit icon-white'></i> Definir Formular Indicador</a>
            </p>
            <!--TABLA DE BUSCADORES-->
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Descripci&oacute;n</th>
                        <th>Unidad</th>
                        <th>Nivel</th>
                        <th>Detalle de nivel</th>
                        <th>Tolerancia 1</th>
                        <th>Tolerancia 2</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_body">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="9" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
                            <button class="btn first disabled"><i class="icon-step-backward"></i></button>
                            <button class="btn prev disabled"><i class="icon-arrow-left"></i></button>
                            <span class="pagedisplay">1 - 10 / 29 (50)</span> <!-- this can be any element, including an input -->
                            <button class="btn next"><i class="icon-arrow-right"></i></button>
                            <button class="btn last"><i class="icon-step-forward"></i></button>
                            <select class="pagesize input-mini" title="Select page size">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                            </select>
                            <select class="pagenum input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option></select>
                        </th>
                    </tr>
                </tfoot>

            </table>
            <!--FIN BUSCADORES-->

            <!-- DIALOGO MODAL : NUEVO USUARIO -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Nuevo Indicador</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>CUIDADO!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Descripci&oacute;n</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" maxlength="100" id="Nuevo_indicador_descripcion" placeholder="Indicador">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Unidad</label>  
                                <div class="controls">  
                                    <select id="Nuevo_indicador_unidad"></select>	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nivel</label>  
                                <div class="controls">  
                                    <select id="Nuevo_indicador_nivel"></select>            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Detalle de nivel</label>  
                                <div class="controls">  
                                    <input type="number" min="0" max="6" class="input-xlarge" maxlength="10" id="Nuevo_indicador_detallenivel" placeholder="0" onchange="javascript:valida_detalle_nivel();">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Tolerancia (V/D %)</label>  
                                <div class="controls">  
                                    <input type="number" min="0" max="100" class="input-xlarge" maxlength="10" id="Nuevo_indicador_tolerancia1" placeholder="0" onchange="javascript:valida_detalle_nivel_2('Nuevo_indicador_tolerancia1');">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Tolerancia (Amarillo %)</label>  
                                <div class="controls">  
                                    <input type="number" min="0" max="100" class="input-xlarge" maxlength="10" id="Nuevo_indicador_tolerancia2" placeholder="0" onchange="javascript:valida_detalle_nivel_2('Nuevo_indicador_tolerancia2');">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Tipo</label>  
                                <div class="controls">
                                    <select id="Nuevo_indicador_tipo">
                                        <option value="1">Directo</option>
                                        <option value="2">Indirecto</option>
                                    </select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado</label>  
                                <div class="controls">
                                    <select id="Nuevo_indicador_estado"></select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnNuevoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnNuevoAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : NUEVO-->

            <!-- DIALOGO MODAL : MODIFICAR-->
            <div id="dlgModificar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Editar Indicador</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mmensaje"></span>
                        </div>
                        <fieldset>
                            <input type="hidden" id="mid">
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Descripci&oacute;n</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" maxlength="100" id="mNuevo_indicador_descripcion" placeholder="Indicador">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Unidad</label>  
                                <div class="controls">  
                                    <select id="mNuevo_indicador_unidad"></select>	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nivel</label>  
                                <div class="controls">  
                                    <select id="mNuevo_indicador_nivel"></select>            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Detalle de nivel</label>  
                                <div class="controls">  
                                    <input type="number" class="input-xlarge" maxlength="10" id="mNuevo_indicador_detallenivel" placeholder="0" onchange="javascript:valida_detalle_nivel();">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Tolerancia (V/D)</label>  
                                <div class="controls">  
                                    <input type="number" class="input-xlarge" maxlength="10" id="mNuevo_indicador_tolerancia1" placeholder="0" onchange="javascript:valida_detalle_nivel('Nuevo_indicador_tolerancia1');">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Tolerancia (Amarillo)</label>  
                                <div class="controls">  
                                    <input type="number" class="input-xlarge" maxlength="10" id="mNuevo_indicador_tolerancia2" placeholder="0" onchange="javascript:valida_detalle_nivel('Nuevo_indicador_tolerancia2');">	            
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Tipo</label>  
                                <div class="controls">
                                    <select id="mNuevo_indicador_tipo">
                                        <option value="1">Directo</option>
                                        <option value="2">Indirecto</option>
                                    </select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado</label>  
                                <div class="controls">
                                    <select id="mNuevo_indicador_estado"></select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                        </fieldset>  
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnEditarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnEditarAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : MODIFICAR USUARIO -->

            <!-- DIALOGO MODAL : ELIMINAR USUARIO -->
            <div id="dlgEliminar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Confirmacion : Eliminar Clasificaci&oacute;n</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mmensaje"></span>
                        </div>
                        <p>Esta seguro que desea borrar este registro del sistema ?</p>		        
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnEliminarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnEliminarAceptar" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ELIMINAR USUARIO -->

            <!-- DIALOGO MODAL : DEFINIR FORMULA -->
            <div id="dlgFormula" class="modal hide fade" tabindex="-1" role="dialog" style="width: 800px; left: 42%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Definir fórmula</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        
                        <div style="width: 100%">Indicadores : <select id="indicadores"><option>Seleccione</option></select></div>
                        <div style="width: 100%; padding: 10px 0px;">
                            <div style="float:left;">Campos : </div>
                            <ul class="campos">
                            </ul> 
                        </div>
                        <div style="float: left; width: 12%; ">
                            <p>Operadores:</p>
                            <ul class="operadores">
                                <li id="draggable21" class="drag" codigo="(">(</li>
                                <li id="draggable22" class="drag" codigo=")">)</li>
                                <li id="draggable21" class="drag" codigo="*">*</li>
                                <li id="draggable22" class="drag" codigo="+">+</li>
                                <li id="draggable21" class="drag" codigo="-">-</li>
                                <li id="draggable22" class="drag" codigo="/">/</li>
                                <li id="draggable31" class="drag" codigo="1">1</li>
                                <li id="draggable32" class="drag" codigo="2">2</li>
                                <li id="draggable31" class="drag" codigo="3">3</li>
                                <li id="draggable32" class="drag" codigo="4">4</li>
                                <li id="draggable31" class="drag" codigo="5">5</li>
                                <li id="draggable32" class="drag" codigo="6">6</li>                                
                                <li id="draggable31" class="drag" codigo="7">7</li>
                                <li id="draggable32" class="drag" codigo="8">8</li>
                                <li id="draggable31" class="drag" codigo="9">9</li>
                                <li id="draggable32" class="drag" codigo="0">0</li>
                            </ul>
                        </div>
                        
                        <div style="float: left; width: 88%; margin: 0px; padding: 0px;">
                            <p>Formula:</p>
                            <div class="alert mensajes-formula" style="display:none;">
                                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                                <strong>Aviso : </strong><span id="mensajes-formula"></span>
                            </div>
                            <ul id="sortable" class="formula">
                            </ul>
                        </div>
                        <div style="float: left; width: 88%; margin: 0px; padding: 0px;">
                            <p style="color: #999">* Para borrar elementos de la fórmula desplacelos fuera del recuadro plomo que lo contiene.</p>
                        </div>
                        <!--fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Descripci&oacute;n</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" maxlength="100" id="Nuevo_indicador_descripcion" placeholder="Indicador">	            
                                </div>
                            </div>                            
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado</label>  
                                <div class="controls">
                                    <select id="Nuevo_indicador_estado"></select>
                        <!--p class="help-block"></p>  
                    </div>
                </div>
            </fieldset-->
                    </form>  
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnGrabarFormula" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL :  DEFINIR FORMULA -->

        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  

        <script type="text/javascript" src="libs/js/jquery.ui.core.js"></script>
        <script type="text/javascript" src="libs/js/jquery-ui.custom.js"></script>        
        <script type="text/javascript" src="libs/js/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.sortable.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.draggable.js"></script>

        <script type="text/javascript" src="controlador/indicador_dato.js"></script>
        <style>
            .operadores{
                position: relative;
                float: left;
                /*border: 1px solid #ccc;*/
                list-style: none;
                min-height: 10px;   
                cursor: pointer;
                margin: 0px;
                padding: 0px;
            }            
            .operadores > li{
                position: relative;
                float: left;
                border: 1px solid #ccc;
                background-color: #eee;
                text-align: center;
                width: 10px;
                margin: 5px;
                padding: 0px 10px;
                font-weight: bold;
            }
            .drag1, .drag{
                position: relative;
                float: left;
                border: 1px solid #ccc;
                background-color: #eee;
                text-align: center;
                margin: 0px;
                margin-right: 2px;
                padding: 0px 5px; 
            }
            .campos{
                position: relative;
                float: left;
                cursor: pointer;
                width: 80%;
                list-style: none;
                min-height: 20px;   
            }
            .campos > li{
                position: relative;
                float: left;
                border: 1px solid #ccc;
                background-color: #eee;
                text-align: center;
                margin-right: 10px;
                padding: 0px 5px;
            }
            .formula{
                position: relative;
                float: left;
                cursor: pointer;
                width: 90%;
                border: 1px solid #ccc;
                background-color: #FAFAFA; 
                list-style: none;
                min-height: 10px;   
                margin: 0px;
                padding: 50px 10px;
            }
            .formula > li{
                position: relative;
                float: left;
                display: block;
                border: 1px solid #ccc;
                background-color: #eee;
                text-align: center;
                margin-right: 10px;
                margin-bottom: 20px;
            }
        </style>
    </body></html>