<?php

namespace SpanArt\App\Modules\Index\Controllers;

use SpanArt\Core\MVC\Controller;

/**
 * Clase Controlador de Inicio (index por defecto); ejemplifica la forma basica de crear tus 
 * controladores.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 */

class IndexController extends Controller{
	/* Esto se puede poner o no, ya que si no se define 
	un constructor usara el del padre en su propio ambito 
	y todas las llamadas se ejecutaran en el objeto.
	pero si se define, esta es la forma, se toman los parametros, 
	los pasa al constructor del padre y despues ejecuta sus 
	metodos en su constructor
	
	public function __construct($method = '', $args=array(), $controller = '', $module = ''){
		parent::__construct($method, $args, $controller, $module);
	}
	*/
	public function index(){
		#echo "<a href='/woper-mvc02/example/vidrio'>Que onda?</a>";
        #var_dump($this->view);
		$this->view->prueba();
	}
}

/* End of file Index.php */
/* Location: ./index/Index.php */