<?php
class BD {
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	var $Conexion_ID = 0;
	var $Consulta_ID = 0;
	var $Resultado_ID = 0;
	var $Errno = 0;
	var $Error = "";
	function BD($bd = "", $host = "", $user = "", $pass = "") {
		$this->BaseDatos = $bd;
		$this->Servidor = $host;
		$this->Usuario = $user;
		$this->Clave = $pass;
	}
	function con($bd, $host, $user, $pass){
		if ($bd != "") $this->BaseDatos = $bd;
		if ($host != "") $this->Servidor = $host;
		if ($user != "") $this->Usuario = $user;
		if ($pass != "") $this->Clave = $pass;
		$this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);
		$set_utf8 = mysql_query("SET NAMES utf8",$this->Conexion_ID);
		if (!$this->Conexion_ID) {
			$this->Error = "Conecction fail.";
			return 0;
		}
		if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
			$this->Error = "Not possible to open ".$this->BaseDatos ;
			return 0;
		}
		return $this->Conexion_ID;
	}
	function sql($sql = ""){
		if ($sql == "") {
			$this->Error = "No SQL query specified";
			return 0;
		}
		$this->Consulta_ID = @mysql_query($sql, $this->Conexion_ID);
		if (!$this->Consulta_ID) {
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();
		}
		return $this->Consulta_ID;
	}
}
?>