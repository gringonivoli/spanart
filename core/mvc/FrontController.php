<?php

namespace SpanArt\Core\MVC;

/**
 * Clase que recepta todas las peticiones a la aplicacion.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

class FrontController{
	
	/**
	 * Start
	 * 
	 * Hace que el motor empiece a mover la app.
	 *
	 * @access public
	 */
	public static function start(){
		$request = Request::getInstancia();
		$armador = Armador::getInstancia();
		$armador->setRequest($request);
		$armador->analizarPeticion();
		$disp    = Dispatcher::getInstancia();
		$disp->setArmador($armador);
		$disp->crearController();
	}
}
// END FrontController Class

/* End of file FrontController.php */
/* Location: ./core/mvc/FrontController.php */