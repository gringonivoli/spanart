<?php

namespace SpanArt\Core\Traits;

use SpanArt\SpanArt;

/**
 * 
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package Traits
 */

trait Uri{

	/**
 	* Base Uri
 	* 
 	* Genera la uri base de la app (parace una pavada pero no).
 	*	
 	* @access public
 	* @return string
 	*/	
	public function baseUri(){
		return "/".SpanArt::$WEB_PATH;
	}
}
// END Uri Trait

/* End of file Uri.php */
/* Location: ./core/traits/Uri.php */