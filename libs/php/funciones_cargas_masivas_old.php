<?php
require_once('libs/excel/reader.php');
require_once('sql_sigp.php');
require_once('generales.php');

function lectura($fname, $version)
{
	//echo $fname;
	error_reporting(E_ALL ^ E_NOTICE);
	$error="<h3>Error!</h3>  Los siguientes itemizados no se pueden cargar por contener caracteres extra&ntilde;os: ";
	set_time_limit(0);
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($fname);
	$truncar="truncate table itemizado_carga_masiva";
	get_datos($truncar);
	$contador=1;
	$contador_filas=0;
	$fila=2;
	if(valida_version($version)==false)
	{
		echo "Preparando para leer archivo<br />";
		while($fila<=$data->sheets[0]['numRows'])
		{
			$contador_filas++;
			$item=$data->sheets[0]['cells'][$fila][1];
			$descripcion=$data->sheets[0]['cells'][$fila][2];
			//echo $data->sheets[0]['cells'][$fila][2]."<br/>";
			$unidad=get_id_unidad($data->sheets[0]['cells'][$fila][3]);
			$precio=$data->sheets[0]['cells'][$fila][5];
			
			if($precio =="")
			{
				$precio =0;
			}
			$descripcion=reemplazar($descripcion);
			if($item[strlen($item)-1]==".")
			{
				$item=substr($item, 0, -1);
			}
			
			if($descripcion!="" && valida_numerico($precio) == true )
			{
				$cns="insert into itemizado_carga_masiva (codigo, descripcion, id_unidad, version, precio) values ('".$item."','".decoder($descripcion)."',".$unidad.",'".$version."',".$precio.")";
				get_datos($cns);
			}
			else
			{
				$error.=$item.", ";
			}
			$fila+=1;
		}
		$cns = "select id, codigo, descripcion from itemizado_carga_masiva order by codigo DESC";
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$id=odbc_result($a, "id");
			$codigo=odbc_result($a, "codigo");
			$descripcion=odbc_result($a, "descripcion");
			$arreglo_codigo=explode(".", $codigo);
			$largo_codigo=count($arreglo_codigo);
			$padre="";
			$contador1=0;
			$id_padre=0;
			
			if($largo_codigo>1)
			{
				while($contador1 <= $largo_codigo-2)
				{
					$padre.=$arreglo_codigo[$contador1].".";
					$contador1++;
				}
				$padre=substr($padre, 0, -1);
				$cns0="select id from itemizado_carga_masiva where codigo ='".$padre."'";
				$b=get_datos($cns0);
				while(odbc_fetch_row($b))
				{
					$id_padre=odbc_result($b, "id");
				}
				$cns0="update itemizado_carga_masiva set id_padre = '".$id_padre."' where id=".$id;
				get_datos($cns0);
			}
			else
			{
				get_datos("update itemizado_carga_masiva set id_padre='0' where id=".$id);
			}
		}
		/*GENERO LOS CODIGOS DE ITEMIZADO FINALES*/
		/*$cns = "select id, codigo, descripcion from itemizado_carga_masiva order by codigo DESC";
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$id=odbc_result($a, "id");
			$codigo=odbc_result($a, "codigo");
			$arreglo_codigo=explode(".", $codigo);
			$largo_codigo=count($arreglo_codigo);
			$padre="";
			$contador1=0;
			$id_padre=0;
			if($largo_codigo>1)
			{
				$codigo=$arreglo_codigo[$largo_codigo-1];
				$cns0="update itemizado_carga_masiva set codigo= '".$codigo."' where id=".$id;
				get_datos($cns0);
			}
		}*/
		echo "Archivo procesado<br/>";
		$cns1="select COUNT(id) as cant from itemizado_carga_masiva";
		$c=get_datos($cns1);
		$cnt=0;
		while (odbc_fetch_row($c))
	    {
	    	$cnt=odbc_result($c, "cant");
	    }
	    $error=substr($error, 0, -2);
	    if($cnt!=$contador_filas)
	    {
	    	$error.="<br/><br/>&nbsp;&nbsp;&nbsp;Resultado: Archivo no cargado y los datos procesados han sido eliminados.<br/>";
	    	$error.="<br/>&nbsp;&nbsp;&nbsp;Por favor utilice caracteres latinos de la alfabetizaci&oacute;n tradicional";
			//get_datos($truncar);
			unlink($fname);
	    }
	    else
	    {
	    	/*CARGA DE LOS DATOS A LA TABLA ITEMIZADO_SUBPROYECTO*/
	    	$cns="select id, codigo, id_padre, descripcion, precio, id_unidad from dbo.itemizado_carga_masiva order by id ASC";
	    	$a=get_datos($cns);
	    	$padre=0;
	    	while (odbc_fetch_row($a))
		    {
		    	$codigo=odbc_result($a, "codigo");
		    	if(odbc_result($a, "id_padre")!=0)
		    	{
		    		$padre=get_padre(odbc_result($a, "id_padre"),$subproyecto);
		    	}
		    	else
		    	{
		    		$padre=0;
		    	}
		    	$padre=get_padre(odbc_result($a, "id_padre"),$subproyecto);
		    	/*genero el codigo del itemizado*/
		    	/*$arreglo_codigo=explode(".", $codigo);
				$largo_codigo=count($arreglo_codigo);
				if($largo_codigo>1)
				{
					$codigo=$arreglo_codigo[$largo_codigo-1];
				}*/
				/*********************************************/
		    	//$padre=odbc_result($a, "id_padre");
		    	$descripcion=odbc_result($a, "descripcion");
		    	$precio = odbc_result($a, "precio");
		    	$unidad=odbc_result($a, "id_unidad");
		    	
		    	$cns_subpro="insert into itemizado_subproyecto (codigo, id_padre, descripcion, id_estados, id_usuario, factor_equivalencia, precio_unitario, id_unidades_registro, id_subproyectos)";
		    	$cns_subpro.=" values (";
		    	$cns_subpro.="'".$codigo."',";
		    	$cns_subpro.=$padre.",";
		    	//$cns_subpro.="0,";
		    	/*if($padre ==0)
		    	{
		    		$cns_subpro.="0,";
		    	}
		    	else
		    	{
		    		$codigo_padre=number_format(substr($codigo, 0, -2));
		    		
		    		$cns_id="select id from itemizado_subproyecto where codigo='".$codigo_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND descripcion='".$descripcion_padre."'";
		    		echo $cns_id."<br/>";
		    		$res=get_datos($cns_id);
		    		while(odbc_fetch_row($res))
		    		{
		    			$cns_subpro.=odbc_result($res, "id").",";
		    		}
		    		//$cns_subpro.=$padre_0.",";
		    	}*/
		    	
		    	$cns_subpro.="'".$descripcion."',";
		    	$cns_subpro.="1,";
		    	$cns_subpro.="'".$_SESSION['usuario']['usuario']."',";
		    	$cns_subpro.="1,";
		    	$cns_subpro.=$precio.",";
		    	$cns_subpro.=$unidad.",";
		    	$cns_subpro.="20)";
		    	echo $cns_subpro."<br/>";
		    	get_datos($cns_subpro);
		    	
		    	
		    	$padre=get_padre($padre,$subproyecto,$codigo);
		    	
		    	/*if($padre==0)
		    	{
		    		$padre=0;
		    	}
		    	else
		    	{
		    		$cont=0;
		    		$cod_padre="";
		    		while($cont<$arr_largo-1)
		    		{
		    			$cod_padre.=$arr_codigo[$cont].".";
		    			$cont++;
		    		}
		    		$cod_padre=substr($cod_padre, 0, -1);
		    		$cns_id="select id from itemizado_subproyecto where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_subproyectos=20";
		    		echo $cns_id."<br/>";
		    		$z=get_datos($cns_id);
		    		while (odbc_fetch_row($z))
		    		{
		    			$padre=odbc_result($z, "id");
		    		}
		    	}
		    	
		    	
		    	
		    	$cns_id = "SELECT @@IDENTITY AS ID";
			    $b = get_datos($cns_id);
			    while (odbc_fetch_row($b))
			    {
			        $ultimo_id = odbc_result($b, "ID");
			        //echo $ultimo_id."<br/>";
			    }
			    //$padre_0=$ultimo_id;
			    if($padre!=0)
			    {
			    	$
			    }
			    $codigo_padre=$codigo;
			    $descripcion_padre=$descripcion;*/
		    	
		    	/*if($padre==0)
		    	{
			    	$cns_subpro="insert into itemizado_subproyecto (codigo, id_padre, descripcion, id_estados, id_usuario, factor_equivalencia, precio_unitario, id_unidades_registro, id_subproyectos)";
			    	$cns_subpro.=" values (";
			    	$cns_subpro.="'".$codigo."',";
			    	$cns_subpro.=$padre.",";
			    	$cns_subpro.="'".$descripcion."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.="'".$_SESSION['usuario']['usuario']."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.=$precio.",";
			    	$cns_subpro.=$unidad.",";
			    	$cns_subpro.="20)";
			    	//echo $cns_subpro."<br/>";
			    	get_datos($cns_subpro);
			    }
			    else
			    {
			    	
			    	$cns_subpro="insert into itemizado_subproyecto (codigo, id_padre, descripcion, id_estados, id_usuario, factor_equivalencia, precio_unitario, id_unidades_registro, id_subproyectos)";
			    	$cns_subpro.=" values (";
			    	$cns_subpro.="'".$codigo."',";
			    	$cns_subpro.=$id_padre.",";
			    	$cns_subpro.="'".$descripcion."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.="'".$_SESSION['usuario']['usuario']."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.=$precio.",";
			    	$cns_subpro.=$unidad.",";
			    	$cns_subpro.="20)";
			    	echo $cns_subpro."<br/>";
			    	
			    	$cns_subpro="select id from itemizado_subproyecto where codigo='".$codigo."' and descripcion='".$descripcion."' and precio_unitario=".$precio." and id_estados=1 and id_subproyectos=20";
			    	$c=get_datos($cns_subpro);
			    	$id_padre=0;
			    	while (odbc_fetch_row($c))
				    {
				    	$id_padre=odbc_result($c, "id");
				    }
			    	
			    */	
			    	//get_datos($cns_subpro);
			    //}
		    	
		    }
	    	$error="Archivo cargado correctamente.";
	    }
	}
	else
	{
		$error="&nbsp;&nbsp;&nbsp;No es posible realizar la carga masiva pues el nombre de la carga ya existe en el sistema.";
	}
	
	echo "<br/><br/><div class='alert mensajes'><br/><strong><h2>Importante!</h2><br />&nbsp;&nbsp;&nbsp;".$error."</strong><br/><br/></div>";
	
}

function get_padre($padre,$subproyecto,$codigo)
{
	$arr_codigo=explode(".",$codigo);
	$arr_largo=count($arr_codigo);
	if($padre==0)
	{
		$padre=0;
	}
	else
	{
		$cont=0;
		$cod_padre="";
		while($cont<$arr_largo-1)
		{
			$cod_padre.=$arr_codigo[$cont].".";
			$cont++;
		}
		$cod_padre=substr($cod_padre, 0, -1);
		$cns_id="select id from itemizado_subproyecto where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_subproyectos=20";
		echo $cns_id."<br/>";
		$z=get_datos($cns_id);
		while (odbc_fetch_row($z))
		{
			$padre=odbc_result($z, "id");
		}
	}
	return $padre;

}

function valida_nulos($texto, $item)
{
	$arr=explode(".",$item);
	$largo=count($arr);
	if($largo>1)
	{
		if($texto != "")
		{
			$texto=$texto;
		}
		else
		{
			$texto=false;
		}
	}
	else
	{
		$texto=true;
	}
	return $texto;
}

function valida_version($nombre)
{
	$cns="select count(id) as cant from itemizado_pmo where nombre = '".$nombre."'";
	$a=get_datos($cns);
	$cnt=0;
	while (odbc_fetch_row($a))
    {
    	$cnt=odbc_result($a, "cant");
    }
    if($cnt == 0)
    {
    	$cnt=false;
    }
    else
    {
    	$cnt=true;
    }
    return $cnt;
}

function get_id_unidad($unidad)
{
	$id=0;
	$cns="select id from unidades_registro where abreviacion='".$unidad."'";
	$a=get_datos($cns);
	while (odbc_fetch_row($a))
    {
    	$id=odbc_result($a, "id");
    }
    /*if($id == '')
    {
    	$id = 0;
    }*/
    return $id;
}

function reemplazar($texto)
{
	//$texto=str_replace("'","",$texto);
	$texto=ereg_replace('"', '', $texto);
	//$texto=encoder(mb_convert_encoding($texto,"HTML-ENTITIES","UTF-8"));
	/*$texto=str_replace('"','\"',$texto);
	return addslashes($texto);*/
	//$texto=str_replace('Ф','',$texto);
	return $texto;
}

function valida_numerico($valor)
{
	if(is_numeric($valor))
	{
		$valor=true;
	}
	else
	{
		$valor=false;
	}
	return $valor;
}
?>