<?php
session_start();
$modulo = $_REQUEST['id'];

$_SESSION["usuario"]['modulo']=$modulo;

?>