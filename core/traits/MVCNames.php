<?php

namespace SpanArt\Core\Traits;

/**
 * 
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package Traits
 */

trait MVCNames{

	/**
 	* Build Controller Name
 	* 
 	* Genera un nombre correcto para el controller.
 	* Generalmente la forma en como se debe llamar la clase.
 	*
 	* @access public
 	* @param string $controller generalmente el nombre del fichero del controlador.
 	* @return string
 	*/	
	public function buildControllerName($controller = ""){
		if($controller != ""){
			$controller = $controller."Controller";
		}
		return $controller;
	}

	/**
 	* Build View Name
 	* 
 	* Genera un nombre correcto para la view.
 	* Generalmente la forma en como se debe llamar la clase.
 	*
 	* @access public
 	* @param string $view generalmente el nombre del fichero de la vista.
 	* @return string
 	*/
	public function buildViewName($view = ""){
		if($view != ""){
			$view = $view."View";
		}
		return $view;
	}
}
// END MVCNames Trait

/* End of file MVCNames.php */
/* Location: ./core/traits/MVCNames.php */