<?php

namespace SpanArt\Core\Libs;

use SpanArt\Core\Interfaces\ISingleton;
use SpanArt\Core\Traits\Singleton;
use SpanArt\SpanArt;

/**
 * Clase que accede a los archivos de configuracion y a sus propiedades.
 * HACERLE UN METODO SET!
 * COMPROBAR EL FUNCIONAMIENTO DE LAS SECCIONES YA QUE SE ENCONTRO UN ERROR EN LA CLASE 
 * DBConf.php Y EL METODO GET AHI ES MUY PARECIDO.
 *
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage Libs
 */

class Config implements ISingleton{
	
	private $config = array();
	private $file = array();

	use Singleton;

	/**
	 * Constructor
	 * 
	 * @access private
	 */ 
	private function __construct(){}

	/**
	 * Load
	 *
	 * Carga ficheros de configuracion creados por los usuarios 
	 * cuya caracteristica es que los valores de configuracion 
	 * deben estar contenidos en un diccionario clave => valor
	 *
	 * @access public
	 * @param string
	 * @param boolean
	 */
	public function load($file = '', $useSections = false){
		$file = SpanArt::$CONF_PATH."{$file}.php";
		if((!$this->isLoad($file)) && file_exists($file)){
			require($file);
			//$this->file = $file;
			array_push($this->file, $file);
			if($useSections){
				$this->config[$file] = array_merge($this->config[$file], $config);
			}else{
				$this->config = array_merge($this->config, $config);
			}
		}else{
			//ver de disparar un error o tirar u log..
		}
	}

	/**
	 * Is Load
	 *
	 * Verifica si el fichero de
	 * configuracion ya fue cargado.
	 *
	 * @param $file
	 * @return bool
	 */
	private function isLoad($file){
		return in_array($file, $this->file, true);
	}

	/**
	 * Item
	 *
	 * Retorna el valor de el item pasado como argumento 
	 * y acepta opcionalemnte un segundo parametro que es 
	 * para especificar la seccion, si cuando se cargo el 
	 * fichero de configuracion con Load se especifico el 
	 * uso de secciones con el valor true como segundo 
	 * argumento.
	 *
	 * @access public
	 * @param string
	 * @param string
	 * @return string/boolean (el valor del item o false si el item no existe)
	 */
	public function item($item = '', $index = ''){
		$value = false;
		if($index == ''){
			if(isset($this->config[$item])){
				$value = $this->config[$item];
			}
		}else{
			if(array_key_exists($index, $this->config) && in_array($item, $this->config)){
				$value = $this->config[$index][$item];
			}
		}
		return $value;
	}
}
// END Config Class

/* End of file Config.php */
/* Location: ./core/libs/Config.php */