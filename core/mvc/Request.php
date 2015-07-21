<?php

namespace SpanArt\Core\MVC;

use SpanArt\Core\Interfaces\ISingleton;
use SpanArt\Core\Traits\Singleton;
use SpanArt\SpanArt;

/**
 * Clase que se crea por cada peticion,y prepara la ruta y los argumentos.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

class Request implements ISingleton{
	
	private $uri;
	private $uriArray;
	private $argsArray;
	private $webPathNumber;

	use Singleton;

	/**
	 * Constructor
	 * 
	 * @access private
	 */
	private function __construct(){
		$this->uri = filter_var(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            FILTER_SANITIZE_STRING
        );
		$this->fixUri();
		$this->fixWebPath();
	}

	public function __clone(){}

	/**
	 * Fix Uri
	 * 
	 * Normaliza la peticion elimina el caracter '/' del final.
	 *
	 * @access private
	 */
	private function fixUri(){
		$this->uri = rtrim($this->uri,'/');
	}

	/**
	 * Prepare Ruta
	 * 
	 * Crea el array con los elementos utiles de la uri.
	 * En este caso seria modulo, controller, method.
	 *
	 * @access private
	 */
	private function prepareRuta(){
		$this->uriArray = array_slice(explode('/',$this->uri), $this->webPathNumber,3);
	}

	/**
	 * Prepare Args
	 * 
	 * Crea el array con los elementos considerados argumentos de la uri.
	 * En este caso se considera argumentos todo lo que este despues de method.
	 *
	 * @access private
	 */
	private function prepareArgs(){
		$nro_arguments 	 = $this->webPathNumber + 3;
		$this->argsArray = array_slice(explode('/',$this->uri), $nro_arguments);
	}

	/**
	 * Get Uri Array
	 * 
	 * Prepara y devuelve un array con los elementos utiles de la uri.
	 *
	 * @access public
	 * @return array
	 */
	public function getUriArray(){
		$this->prepareRuta();
		return $this->uriArray;
	}

	/**
	 * Get Args Array
	 * 
	 * Prepara y devuelve un array con los argumentos de la uri.
	 *
	 * @access public
	 * @return array
	 */
	public function getArgsArray(){
		$this->prepareArgs();
		return $this->argsArray;
	}

	/**
	 * Fix Web Path
	 * 
	 * Calcula desde donde empezar a contar para obtener los 
	 * elementos utiles y los argumentos de la uri.
	 *
	 * @access private
	 */
	private function fixWebPath(){
		$webPathMembers      = explode('/', SpanArt::$WEB_PATH);
		$this->webPathNumber = count($webPathMembers);
	}
}
// END Request Class

/* End of file Request.php */
/* Location: ./core/mvc/Request.php */