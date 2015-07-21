<?php

namespace SpanArt\Core\Traits;

/**
 * Trait para la implementación del patrón Singleton de forma genérica.
 * Se debe cambiar la visibilidad del constructor de la clase que lo use 
 * a privada y definir el método mágico __clone para que no se puedan 
 * crear nuevos objetos del mismo tipo a traves de la clonación.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package Traits
 */

trait Singleton{

	/**
	 * Instancia
	 * 
	 * En esta variable es en donde se almacena el objeto creado.
	 * @access private
	 */
	private static $instancia;

	/**
	 * Get Instancia
	 * 
	 * Comprueba si ya existe una instacia de la clase DBConfig, si es asi, 
	 * esta se devuelve, si no existe ninguna instancia se crea y se 
	 * devuelve.
	 * 
	 * @access public
	 * @return Object Objeto del tipo de la clase que usa el trait.
	 */ 
	public static function getInstancia(){
		if(!isset(self::$instancia)){
			$clase = __CLASS__;
			self::$instancia = new $clase;
		}
		return self::$instancia;
	}
}
// END Singleton Trait

/* End of file Singleton.php */
/* Location: ./core/traits/Singleton.php */