<?php
session_start();

if ($_SESSION["cve_usuario"] == "")
{
	header("Location:Login");
}
else
{

	//Heredamos Controlador para poder tener acceso al método modelo y método vista
	class Llavero extends Controlador
	{
		
		public function __construct()
		{

			//$this->homeModelo = $this->modelo('HomeModelo');

		}

		//Todo controlador debe tener un metodo index
		public function index()
		{
			$this->vista('llavero/Llavero');
		}

		public function guardarLlavero()
		{
			$datosCompletos = $this->validarDatosVaciosLlavero($_POST);

			if ($datosCompletos == "vacio")
			{
				$status = "error";
				$msg = "Favor de revisar el formulario, hay campos requeridos vacios.";
			}
			else
			{
				//Preparamos en un array los datos que enviaremos a la BD
				$cve_puesto = (empty($cve_puesto)) ? $_POST["txtcvePuesto"] : 0 ;

				$datosPuesto =  array (
									ban               => 1,
									nombrePuesto      => $_POST["txtNombrePuesto"],
									cve_puesto        => $cve_puesto,
							     	cveusuario_accion => $_SESSION["cve_usuario"]
							     );
				
				$respuesta = $this->puestoModelo->guardarPuesto($datosPuesto);

				
				if ($respuesta == true)
				{
					$msg = "Puesto guardado con Éxito.";
					$status = "success";
				}
				else
				{
					$msg = "Hubo un error al guardar el registro.";
					$status = "error";
			
			
				}
				
			}

			
			$envioDatos["status"] = $status;
			$envioDatos["msg"] = $msg;
			echo json_encode($envioDatos);
			
		}

		public function validarDatosVaciosLlavero($dataPost)
		{
			if(empty($dataPost["nombre"]) || !trim($dataPost["nombre"])){ $status = "vacio"; }
			else if(empty($dataPost["edad"]) || !trim($dataPost["edad"])){ $status = "vacio"; }
			else if(empty($dataPost["nombre"]) || !trim($dataPost["nombre"])){ $status = "vacio"; }
			else
			else{
				$status = "completo";
			}

			return $status;
		}

	}

}


?>