<?php

namespace SpanArt\Core\MVC;

use SpanArt\Core\Libs\NamespaceManager;
use SpanArt\Core\Traits\MVCNames;

/**
 * Clase abstracta que deberian extender los controllers de la aplicacion.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

abstract class Controller{

    /**
     * @var View
     */
	protected $view;
	private $module;
	private $controllerName;
	Private $method;

	use MVCNames;

	/**
	 * Constructor
	 *
	 * @param string $method (metodo a ejecutar en el controller)
	 * @param array $args (los argumentos del metodo)
	 * @param string $controller (nombre del controller como viene en la peticion, primera en mayuscula)
	 * @param string $module (modulo al que pertenece el controller)
	 *
	 */
	public function __construct($method = '', $args=array(), $controller = '', $module = ''){
		$this->module 	      = $module;
		$this->controllerName = $controller;
		$this->method 	      = $method;
		$this->setAuto();
		if($method != '')
			call_user_func_array(array($this, $method), $args);
	}

	/**
	 * SetAuto
	 * 
	 * Setea, si asi esta configurado, la view por defecto que
	 * corresponden al controller.
	 * 
	 * @access private
	 */
	private function setAuto(){
		####if(SpanArt::$AUTOVIEW AND RequireSafe::getInstancia()->requireFile(SpanArt::$APP_PATH."modules/{$this->module}/views/{$this->controllerName}"))
			$this->setAutoView();
	}

	/**
	 * Set Auto View
	 *
	 * Crea la vista correspondiente al controller que se llama 
	 * y se asigna a una propiedad visible al controller.
	 *
	 * @access protected
	 * @param string (nombre del controller para construir el nombre de la view)
	 */
	protected function setAutoView(){
		$viewObj = $this->buildViewName($this->controllerName);

        $namespace = NamespaceManager::getNamespace(
            $this->module,
            NamespaceManager::$VIEW
        );

        $namespace .= $viewObj;

		if(class_exists($namespace)){
			$this->view = new $namespace($this->module, $this->controllerName, $this->method);
		}
	}

    /**
     * Set View
     *
     * Permite el seteo de un objeto vista personalizado.
     * (se debe conocer como crear un objeto vista de la manera correcta).
     *
     * @access protected
     * @param Object|View $view objeto vista del controller.
     */
	protected function setView(View $view){
		$this->view = $view;
	}
}
// END Controller Class

/* End of file Controller.php */
/* Location: ./core/mvc/Controller.php */