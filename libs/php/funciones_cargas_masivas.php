<?php
require_once('libs/excel/reader.php');
require_once('sql_sigp.php');
require_once('generales.php');

function lectura_subpro($fname, $version, $subproyecto)
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
				$cns="insert into itemizado_carga_masiva (codigo, descripcion, id_unidad, version, precio) values ('".$item."','".$descripcion."',".$unidad.",'".$version."',".$precio.")";
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
	    	///*CARGA DE LOS DATOS A LA TABLA ITEMIZADO_SUBPROYECTO
	    	$cns="select id, codigo, id_padre, descripcion, precio, id_unidad from itemizado_carga_masiva order by id ASC";
	    	$a=get_datos($cns);
	    	$padre=0;
	    	while (odbc_fetch_row($a))
		    {
		    	$codigo=odbc_result($a, "codigo");
		    	$descripcion=odbc_result($a, "descripcion");
		    	$precio = odbc_result($a, "precio");
		    	$unidad=odbc_result($a, "id_unidad");
		    	
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
		    	$cns_subpro.=$subproyecto.")";
		    	//echo $cns_subpro."<br/>";
		    	get_datos($cns_subpro);
		    }
		    /*$cns="select id, codigo from itemizado_subproyecto where fecha_ingreso='".date('Y-m-d')."' AND id_subproyectos=".$subproyecto." order by id ASC";
	    	$a=get_datos($cns);
	    	while (odbc_fetch_row($a))
	    	{
	    		$id=odbc_result($a, "id");
	    		$padre=0;
	    		$codigo=odbc_result($a, "codigo");
	    		$arr_codigo=explode(".",$codigo);
	    		$arr_largo=count($arr_codigo);
	    		if($arr_largo==1)
	    		{
	    			$cns_updt="update itemizado_subproyecto set id_padre=0 where id=".$id;
	    		}
	    		else
	    		{
	    			$cod_padre="";
	    			$cont=0;
	    			while($cont<$arr_largo-1)
	    			{
	    				$cod_padre.=$arr_codigo[$cont].".";
	    				$cont++;
	    			}
	    			$cod_padre=substr($cod_padre, 0, -1);
	    			$cns_busca_padre="select id from itemizado_subproyecto where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_subproyectos=20";
	    			//echo $cns_busca_padre."<br/>";
	    			$b=get_datos($cns_busca_padre);
	    			while (odbc_fetch_row($b))
	    			{
	    				$padre=odbc_result($b, "id");
	    			}
	    			$codigo=$arr_codigo[$arr_largo-1];
	    			$cns_updt="update itemizado_subproyecto set id_padre=".$padre." where id=".$id;
	    			echo $cns_updt."<br/>";
	    			get_datos($cns_updt);
	    		}
	    	}
	    	$a="";
	    	$a=get_datos($cns);
	    	while (odbc_fetch_row($a))
	    	{
	    		$id=odbc_result($a, "id");
	    		$padre=0;
	    		$codigo=odbc_result($a, "codigo");
	    		$arr_codigo=explode(".",$codigo);
	    		$arr_largo=count($arr_codigo);
	    		if($arr_largo>1)
	    		{
	    			$cod_padre="";
	    			$cont=0;
	    			while($cont<$arr_largo-1)
	    			{
	    				$cod_padre.=$arr_codigo[$cont].".";
	    				$cont++;
	    			}
	    			$cod_padre=substr($cod_padre, 0, -1);
	    			$cns_busca_padre="select id from itemizado_subproyecto where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_subproyectos=20";
	    			echo $cns_busca_padre."<br/>";
	    			$b=get_datos($cns_busca_padre);
	    			while (odbc_fetch_row($b))
	    			{
	    				$padre=odbc_result($b, "id");
	    			}
	    			$codigo=$arr_codigo[$arr_largo-1];
	    			$cns_updt="update itemizado_subproyecto set codigo=".$codigo." where id=".$id;
	    			echo $cns_updt."<br/>";
	    			get_datos($cns_updt);
	    		}
	    	}*/
	    	
	    	$error="Archivo cargado correctamente.";
	    }
	}
	else
	{
		$error="&nbsp;&nbsp;&nbsp;No es posible realizar la carga masiva pues el nombre de la carga ya existe en el sistema.";
	}
	
	echo "<br/><br/><div class='alert mensajes'><br/><strong><h2>Importante!</h2><br />&nbsp;&nbsp;&nbsp;".$error."</strong><br/><br/></div>";
	
}
/*NO TOCAR PARA ARRIBA!!!!!!!!!!!!!!!!!!!!!!!!!!!!
**************************************************
*************************************************
**************************************************/

function lectura_pmo($fname, $version, $empresa)
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
	if($version!="")
	{
		echo "Preparando para leer archivo<br />";
		$cns="select count(id) as cant from itemizado_pmo_version where nombre = '".$verison."'";
		$existencia=0;
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$existencia=odbc_result($a, "cant");
		}
		if($existencia==0)
		{
			$cns="insert into itemizado_pmo_version (nombre, fecha_creacion,id_estados) values ('".$version."','".date('Y-m-d')."',1)";
			get_datos($cns);
			$cns="select id from itemizado_pmo_version where nombre ='".$version."' AND  fecha_creacion = '".date('Y-m-d')."'";
			$a=get_datos($cns);
			while(odbc_fetch_row($a))
			{
				$version=odbc_result($a, "id");
			}
			while($fila<=$data->sheets[0]['numRows'])
			{
				$contador_filas++;
				$item=$data->sheets[0]['cells'][$fila][1];
				$descripcion=$data->sheets[0]['cells'][$fila][2];
				//echo $data->sheets[0]['cells'][$fila][2]."<br/>";
				$unidad=get_id_unidad($data->sheets[0]['cells'][$fila][3]);
				$equivalencia=1;
				$descripcion=reemplazar($descripcion);
				
				if($item[strlen($item)-1]==".")
				{
					$item=substr($item, 0, -1);
				}
				
				if($descripcion!="" )
				{
					$cns="insert into itemizado_carga_masiva (codigo, descripcion, id_unidad, version) values ('".$item."','".$descripcion."',".$unidad.",".$version.")";
					//echo $cns;
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
		    	///*CARGA DE LOS DATOS A LA TABLA ITEMIZADO_PMO
		    	$cns="select id, codigo, id_padre, descripcion, id_unidad from dbo.itemizado_carga_masiva order by id ASC";
		    	$a=get_datos($cns);
		    	$padre=0;
		    	while (odbc_fetch_row($a))
			    {
			    	$codigo=odbc_result($a, "codigo");
			    	$descripcion=odbc_result($a, "descripcion");
			    	$unidad=odbc_result($a, "id_unidad");
			    	
			    	$cns_subpro="insert into itemizado_pmo (codigo, id_padre, descripcion, id_estados, id_usuario, factor_equivalencia, id_unidad, id_empresas, id_version)";
			    	$cns_subpro.=" values (";
			    	$cns_subpro.="'".$codigo."',";
			    	$cns_subpro.=$padre.",";
			    	$cns_subpro.="'".$descripcion."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.="'".$_SESSION['usuario']['usuario']."',";
			    	$cns_subpro.="1,";
			    	$cns_subpro.=$unidad.",";
			    	$cns_subpro.=$empresa.",";
			    	$cns_subpro.=$version.")";
			    	//echo $cns_subpro."<br/>";
			    	get_datos($cns_subpro);
			    }
			    $cns="select id, codigo from itemizado_pmo where fecha_ingreso='".date('Y-m-d')."' AND id_empresas=".$empresa." AND id_version=".$version." order by id ASC";
		    	$a=get_datos($cns);
		    	while (odbc_fetch_row($a))
		    	{
		    		$id=odbc_result($a, "id");
		    		$padre=0;
		    		$codigo=odbc_result($a, "codigo");
		    		$arr_codigo=explode(".",$codigo);
		    		$arr_largo=count($arr_codigo);
		    		if($arr_largo==1)
		    		{
		    			$cns_updt="update itemizado_pmo set id_padre=0 where id=".$id;
		    		}
		    		else
		    		{
		    			$cod_padre="";
		    			$cont=0;
		    			while($cont<$arr_largo-1)
		    			{
		    				$cod_padre.=$arr_codigo[$cont].".";
		    				$cont++;
		    			}
		    			$cod_padre=substr($cod_padre, 0, -1);
		    			$cns_busca_padre="select id from itemizado_pmo where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_empresas=".$empresa;
		    			//echo $cns_busca_padre."<br/>";
		    			$b=get_datos($cns_busca_padre);
		    			while (odbc_fetch_row($b))
		    			{
		    				$padre=odbc_result($b, "id");
		    			}
		    			$codigo=$arr_codigo[$arr_largo-1];
		    			$cns_updt="update itemizado_pmo set id_padre=".$padre." where id=".$id;
		    			//echo $cns_updt."<br/>";
		    			get_datos($cns_updt);
		    		}
		    	}
		    	$a="";
		    	$a=get_datos($cns);
		    	while (odbc_fetch_row($a))
		    	{
		    		$id=odbc_result($a, "id");
		    		$padre=0;
		    		$codigo=odbc_result($a, "codigo");
		    		$arr_codigo=explode(".",$codigo);
		    		$arr_largo=count($arr_codigo);
		    		if($arr_largo>1)
		    		{
		    			$cod_padre="";
		    			$cont=0;
		    			while($cont<$arr_largo-1)
		    			{
		    				$cod_padre.=$arr_codigo[$cont].".";
		    				$cont++;
		    			}
		    			$cod_padre=substr($cod_padre, 0, -1);
		    			$cns_busca_padre="select id from itemizado_pmo where codigo='".$cod_padre."' AND fecha_ingreso='".date('Y-m-d')."' AND id_empresas=".$empresa;
		    		//	echo $cns_busca_padre."<br/>";
		    			$b=get_datos($cns_busca_padre);
		    			while (odbc_fetch_row($b))
		    			{
		    				$padre=odbc_result($b, "id");
		    			}
		    			$codigo=$arr_codigo[$arr_largo-1];
		    			$cns_updt="update itemizado_pmo set codigo=".$codigo." where id=".$id;
		    			//echo $cns_updt."<br/>";
		    			get_datos($cns_updt);
		    		}
		    	}
		    	
		    	$error="Archivo cargado correctamente.";
		    	unlink($fname);
	    	}
	    }
	    else
	    {
	    	$error="<br/>&nbsp;&nbsp;&nbsp;La versi&oacute;n ya existe y no puede ser reemplazada.<br/>";
	    }
	}
	else
	{
		$error="&nbsp;&nbsp;&nbsp;No es posible realizar la carga masiva pues el nombre de la Versi&oacute;n no es correcto.";
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
	$texto=ereg_replace('"', '', $texto);
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