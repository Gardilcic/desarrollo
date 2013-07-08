<style>
    body{
        font: normal 13px Arial;	
        padding-top: 20px;
    }
    .barra{
        background: url('libs/img/barra.jpg') center repeat-y; 
        background-color: #EEE; border: 0px;
        height: 8px;
    }
    .derecha{
        text-align:right;
    }
    .color-negro{
        font-weight: bold;
        color: black;
    }
    .color-verde{
        font-weight: bold;
        color: #5c9a4d;
    }
    .color-plomo{
        color: #b5b5b5;
    }
    th.headerSortUp { 
        background-image: url('libs/img/asc.gif'); 
        background-repeat: no-repeat;
        background-position: 95%;
    } 
    th.headerSortDown { 
        background-image: url('libs/img/desc.gif'); 
        background-repeat: no-repeat;
        background-position: center right; 

    } 
    th.header {  
        /*background-image: url('libs/img/bg.gif');   */  
        cursor: pointer; 
        font-weight: bold; 
        background-repeat: no-repeat; 
        background-position: center right; 
        border-right: 1px solid #dad9c7; 
        margin-left: -1px; 
        background-color: #EEE;

    } 

</style>  
<style>

    #carousel {
        width:900px;
        height: 130px;
        display: relative;
        margin: 0 auto;
    }
    .roundabout-holder {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 50%;
    }
    .roundabout-moveable-item {
        cursor: pointer;
        width: 35%; 
        height: 100px; 
        margin: 0px; 
        border: 2px solid #1d803a;
        background-color: #fff;
        border-radius: 10px;
        font-size: 14px; 
        font-weight: bold; 
    }
    .roundabout-moveable-item img {
        float: left;
        width:  28%;
        padding: 10px 10px 0px 20px;
    }
    .roundabout-moveable-item p {
        float: left;       
        width: 50%;
        padding: 23px 0px 0px 0px;
        text-align: center;
        /*border: 1px solid #F0F;*/
    }
    .roundabout-in-focus {
        cursor: auto;
    }
</style>
<div class="navbar navbar-fixed-top">
    <div class="barra">
        <div class="container" style="width:80%;"></div>
    </div>
</div>

<div class="container">
    <div style="position: absolute; float: left;"><img src="libs/img/logo.jpg" border="0" /></div>
    <div style="position: absolute; float: right; left: 77%;">
        <p><span class="color-negro">Bienvenido:</span> <span class="color-verde"><?php echo $_SESSION["usuario"]['usuario']; ?></span> <span class="color-plomo"><a href="exit.php">[Salir]</a></span> </p>
    </div>

    <ul id="carousel">
    </ul>

    <br />
    <div class="navbar barra-menu" id="menu6" >  
        <div class="navbar-inner">  
            <div class="container">  
                <ul class="nav menuprincipal">  
                    <!--a class="brand" href="#"></a-->  
                    <li class="dropdown" id="accountmenu">  
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mantenedores<b class="caret"></b></a>  
                        <ul class="dropdown-menu" id="mantenedores">                                                   
                        </ul>  
                    </li>  
                    <li class="dropdown" id="accountmenu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultas e Informes<b class="caret"></b></a>  
                        <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a tabindex="-1" href="#">Action</a></li>
                            <li><a tabindex="-1" href="#">Another action</a></li>
                            <li><a tabindex="-1" href="#">Something else here</a></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">More options</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="#">Action</a></li>
                                    <li><a tabindex="-1" href="#">Another action</a></li>
                                    <li><a tabindex="-1" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li><a tabindex="-1" href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>  

                <ul class="nav pull-right">
                	<li><a href="adm_mensajes.php">
                		Mensajes nuevos(
                			<?php
                				echo get_cant_nuevos_mensajes($_SESSION['usuario']['usuario']);
                			?>
                		)</a>
                	</li>
                    <li><a href="#" data-toggle='modal'><i class="icon-circle-arrow-right" title="Objetivos" onclick="popup_obj();"></i></a></li>
                    <li><a href="#" data-toggle='modal'><i class="icon-file" title="Detalle" onclick="popup_det();"></i></a></li>
                    <li><a href="#" data-toggle='modal'><i class="icon-download-alt" title="Descargar archivo" onclick="popup_doc();"></i></a></li>
                    <li><a href="adm_usuarios.php"><i class="icon-home"></i></a></li>
                </ul>
            </div>  
        </div>  
    </div>  
</div>
<?php 
function get_cant_nuevos_mensajes($usuario)
{
	require_once('sql_sigp.php');
	$id = 0;
	$cant = 0;
	$cns0="select id from estados where nombre = 'Enviado' and id_tipo=6";
	$a = get_datos($cns0);
	while(odbc_fetch_row($a))
	{
		$id=odbc_result($a, "id");
	}
	if($id != 0)
	{
		$cns0="select count(id) as cant from mensajes where id_estados = ".$id." and receptor='".$usuario."'";
		$a=get_datos($cns0);
		while(odbc_fetch_row($a))
		{
			$cant=odbc_result($a, "cant");
		}
	}
	return $cant;
}
?>
