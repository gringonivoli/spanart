<?php

namespace SpanArt\Core\MVC;

use SpanArt\Core\Interfaces\ISingleton;
use SpanArt\Core\Traits\MVCNames;
use SpanArt\Core\Traits\Singleton;
use SpanArt\Core\Traits\U;
use SpanArt\SpanArt;


/**
 * Clase que de acuerdo a la ruta, argumentos (de la peticion) y configuracion 
 * prepara a quien y adonde hay que llamar.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

class Armador implements ISingleton{
	private $module;
	private $controller;
	private $method;
	private $args;
	
	private $controllerName;
	private $rutaController;
	
	private $request;

	use Singleton, MVCNames, U;

	/**
	 * Constructor.
	 * 
	 * @access private
	 */
	private function __construct(){
		//$this->error   = false;
	}

	public function __clone(){}

	/**
	 * Set Request
	 * 
	 * Setea la propiedad request con un objeto del tipo Request.
	 * 
	 * @access public
	 * @param Request $request objeto del tipo Request.
	 */
	public function setRequest(Request $request){
		$this->request = $request;
	} 

	/**
	 * Analizar Peticion.
	 *
	 * Analiza el array con los miembros de la request y 
	 * llama a la funcion set_peticiones.
	 *
	 * @access public
	 */
	public function analizarPeticion(){
		$peticion       = $this->request->getUriArray();
		$numeroMiembros = count($peticion);
		$this->setPeticion($numeroMiembros,$peticion);
	}

	/**
	 * Set Peticiones.
	 * 
	 * De acuerdo al tipo de peticion y a su numero de miembros 
	 * llama a la funcion correspondiente.
	 * 
	 * @access private
	 * @param int   (numero de miembros de la peticion)
	 * @param array (array que contiene los miembros de la peticion)
	 */
	private function setPeticion($numeroMiembros, $peticion){
		if($numeroMiembros == 0){
			$this->setDefaultInit();
		}elseif($numeroMiembros >= 3){
			$this->setCustomPeticion($peticion);
		}elseif($numeroMiembros == 2){
			array_push($peticion,"index");
			$this->setCustomPeticion($peticion);
		}
		$this->prepareRutaController();
		$this->setArgs();
	}

	/**
	* Set Default Init
	*
	* LLamada por set_peticion, setea module, controller y 
	* method con los valores por defecto especificados en 
	* el archivo de configuracion.
	*
	* @access private
	*/
	private function setDefaultInit(){
			$this->module 	   = SpanArt::$INIT_MODULE;
			$this->controller  = SpanArt::$INIT_CONTROLLER;
			$this->method      = SpanArt::$INIT_METHOD;
	}

	/**
	 * Set Not Found
	 * 
	 * Setea lo que se mostrara en caso de ingresar a una dirección no valida.
	 * 
	 * @access public
	 */
	public function setNotFound(){
		$this->module 	   = SpanArt::$NF_MODULE;
		$this->controller  = SpanArt::$NF_CONTROLLER;
		$this->method      = SpanArt::$NF_METHOD;
		$this->prepareRutaController();
		$this->setArgs();
	}

	/**
	 * Set Custom Peticion
	 *
	 * Llamada por set_peticiones, setea module, controller y 
	 * method con los miembros del array peticion.
	 *
	 * @access private
	 * @param array (array que contiene los miembros de la peticion)
	 */
	private function setCustomPeticion($peticion){
		list($this->module, $this->controller, $this->method) = $peticion;
		$this->controller = $this->whateverToCamelcase($this->controller, true);
        $this->module = $this->whateverToCamelcase($this->module);
        $this->method = $this->whateverToCamelcase($this->method);
	}

	/**
	 * Set Args
	 *
	 * Setea args con el array de argumentos devuelto por el 
	 * objeto request.
	 *
	 * @access private
	 */
	private function setArgs(){
			$this->args = $this->request->getArgsArray();
	}

	/**
	 * Prepare Controller Name
	 *
	 * Haciendo uso del trait MVCNames y su método buildControllerName 
	 * setea a controllerName.
	 *
	 * @access private
	 */
	private function prepareControllerName(){
		$this->controllerName = $this->buildControllerName($this->controller);
	}

	/**
	 * Prepare Ruta Controller
	 *
	 * Arma la ruta en donde se encuentra el controller 
	 * de la peticion.
	 *
	 * @access private
	 */
	private function prepareRutaController(){
		$this->rutaController = SpanArt::$APP_PATH."modules/{$this->module}/controllers/{$this->controller}";
	}

	/**
	 * Get Controller Name
	 *
	 * Devuelve el nombre del controller. 
	 *
	 * @access public
	 * @return string (Nombre de la clase controller)
	 */
	public function getControllerName(){
		$this->prepareControllerName();
		return $this->controllerName;
	}

	/**
	 * Get Ruta Controller
	 *
	 * Devuelve la ruta del controller.
	 *
	 * @access public
	 * @return string (ruta en donde se encuentra el fichero del controlador)
	 */
	public function getRutaController(){
		return $this->rutaController;
	}

	/**
	 * Get Resource
	 *
	 * Devuelve el metodo a ejecutar por el controller.
	 *
	 * @access public
	 * @return string
	 */
	public function getMethod(){
		return $this->method;
	}

	/**
	 * Get Args
	 *
	 * Devuelve los argumentos para el metodo del controller.
	 *
	 * @access public
	 * @return array
	 */
	public function getArgs(){
		return $this->args;
	}

	/**
	 * Get Controller
	 *
	 * Devuelve el controller especificado en la peticion.
	 *
	 * @access public
	 * @return string
	 */
	public function getController(){
		return $this->controller;
	}

	/**
	 * Get Module
	 *
	 * Devuelve el module especificado en la peticion.
	 *
	 * @access public
	 * @return string
	 */
	public function getModule(){
		return $this->module;
	}
}
// END Armador Class

/* End of file Armador.php */
/* Location: ./core/mvc/Armador.php */