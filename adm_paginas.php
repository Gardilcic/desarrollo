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
        <style>
            #paginas { 
                list-style-type: none; 
                margin: 0; 
                padding: 5px 0;  
            }
            #paginas li { 
                list-style-type: none; 
                margin: 2px 0px; 
                padding: 0;                 
                border: 1px solid #CCC;
                background: #eaf7e9; 
                padding: 5px; 
                width: 85%;
            }
            .submenus{
                border: 1px solid #CCC;
                background: #f0f0f0; 
                margin: 5px 0px; 
            }
            .submenus p{
                padding: 5px;
                margin: 0px;
                color: #bbb;
            }
            .submenus ul{ 
                list-style-type: none; 
                margin: 0; 
                padding: 0;       
                padding: 1px;
            }
            .submenus ul li { 
                list-style-type: none; 
                margin: 2px 0px; 
                margin-left: 15px;
                border: 1px solid #CCC;
                background: #eaf7e9; 
                padding: 5px; 
                width: 90%;
            }
        </style>
    </head>
    <body>

        <?php include('libs/php/encabezado.php'); ?>

        <div class="container">
            <legend>Mantenedor de P&aacute;ginas</legend>

            <p style="text-align:right;">
                <a class='btn btn-info' href='#dlgMenu' data-toggle='modal'>
                    <i class='icon-file icon-white'></i>Administrar Menu
                </a>
                &nbsp;
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'>
                    <i class='icon-file icon-white'></i>Agregar P&aacute;gina
                </a>                
            </p>
            <!--TABLA DE BUSCADORES-->
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>URL</th>
                        <th>M&oacute;dulo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_body">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
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

            <!-- DIALOGO MODAL : NUEVO -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Nueva P&aacute;gina</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>CUIDADO!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nombre</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="Nuevo_nombre" placeholder="Nueva funcionalidad">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">URL</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="Nuevo_url" placeholder="nueva_pagina.html">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">M&oacute;dulo</label>  
                                <div class="controls">  
                                    <select id="Nuevo_modulo"></select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Objetivos</label>  
                                <div class="controls">  
                                    <textarea id="Nuevo_objetivo" style="width:270px; height:80px;"></textarea>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Detalle</label>  
                                <div class="controls">  
                                    <textarea id="Nuevo_detalle" style="width:270px; height:160px;"></textarea>
                                </div>  
                            </div>
                            <form method="post" enctype="multipart/form-data" action="cargador_files.php" class="form-horizontal" >
                                <fieldset> 
                                    <div class="control-group">  
                                        <label class="control-label" for="proyecto">Archivo Adjunto</label>  
                                        <div class="controls"> 	
                                            <input type="file" name="images" id="images" class="images" placeholder="Archivo" />
                                            <input type="hidden" name="ruta_destino" id="ruta_destino" value="libs/files/" />
                                            <input type="hidden" name="peso_maximo" id="peso_maximo" value="524288000" />
                                            <input type="hidden" name="identificador" id="identificador" value="archivos" />    
                                            <input type="hidden" name="preview" id="preview" value="preview-imagenes" />
                                            <input type="hidden" name="mensaje" id="mensaje" value="mensaje-imagenes" />
                                            <input type="hidden" name="extension" id="extension" value="" />
                                            <div class="mensaje-imagenes" id="response"></div>
                                            <ul class="preview-imagenes" id="image-list"></ul>
                                            <!--button type="submit" id="btn">Upload Files!</button-->
                                        </div>
                                    </div>
                                </fieldset> 
                            </form>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado.</label>  
                                <div class="controls">
                                    <select id="Nuevo_estado"></select>
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
                    <h3 id="myModalLabel">Modificar P&aacute;gina</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mmensaje"></span>
                        </div>
                        <fieldset>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nombre</label>  
                                <div class="controls"> 
                                    <input type="hidden" id="mid"> 
                                    <input type="text" class="input-xlarge" id="mNuevo_nombre" placeholder="Nueva funcionalidad">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">URL</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="mNuevo_url" placeholder="nueva_pagina.html">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">M&oacute;dulo</label>  
                                <div class="controls">  
                                    <select id="mNuevo_modulo"></select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Objetivos</label>  
                                <div class="controls">  
                                    <textarea id="mNuevo_objetivo" style="width:270px; height:80px;"></textarea>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Detalle</label>  
                                <div class="controls">  
                                    <textarea id="mNuevo_detalle" style="width:270px; height:160px;"></textarea>
                                </div>  
                            </div>
                            <!--<div class="control-group">  
                              <label class="control-label" for="perfiles">Archivo</label>  
                              <div class="controls">  
                                  <input type="file" class="input-xlarge" id="mNuevo_url" placeholder="Archivo">
                              </div>  
                            </div>-->
                            <form method="post" enctype="multipart/form-data" action="libs/js/cargador_files.php" class="form-horizontal" >
                                <fieldset> 
                                    <div class="control-group">  
                                        <label class="control-label" for="proyecto">Archivo Adjunto</label>  
                                        <div class="controls"> 	
                                            <input type="file" name="images" id="images" class="images" placeholder="Archivo" />
                                            <input type="hidden" name="ruta_destino" id="ruta_destino" value="../../libs/files/" />
                                            <input type="hidden" name="peso_maximo" id="peso_maximo" value="524288000" />
                                            <input type="hidden" name="identificador" id="identificador" value="archivos" />    
                                            <input type="hidden" name="preview" id="preview" value="preview-imagenes" />
                                            <input type="hidden" name="mensaje" id="mensaje" value="mensaje-imagenes" />
                                            <input type="hidden" name="extension" id="extension" value="" />
                                            <div class="mensaje-imagenes" id="response"></div>
                                            <ul class="preview-imagenes" id="image-list"></ul>
                                            <!--button type="submit" id="btn">Upload Files!</button-->
                                        </div>
                                    </div>
                                </fieldset> 
                            </form>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado.</label>  
                                <div class="controls">
                                    <select id="mNuevo_estado"></select>
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

            <!-- DIALOGO MODAL : MODIFICAR-->
            <div id="dlgMenu" class="modal hide fade" tabindex="-1" role="dialog"  style="left: 43%; width: 800px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Administrar Menú</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes_menu" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mensaje_menu"></span>
                        </div>                        
                        <div style="position: relative; float: left; width: 100%; margin-bottom: 20px;">Seleccione : <select id="modulos"></select> <select id="menu"><option>Seleccione Menu</option></select></div>                        
                        <div style="position: relative; float: left; width: 30%;">
                            <p><b>Items sin asignar</b></p>
                            <ul id="paginas" class="droptrue">
                            </ul>
                        </div>
                        <div style="position: relative; float: left; width: 65%; ">
                            <p><b>SubMenu</b></p>
                            <div id="submenus">
                                <div id="submenu-titulo">
                                    <ul id="submenu" class="droptrue">
                                    </ul>
                                </div>
                            </div>                            
                            <a href="#" id="btnNuevoSubMenu" class="btn btn-info">Nuevo Sub-Menú</a><br/><br/>
                            <div id="form-nuevo-submenu" style="display:none;">
                                <input id="nombreSubMenu" type="text" placeholder="Ingrese el nombre" />
                                <a href="#" id="btnGrabarNuevoSubMenu" class="btn btn-info">Grabar</a>
                                <a href="#" id="btnCerrarNuevoSubMenu" class="btn btn-info">Cerrar</a>
                            </div>
                        </div>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnEditarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>                    
                    <button id="btnGabarMenus" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : MODIFICAR USUARIO -->            



        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  
        <script type="text/javascript" src="libs/js/jquery.ui.core.js"></script>
        <script type="text/javascript" src="libs/js/jquery-ui.custom.js"></script>        
        <script type="text/javascript" src="libs/js/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.sortable.js"></script>

        <script type="text/javascript" src="controlador/paginas.js"></script>
        <script type="text/javascript" src="libs/js/upload.js"></script>

    </body>
</html>