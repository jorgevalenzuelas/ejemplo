<?php
session_start();

if ($_SESSION["cve_usuario"] == "")
{
	header("Location:Login");
}
else
{

	//Heredamos Controlador para poder tener acceso al método modelo y método vista
	class Perfil extends Controlador
	{
		
		public function __construct()
		{

			$this->perfilModelo = $this->modelo('PerfilModelo');

		}



		//Todo controlador debe tener un metodo index
		public function index()
		{
			$this->vista('perfil/Perfil');
		}



		public function consultar()
		{
			$data = $this->perfilModelo->consultar($_POST);

			$envioDatos["arrayDatos"] = $data;

			echo json_encode($envioDatos);
		}



		public function formPerfil()
		{

			$cve_perfil = (empty($cve_perfil)) ? $_POST["cve_perfil"] : 0 ;
			$datosPerfil =  array (
									cvePerfil => $cve_perfil
							     );

			$datos = $this->perfilModelo->obtenerOpcionesMenu($datosPerfil);

			$this->vista('perfil/formPerfil', $datos);
		}



		public function guardarPerfil()
		{
			$datosCompletos = $this->validarDatosVaciosPerfilGuardar($_POST);

			if ($datosCompletos == "vacio")
			{
				$status = "error";
				$msg = "Favor de revisar el formulario, hay campos requeridos vacios.";
			}
			else
			{
				//Preparamos en un array los datos que enviaremos a la BD
				$cve_perfil = (empty($cve_perfil)) ? $_POST["txtcvePerfil"] : 0 ;

				$datosPerfil[0] =  array (
									ban               => 1,
									nombrePerfil      => $_POST["txtNombrePerfil"],
									descipcionPerfil  => $_POST["txtDescipcionPerfil"],
									cvePerfil         => $cve_perfil,
							     	cveusuario_accion => $_SESSION["cve_usuario"]
							     );

				$datosPerfil[1] = array (
									chk2_grafica              => $_POST["chk2_grafica"],
									chk2_registro              => $_POST["chk2_registro"],
									chk2_modulo              => $_POST["chk2_modulo"],
									chk2_submodulo              => $_POST["chk2_submodulo"],
									chk2_alumno              => $_POST["chk2_alumno"],
									chk2_grado              => $_POST["chk2_grado"],
									chk2_medida              => $_POST["chk2_medida"],
									chk2_aprendizaje              => $_POST["chk2_aprendizaje"],
									chk2_usuario              => $_POST["chk2_usuario"],
									chk2_perfil               => $_POST["chk2_perfil"],
									chk2_sucursal             => $_POST["chk2_sucursal"],
									chk2_puesto               => $_POST["chk2_puesto"]
							     );

				//print_r($datosPerfil[1]);
				
				$respuesta = $this->perfilModelo->guardarPerfil($datosPerfil);

				
				if ($respuesta == true)
				{
					$msg = "Perfil guardado con Éxito.";
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



		public function validarDatosVaciosPerfilGuardar($dataPost)
		{
			if(empty($dataPost["txtNombrePerfil"]) || !trim($dataPost["txtNombrePerfil"])){ $status = "vacio"; }
			elseif(empty($dataPost["txtDescipcionPerfil"]) || !trim($dataPost["txtDescipcionPerfil"])){ $status = "vacio"; }
			else{
				$status = "completo";
			}

			return $status;
		}



		public function bloquearPerfil()
		{
			$datosPerfil =  array (
								ban                 => $_POST["ban"],
								cve_perfil         => $_POST["cve_perfil"],
								cveusuario_accion   => $_SESSION["cve_usuario"]
						     );

			$respuesta = $this->perfilModelo->bloquearPerfil($datosPerfil);

			if ($respuesta == true)
			{
				if ($datosPerfil['ban'] == 2)
				{
					$msg = "Perfil bloqueado.";
				}else{
					$msg = "Perfil desbloqueado.";
				}
				$status = "success";
			}
			else
			{
				//Este error se presenta por un error en el query
				$msg = "Hubo un error al bloquear el registro.";
				$status = "error";
			}

			$envioDatos["status"] = $status;
			$envioDatos["msg"] = $msg;
			echo json_encode($envioDatos);
		}
		
	}

}


?>