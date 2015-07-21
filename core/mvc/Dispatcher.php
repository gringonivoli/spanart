<?php

namespace SpanArt\Core\MVC;

use SpanArt\Core\Interfaces\ISingleton;
use SpanArt\Core\Libs\NamespaceManager;
use SpanArt\Core\Traits\Singleton;
use SpanArt\SpanArt;

/**
 * Clase que carga y llama al controlador que corresponda.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

class Dispatcher implements ISingleton{
	
	private $armador;

	use Singleton;

	/**
	 * Contructor
	 *
	 * @access private
	 */
	private function __construct(){}

	public function __clone(){}

	/**
	 * Set Armador
	 * 
	 * Setea la propiedad armador con el objeto Armador
	 * 
	 * @access public
	 * @param Armador $armador Objeto del tipo Armador.
	 */
	public function setArmador(Armador $armador){
		$this->armador = $armador;
	}

	/**
	 * Crear Controller
	 * 
	 * Crea el controller especificado en la petición, que ya fue procesada 
	 * por el armador para que su formato sea el adecuado.
	 * 
	 * @access public
	 */
	public function crearController(){
		$controllerName = $this->armador->getControllerName();

        $namespace = NamespaceManager::getNamespace(
            $this->armador->getModule(),
            NamespaceManager::$CONTROLLER
        );

        $namespace .= $controllerName;

        if(!class_exists($namespace) && SpanArt::$SPANART_ENV == "production"){
            $this->armador->setNotfound();
            $this->crearController();
        }

		new $namespace($this->armador->getMethod()
									, $this->armador->getArgs()
									, $this->armador->getController()
									, $this->armador->getModule());
	}
}
// END Dispatcher Class

/* End of file Dispatcher.php */
/* Location: ./core/mvc/Dispatcher.php */