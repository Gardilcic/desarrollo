<?php
require_once('sys_log.php');
if(!isset($_SESSION['status'])) 
{
	registra_log(utf8_decode('Error de sesión. NO INICIADA.'), 4, $_SERVER['REQUEST_URI']);
	header('Location: index.php'); 
} 

require_once('sql_sigp.php');
require_once('generales.php');
$url= $_SERVER['REQUEST_URI'];
$url2=array();
$url2=explode('/',$url);
$largo = COUNT($url2);
$pagina = $url2[$largo-1];

if($pagina !='adm_usuarios.php')
{
	if($_SESSION["usuario"]['modulo']=='')
	{
		$_SESSION["usuario"]['modulo']=get_modulo($_SERVER['REQUEST_URI']);
	}
	registra_log('validando usuario en sistema',4,$_SERVER['REQUEST_URI']);
	$cns="select COUNT(usuario) as cant from dbo.vista_paginas_usuario where usuario = '".$_SESSION['usuario']['usuario']."' AND url = '".$pagina."'";
	registra_log($cns,1,'vista_paginas_usuario');
	$a=get_datos($cns);
	$valido=0;
	while(odbc_fetch_row($a))
	{
		$valido = odbc_result($a,"cant");
	}
	//alert($valido);
	if($valido==0)
	{
		header('Location: adm_usuarios.php');
	}
}
//adm_usuarios.php

function get_modulo($pag)
{
	$pag=str_replace("/","",$pag);
	$cns="select id_modulos from vista_usuarios_permisos where url='".$pag."'";
	$a=get_datos($cns);
	$respuesta=1;
	while(odbc_fetch_row($a))
	{
		$respuesta = odbc_result($a,"id_modulos");
	}
	return $respuesta;
}
?>