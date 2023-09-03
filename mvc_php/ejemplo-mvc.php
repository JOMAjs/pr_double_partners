<?php 

/*=============================================
VISTA
=============================================*/
$respuesta = Controlador::metodoControlador("hombre");

echo $respuesta;


/*=============================================
CONTROLADOR
=============================================*/

class Controlador{

	static public function metodoControlador($persona){

		if($persona == "hombre"){

			$respuesta = Modelo::metodoModelo($persona);

			return $respuesta;

		}


	}

}


/*=============================================
MODELO
=============================================*/
class Modelo{

	static public function metodoModelo($persona){

		if($persona != ""){

			return "Miguel";
		
		}	

	}

}
