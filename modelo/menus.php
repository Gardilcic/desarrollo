<?php

session_start();
require_once('../libs/php/sql_sigp.php');

if ($_POST['funcion'] == "ListarMenuCompleto") {
    $var1 = "SELECT [id]
              ,[nombre]
              ,[url]
              ,[orden]
              ,[id_modulo]
              ,[submenu_id]
              ,[submenu_nombre]
              ,[submenu_orden]
              ,[menu_id]
              ,[menu_nombre]
              ,CASE WHEN menu_orden > 0 THEN menu_orden ELSE 999 END AS  menu_orden
          FROM [dbo].[fnGetMenus] ('".$_SESSION[usuario][usuario]."',$_POST[idmodulo]) 
          ORDER BY menu_orden, submenu_orden, orden ASC";
    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "GenerarMenu") {
    $var1 = "SELECT [id]
              ,[nombre]
              ,[url]
              ,[orden]
              ,[id_modulo]
              ,[submenu_id]
              ,[submenu_nombre]
              ,[submenu_orden]
              ,[menu_id]
              ,[menu_nombre]
              ,CASE WHEN menu_orden > 0 THEN menu_orden ELSE 999 END AS  menu_orden
          FROM [dbo].[fnGetMenus] ('".$_SESSION[usuario][usuario]."',$_POST[idmodulo]) 
          ORDER BY menu_orden, submenu_orden, orden ASC";
    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }

    foreach ($objeto as $key => $value) {
        $menu['id'] = $value['menu_id'];
        $menu['nombre'] = $value['menu_nombre'];
        $menu['submenu'] = null;
        if (!in_array($menu, $menus) && $menu['nombre'] != null) {
            $menus[] = $menu;
        }
        /*
        if($value['submenu_id']!=$objeto[$key+1]['submenu_id'] || $key == 0){
            $opcion["id"]=$value['id'];
            $opcion["nombre"]=  utf8_encode($value['nombre']);
            $opcion["url"]=$value['url'];
            $opcion["submenu"]=$value['submenu_id'];
            $opciones[] = $opcion;
        }*/
    }
    foreach ($menus as $key => $obj_menu) {
        $submenus = null;
        foreach ($objeto as $key2 => $obj_submenu) {
            $submenu['id'] = $obj_submenu['submenu_id'];
            $submenu['nombre'] = $obj_submenu['submenu_nombre'];
            $submenu['menu'] = $obj_submenu['menu_id'];    
                        
            foreach ($opciones as $key3=> $item3) {  
                if ($submenu['id'] == $item3['id']) {
                    $submenu["opciones"] = $item3;
                }            
            }
            
            if (!in_array($submenu, $submenus) && $obj_submenu['menu_id'] == $obj_menu['id'] && $obj_submenu['submenu_nombre'] != null) {
                $submenus[] = $submenu;                
            }
        }        
        $menus[$key]["submenu"]=$submenus;        
    }
    
    echo json_encode(($menus));
    //echo json_encode($objeto);
}

if ($_POST['funcion'] == "ListarMenu") {
    $var1 = "SELECT id, nombre, orden, id_modulos FROM dbo.vista_menus WHERE id_modulos = $_POST[modulo] ORDER BY orden";
    $a = get_datos_sigp($var1);
    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "ListarSubMenu") {
    $var1 = "SELECT id, nombre, orden, menu_id FROM dbo.vista_submenus ORDER BY orden";
    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "NuevoSubMenu") {
    $var1 = "INSERT INTO [sigp_usuarios].[dbo].[submenu]
           ([id_menu]
           ,[nombre]
           ,[orden]
           ,[id_estados])
     VALUES
           ($_POST[menu],
           '$_POST[nombre]',
           0,
           1)";
    $a = get_datos_sigp($var1);

    $var1 = "SELECT @@ROWCOUNT as respuestas";
    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}
if ($_POST['funcion'] == "ActualizarMenu") {
    $cns = "DECLARE @registro TablaMenu;";

    foreach ($_POST["datos"] as $key => $value) {
        $cns .= "INSERT INTO @registro VALUES (" . $value["id_permiso"] . "," . $value["id_submenu"] . "," . $value["orden"] . ");";
    }

    $respuesta = 0;
    $cns .= "EXEC dbo.actualiza_menu_paginas @r = @registro";

    $a = get_datos($cns);

    $respuesta = odbc_fetch_array($a);

    echo count($respuesta);
}
if ($_POST['funcion'] == "ActualizarSubMenu") {
    $cns = "DECLARE @registro TablaSubMenu;";

    foreach ($_POST["datos"] as $key => $value) {
        $cns .= "INSERT INTO @registro VALUES (" . $value["id_submenu"] . "," . $value["orden"] . ");";
    }

    $respuesta = 0;
    $cns .= "EXEC dbo.actualiza_orden_submenu @r = @registro";

    $a = get_datos($cns);

    $respuesta = odbc_fetch_array($a);

    echo count($respuesta);
}
?>