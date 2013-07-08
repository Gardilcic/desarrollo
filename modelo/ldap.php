<?php

$usuario = "jarisaca";

//Asigno variables para accesar al servidor LDAP
$host = "gardilcic-001.grupogardilcic.cl";
//$host = "teniente-002.grupogardilcic.cl";
$user = "jarisaca@grupogardilcic.cl";
$pswd = "ja.2013";

$ad = ldap_connect($host, "389") or die("Imposible Conectar");

// Especifico la versión del protocolo LDAP
ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Imposible asignar el Protocolo LDAP");



// Valido las credenciales para accesar al servidor LDAP
//$bd = ldap_bind($ad, $user, $pswd) 
//or die ("Imposible Validar en el Servidor LDAP");


if ($ad) {

    // realizando la autenticación
    $ldapbind = ldap_bind($ad, $user, $pswd);

    // verificación del enlace
    $dn = "OU=Departamento Informática,OU=Gerencia GAF,OU=Gardilcic - Oficina Central,OU=Constructora Gardilcic Ltda.,DC=grupogardilcic,DC=cl";
    $attrs = array("displayname", "mail", "samaccountname", "sn", "givenname");
    $filter = "(samaccountname=$usuario)";
    $search = ldap_search($ad, $dn, $filter, $attrs) or die("Error en la busqueda");
    $entries = ldap_get_entries($ad, $search);

    if ($entries["count"] > 0) {
        for ($i = 0; $i < $entries["count"]; $i++) {
            echo "<p>Nombre: " . $entries[$i]["displayname"][0] . "<br />";
            echo "Email: <a href=mailto:" . $entries[$i]["mail"][0] . ">" . $entries[$i]["mail"][0] . "</a><br />";
            echo "Nombre de Usuario: " . $entries[$i]["samaccountname"][0] . "<br />";
            echo "Apellido: " . $entries[$i]["sn"][0] . "</p>";
        }
    } else {
        echo "<p>No se ha encontrado ningun resultado</p>";
    }
    ldap_unbind($ad);

    if ($ldapbind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }
}

// Creo el DN 
// Especifico los parámetros que quiero que me regrese la consulta
//$attrs = array("displayname","mail","samaccountname","telephonenumber","givenname");
// Creo el filtro para la busqueda
//$filter = "(samaccountname=$usuario)";
//$search = ldap_search($ad, $dn, $filter, $attrs) 
/* $search = ldap_search($ad, $dn, $filter, $attrs) 
  or die ("");

  $entries = ldap_get_entries($ad, $search);

  if ($entries["count"] > 0)
  {
  for ($i=0; $i<$entries["count"]; $i++)
  {
  echo "<p>Nombre: ".$entries[$i]["displayname"][0]."<br />";
  echo "Email: <a href=mailto:".$entries[$i]["mail"][0].">".$entries[$i]["mail"][0]."</a><br />";
  echo "Nombre de Usuario: ".$entries[$i]["samaccountname"][0]."<br />";
  echo "Telefono: ".$entries[$i]["telephonenumber"][0]."</p>";
  }
  } else {
  echo "<p>No se ha encontrado ningun resultado</p>";
  }
  ldap_unbind($ad); */

// Variables del servidor LDAP
/* $ldaphost = "gardilcic-001.grupogardilcic.cl";  // servidor LDAP
  $ldapport = 389;                 // puerto del servidor LDAP

  // ejemplo de autenticación
  //$usuario  = 'jarisaca';     // ldap rdn or dn
  $password = 'ja.2013';  // associated password


  $usuario= 'sAMAccountName=jarisaca,uid=jarisaca,CN=Jhon Arisaca,OU=Departamento Informática,OU=Gerencia GAF,OU=Gardilcic - Oficina Central,OU=Constructora Gardilcic Ltda.,DC=grupogardilcic,DC=cl';     // ldap rdn or dn
  //
  // Conexión al servidor LDAP
  $ldapconn = ldap_connect($ldaphost, $ldapport)
  or die("Could not connect to $ldaphost");

  // Set some ldap options for talking to
  ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
  //ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

  if ($ldapconn) {

  // realizando la autenticación
  $ldapbind = ldap_bind($ldapconn, $usuario, $password);

  // verificación del enlace
  if ($ldapbind) {
  echo "LDAP bind successful...";
  } else {
  echo "LDAP bind failed...";
  }

  } */
?>