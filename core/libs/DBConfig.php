<?php

namespace SpanArt\Core\Libs;

use SpanArt\Core\Interfaces\ISingleton;
use SpanArt\Core\Traits\Singleton;
use SpanArt\SpanArt;

/**
 * Clase que accede a la configuracion de acceso a la db.
 *
 * No se carga por defecto. (VER SI SE PONE EN LA AUTOCARGA DE DARLE UNA INSTANCIA AL CONTROLLER)
 *
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage Libs
 */

class DBConfig implements ISingleton{
	private $db = array();

	use Singleton;

	/**
	 * Constructor
	 *
	 * @access private
	 */
	private function __construct(){
		$this->load();
	}

	/**
	 * __Clone
	 *
	 * No permite la clonación.
	 *
	 * @access public
	 */
	public function __clone(){
		//no esta permitido el clonado, aca se dispararia un error.
	}

	/**
	 * Load
	 *
	 * Carga el archivo de configuracion para el acceso a la db.
	 *
	 * @access private
	 */
	private function load(){
		#NOTA: la misma que tiene el Objeto Autoload.php
		require_once SpanArt::$CONF_PATH."db_conf.php";
		$this->db = $db;
	}

	/**
	 * Get
	 *
	 * Retorna el valor requerido de la configuracion.
	 * En el if se preguntaba igual que en la clase Config.php, pero
	 * en este caso estaba mal, ya se arreglo, COMPROBAR SI Config.php
	 * funciona de forma correcta!
	 *
	 * @access public
	 * @param string (ej. 'default')
	 * @param string (ej. 'hostname')
	 * @return string (valor de la propiedad de configuracion)
	 */
	public function get($index, $value){
		if(array_key_exists($index, $this->db) && array_key_exists($value, $this->db[$index])){
			$item = $this->db[$index][$value];
		}else{
			$item = false;
		}
		return $item;
	}
}
// END DBConfig Class

/* End of file DBConfig.php */
/* Location: ./core/libs/DBConfig.php */