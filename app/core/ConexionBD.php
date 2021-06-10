<?php

class ConexionBD{

	private $servidor = 'localhost';
	private $usuario = 'root';
	private $pass = '';
	private $BD = 'base_sistema';
	//private $con;


	public function __construct() {
		
		//incializamos conexion en el constractor
        $this->conectarBD = mysqli_connect($this->servidor,$this->usuario,$this->pass,$this->BD); 
		$this->conectarBD->set_charset("utf8");
		
	}

	public function query($setQuery) {
    
        $query = mysqli_query($this->conectarBD, $setQuery);

        return $query;      
    }

    public function multi_query($setQuery) {
    
        $query = mysqli_multi_query($this->conectarBD, $setQuery);

        return $query;      
    }

    public function numero_registros($consulta){

        return mysqli_num_rows($consulta);

    }

    public function consulta_assoc($setFetch) {

        $row = mysqli_fetch_assoc($setFetch);

        return $row;  
    }


    public function consulta_array($setFetch) {

        $res = array();
        while($row = mysqli_fetch_assoc($setFetch)){
            array_push($res, $row);
        }

        return $res;  
    }

    public function real_escape_string($valor) {

        $campo = mysqli_real_escape_string($this->conectarBD, $valor); 

        return $campo;

    }

    public function error() {

        //$error = "Problemas al ejecutar la consulta"; 
        $error = mysqli_error($this->conectarBD);

        return $error;

    }

    public function free_result($result) {

        $res = mysqli_free_result($result);

        return $res;

    }

    public function next_result() {

        $res = mysqli_next_result($this->conectarBD);

        return $res;

    }

    public function store_result() {

        $res = mysqli_store_result($this->conectarBD);

        return $res;

    }

    public function close_conexion() {

        $res = mysqli_close($this->conectarBD);

        return $res;

    }

}

//Inicializamos Fecha y Hora local
//date_default_timezone_set('America/Mazatlan');


?>
