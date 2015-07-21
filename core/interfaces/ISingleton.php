<?php

namespace SpanArt\Core\Interfaces;

/**
 * Interfaz que deberían implementar los objetos para utilizar el patrón Singleton.
 * Se puede usar en conjunto con el Trait Singleton.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package Interfaces
 */

interface ISingleton{
	public static function getInstancia();
}
// END ISingleton Interface

/* End of file ISingleton.php */
/* Location: ./core/interfaces/ISingleton.php */