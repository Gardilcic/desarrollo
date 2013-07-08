<?php
class sql
{
	private $host;
	private $user;
	private $pass;
	private $db;
	private $qString;
	private $conexion;
	private $resultado;

	public function __construct()
	{
		$this->host = '127.0.0.1';
		$this->user = 'root';
		$this->pass = '';
		$this->db = 'documentacion';
		/*$this->user = "report_user";
		$this->pass = "r3p0rt3";
		$this->db = "admin_sistema_reportes";*/
		$this->qString = "";
		$this->conectar();
	}

	public function __destruct()
	{
		unset ($this->user, $this->pass);
	}
	
	private function conectar()
	{
		$this->conexion = mysql_connect($this->host,$this->user,$this->pass) OR die('Error al conectar (con) - error: '.mysql_error());
		if($this->conexion)	
			mysql_select_db($this->db) OR die('Error al conectar (db) - error: '.mysql_error());
		return $this->conexion;
	}
	
	public function ejecutar($qString)
	{
		$this->qString = $qString;
		$this->conectar();
		if($this->resultado = mysql_query($this->qString,$this->conexion))
		{
			//$this->escribe_log();
			return $this->resultado;
		}
		else
			echo 'Error en la consulta - error: '.mysql_error();		
	}
	
	public function get_conexion()
	{
		return $this->conexion;
	}
	
	public function retorna($qString){
		$this->qString = $qString;
		$this->conectar();
		$data = array();
		$this->resultado = $this->ejecutar($qString);
		while($row = mysql_fetch_object($this->resultado))
			$data[]= $row;
			$this->cerrar();
		return $data;
	}

	public function cerrar()
	{
		mysql_close($this->conexion);
		mysql_free_result($this->resultado);
	}
	public function free_result()
	{
		mysql_free_result($this->resultado);
	}
}

?>