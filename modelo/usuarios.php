<?php

require_once('../libs/php/sql_sigp.php');

if ($_POST['funcion'] == "ValidarUsuario") {

    $cns = "select dbo.fn_validar_usuario('$_POST[nombre]') as nro_permisos";

    $a = get_datos($cns);

    $nro_permiso = odbc_result($a, "nro_permisos");

    if ($nro_permiso > 0) {
        // SI TIENE PERMISOS PARA USAR EL SISTEMA, HAGO LA VALIDACION EN LDAP
        $nombre_usuario = $_POST['nombre'];
        //$host = "teniente-002.grupogardilcic.cl";
        $servidor = "gardilcic-001.grupogardilcic.cl";
        $puerto = "389";
        //$host = "teniente-002.grupogardilcic.cl";
        $usuario = $nombre_usuario."@grupogardilcic.cl";
        $clave = $_POST['clave'];

        $ldap = ldap_connect($servidor, $puerto) or die("Imposible Conectar");
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Imposible asignar el Protocolo LDAP");
        
        if ($ldap ) {
            // realizando la autenticación
            $ldapbind = @ldap_bind($ldap, $usuario, $clave);
            //echo json_encode($ldapbind);
            if ($ldapbind) {
                // verificación del enlace
                $dn = "OU=Constructora Gardilcic Ltda.,DC=grupogardilcic,DC=cl";
                $campos = array("displayname", "mail", "samaccountname", "sn", "givenname");
                $filtros = "(samaccountname=$nombre_usuario)";
                $busqueda = ldap_search($ldap, $dn, $filtros, $campos) or die("Error en la busqueda");
                $datos = ldap_get_entries($ldap, $busqueda);
                //echo ($datos["count"]);
                if ($datos["count"] > 0) {
                    for ($i = 0; $i < $datos["count"]; $i++) {
                        $datos_usuario["nombre"] = $datos[$i]["displayname"][0];
                        $datos_usuario["correo"] = $datos[$i]["mail"][0];
                        $datos_usuario["usuario"] = $datos[$i]["samaccountname"][0];
                        $datos_usuario["apellido"] = $datos[$i]["sn"][0];
                        /*SUBPROYECTOS ASOCIADOS AL USUARIO************/
                        $datos_usuario["subproyectos"]=get_subproyectos($datos[$i]["samaccountname"][0]);
                        /****************OK*********************/
                        
                        session_start();
                        $_SESSION["usuario"] = $datos_usuario;
                        $_SESSION["status"] = "1";
			$_SESSION["usuario"]['modulo']=1;
                    }
                    $respuesta["error"] = "0";
                    $respuesta["mensaje"] = "Usuario correcto.";
                    $respuesta["datos"] = $datos_usuario;
                } else {
                    $respuesta["error"] = "-1";
                    $respuesta["mensaje"] = "El usuario ingresado no existe, por favor verifique.";
                }
            } else {
                $respuesta["error"] = ldap_errno($ldap);
                $respuesta["mensaje"] = "El usuario o clave ingreso es incorrecto, por favor verifique.";
                //$respuesta["datos"] = $datos_usuario;
                //$respuesta["mensaje"] = ldap_err2str(ldap_errno($ldap));
            }
            
            ldap_unbind($ldap);
        }
        else {
            $respuesta["error"] = "-2";
            $respuesta["mensaje"] = "No es posible conectarse al servidor de autenticación.";
        }
    } else {
        $respuesta["error"] = "1";
        $respuesta["mensaje"] = "Ud. no tiene permisos para usar este sistema.";
    }    
    $objeto[] = $respuesta;
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "ListarUsuarios") {

        $nombre_usuario = "jarisaca";
        $servidor = "gardilcic-001.grupogardilcic.cl";
        $puerto = "389";
        //$host = "teniente-002.grupogardilcic.cl";
        $usuario = $nombre_usuario."@grupogardilcic.cl";
        $clave = "21212121";

        $ldap = ldap_connect($servidor, $puerto) or die("Imposible Conectar");
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Imposible asignar el Protocolo LDAP");
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        
        if ($ldap ) {
            // realizando la autenticación
            $ldapbind = @ldap_bind($ldap, $usuario, $clave);
            if ($ldapbind) {
                // verificación del enlace
                $dn = "CN=sigp,OU=Departamento Informática,OU=Gerencia GAF,OU=Gardilcic - Oficina Central,OU=Constructora Gardilcic Ltda.,DC=grupogardilcic,DC=cl";
                $filter = '(&(CN=sigp))';
                $busqueda = ldap_search($ldap, $dn, $filter) or die("Error en la busqueda");
                //print_r($busqueda);
                $datos = ldap_get_entries($ldap, $busqueda);                
                //print_r($busqueda);
                
                if ($datos["count"] > 0) {
                    foreach($datos[0]['member'] as $member) {
                        
                        if(!is_numeric($member)){
                            $dn = $member;
                            $campos = array("mail", "samaccountname", "uid", "displayname");
                            $filter = '(&(objectClass=person))';
                            $busqueda = ldap_search($ldap, $dn, $filter, $campos) or die("Error en la busqueda");
                            $datos_integrante = ldap_get_entries($ldap, $busqueda);
                            
                            $datos_usuario["nombre"] = utf8_encode( $datos_integrante[0]["displayname"][0] );
                            $datos_usuario["usuario"] = utf8_encode( $datos_integrante[0]["samaccountname"][0] );
                            $usuarios[] = $datos_usuario;
                            
                            //print_r($datos_integrante[0]["samaccountname"][0]);                            
                            /*$integrante = explode( ",", utf8_encode( $member ) );
                            $integrante = explode( "=", $integrante[0]);
                            $datos_usuario["usuario"] = ( $integrante[1] );
                            $usuarios[] = $datos_usuario;*/
                        }
                    }
                    $respuesta["error"] = "0";
                    $respuesta["mensaje"] = "Usuario correcto.";
                    $respuesta["datos"] = $usuarios;
                } else {
                    $respuesta["error"] = "-1";
                    $respuesta["mensaje"] = "El usuario ingresado no existe, por favor verifique.";
                }
            } else {
                $respuesta["error"] = ldap_errno($ldap);
                $respuesta["mensaje"] = "El usuario o clave ingreso es incorrecto, por favor verifique.";
            }
            
            ldap_unbind($ldap);
        }
        else {
            $respuesta["error"] = "-2";
            $respuesta["mensaje"] = "No es posible conectarse al servidor de autenticación.";
        }

        
    $objeto[] = $respuesta;
    echo json_encode($usuarios);
}

/*if ($_POST['funcion'] == "ListarUsuarios") {
    //echo "ListarUsuarios";

    $cns = "SELECT usu.id,usu.nombre,usu.apellidos,usu.rut,usu.clave,usu.id_perfil,per.nombre as perfil_nombre," .
            "	est.id as id_estado, est.nombre as estado_nombre " .
            "FROM sigp_usuarios.dbo.usuarios as usu " .
            "	JOIN sigo.dbo.adm_perfil as per ON usu.id_perfil = per.id " .
            "	JOIN sigo.dbo.estados as est ON est.id = usu.id_estados " .
            "WHERE est.id_tipo = 1  ";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'apellidos':'" . odbc_result($a, "apellidos") . "',";
        $objeto .= "'rut':'" . odbc_result($a, "rut") . "',";
        $objeto .= "'clave':'" . odbc_result($a, "clave") . "',";
        $objeto .= "'id_perfiles':'" . odbc_result($a, "id_perfil") . "',";
        $objeto .= "'perfil_nombre':'" . odbc_result($a, "perfil_nombre") . "',";
        $objeto .= "'id_estados':'" . odbc_result($a, "id_estado") . "',";
        $objeto .= "'estado_nombre':'" . odbc_result($a, "estado_nombre") . "'";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}*/

if ($_POST['funcion'] == "ListarPerfiles") {
    //echo "ListarUsuarios";

    $cns = "SELECT per.id,per.nombre, " .
            "	est.id as id_estado, est.nombre as estado_nombre " .
            "FROM sigo_qa.dbo.adm_perfil as per " .
            "	JOIN sigo_qa.dbo.estados as est ON est.id = per.id_estados " .
            "WHERE est.id_tipo = 1 AND est.id = 1  ";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'id_estados':'" . odbc_result($a, "id_estado") . "',";
        $objeto .= "'estado_nombre':'" . odbc_result($a, "estado_nombre") . "'";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}
if ($_POST['funcion'] == "ListarEstados") {
    //echo "ListarUsuarios";

    $cns = "SELECT est.id, est.nombre, est.id_tipo " .
            " FROM sigo_qa.dbo.estados as est " .
            " WHERE est.id_tipo = 1 " .
            " ORDER BY est.nombre asc ";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'id_tipo':'" . odbc_result($a, "id_tipo") . "',";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "GrabarNuevoUsuario") {
    //echo "ListarUsuarios";
    $ultimo_id = 0;

    $cns = "INSERT INTO sigp_usuarios_qa.dbo.usuarios (nombre,apellidos,rut,clave,id_estados,id_perfil) VALUES " .
            "('" . $_POST['nombre'] . "','" . $_POST['apellidos'] . "','" . $_POST['rut'] . "','" . $_POST['clave'] . "','" . $_POST['idEstado'] . "','" . $_POST['idPerfil'] . "')";

    $a = get_datos($cns);

    $cns = "SELECT @@IDENTITY AS ID";

    $b = get_datos($cns);

    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}

if ($_POST['funcion'] == "GrabarUsuario") {
    //echo "ListarUsuarios";

    $cns = "UPDATE sigp_usuarios_qa.dbo.usuarios SET nombre = " . "'" . $_POST['nombre'] . "'," .
            "apellidos = " . "'" . $_POST['apellidos'] . "'," .
            "rut = " . "'" . $_POST['rut'] . "'," .
            "id_estados = " . "'" . $_POST['idEstado'] . "'," .
            "id_perfil = " . "'" . $_POST['idPerfil'] . "' " .
            " WHERE id = " . $_POST['id'];

    $a = get_datos($cns);
    //$a = 1;
    if ($a === true)
        $respuesta = -1;
    else
        $respuesta = 1;

    echo $respuesta;
}

if ($_POST['funcion'] == "AsociarUsuario") {
    //echo "ListarUsuarios";

    $cns = "EXECUTE [sigp_qa].[dbo].[copia_permisos_usuariospermisos] @id_usuario=N'$_POST[idUsuario]',@id_perfil=$_POST[idPerfil]";

    $a = get_datos($cns);
        while (odbc_fetch_row($a)) {
            $respuesta = odbc_result($a, "respuesta");
        }
        echo $respuesta;
}

if ($_POST['funcion'] == "ListarUsuarioSubproyecto") {
    //echo "ListarUsuarios";

    $cns = "SELECT [usuario]
                ,[id_subproyecto]
            FROM [dbo].[vista_usuarios_subproyectos] WHERE usuario = '$_POST[idUsuario]'";

    $a = get_datos($cns);

    $contador = 1;
    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "AsociarUsuarioSubproyecto") {
    //echo "ListarUsuarios";

    $cns = "EXECUTE [sigp_qa].[dbo].[asociar_usuario_subproyecto] @id_usuario=N'$_POST[idUsuario]',@id_subproyecto=$_POST[idSubproyecto]";

    $a = get_datos($cns);
        while (odbc_fetch_row($a)) {
            $respuesta = odbc_result($a, "respuesta");
        }
        echo $respuesta;
}

if ($_POST['funcion'] == "BorrarUsuarioSubproyecto") {
    //echo "ListarUsuarios";

    $cns = "EXECUTE [sigp_qa].[dbo].[elimina_usuarios_proyectos] @id_usuario=N'$_POST[idUsuario]' ";

    $a = get_datos($cns);
        while (odbc_fetch_row($a)) {
            $respuesta = odbc_result($a, "respuesta");
        }
        echo $respuesta;
}

function get_subproyectos($usuario)
{
	$cns = "select id from vista_sigp_usuarios_usuarios_subproyectos where usuario ='".$usuario."'";
	$a=get_datos($cns);
	$respuesta=array();
	$contador=0;
	while(odbc_fetch_row($a))
	{
		$respuesta[$contador]=odbc_result($a,"id");
		$contador++;
	}
	return $respuesta;	
}

?>
