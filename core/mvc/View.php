<?php

namespace SpanArt\Core\MVC;

use SpanArt\Core\Traits\Uri;
use SpanArt\SpanArt;

/**
 * Clase abstracta que deberian extender las views de la aplicacion.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 * @subpackage MVC
 */

abstract class View{
	
	protected $info = array();
    public static $CONTENT_TAG;

	use Uri;

	/**
	 * Constructor
	 *
	 * Los parametros son pasados de forma automatica por el 
	 * Controller del core. Y pueden ser usados para obtener
	 * la ubicacion actual, ej. example -> vidrio -> ver
	 *
	 * @param string 
	 * @param string
	 * @param string  
	 */
	public function __construct($module = '', $model = '', $method = ''){
		$this->info['module']   = $module;
		$this->info['model']    = $model;
		$this->info['method']   = $method;
	}

	/**
	 * Show
	 *
	 * Este método maneja 1, 2, 3, 4 y 5 argumentos, y dependiendo del número, 
	 * llama al método adecuado de la forma adecuada.
	 *
	 * @access protected
	 */
	protected function show(){
		$nroArgs = func_num_args();
		switch($nroArgs){
			case 4:
				$this->showInTemplate(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3));
				break;
			case 3:
				$this->showInTemplate(func_get_arg(0), func_get_arg(1), func_get_arg(2));
				break;			
			case 2:
				$this->showInTemplate(func_get_arg(0), func_get_arg(1));
				break;			
			case 1:
				$this->showRender(func_get_arg(0));
				break;
		}
	}

    /**
     * Show In Template
     *
     * Imprime por pantalla un render dentro de un template, la marca de contenido
     * para el template es {CONTENIDO}.
     *
     * @access private
     * @param $template
     * @param $render
     * @param array $dict
     * @param bool $addNavPath
     * @internal param bool $setDict
     */
	private function showInTemplate($template, $render, $dict = array(), $addNavPath = true){
		$this->buildTemplatePath($template);

		if($addNavPath){
			$this->addNavPath($dict);
		}

        $dict = array(self::$CONTENT_TAG => $render) + $dict;

		$template = $this->getTemplate($template);
		print str_replace(array_keys($dict), array_values($dict), $template);
	}

	/**
	 * Show Render
	 *
	 * Imprime por pantalla un render.
	 *
	 * @access private
	 * @param string
	 */
	private function showRender($render){
		print $render;
	}

    /**
     * Render Static
     *
     * Sustituye un diccionario en un render con marcas de
     * sustitucion estaticas.
     *
     * @deprecated
     * @access protected
     * @param string
     * @param array $dict
     * @param bool $addNavPath
     * @return string
     */
	protected function renderStatic($render, $dict = array(), $addNavPath = true){
		$this->render($render, $dict, $addNavPath);
	}

    /**
     * Render
     *
     * Sustituye un diccionario en un render con marcas de
     * sustitucion.
     *
     * @param $render
     * @param array $dict
     * @param bool $addNavPath
     * @return mixed
     */
    public function render($render, $dict = array(), $addNavPath = true){
        settype($dict, 'array');

        if($addNavPath){
            $this->addNavPath($dict);
        }

        return str_replace(array_keys($dict), array_values($dict), $render);
    }

	/**
	 * Add Nav Path
	 *
	 * Agrega al diccionario de reemplazo el path para la navegacion,
	 * esto sirve para no tener ningun problema a la hora de cambiar la 
	 * app a distintos niveles de directorios.
	 *
	 * @access protected
	 * @param array (por referencia)
	 */
	protected function addNavPath(&$dict){
		$dict['{wNAV}'] = $this->baseUri();
	}

	/**
	 * Get Html
	 *
	 * Devuelve el fichero html indicado, tener en cuenta que 
	 * se debe respetar la estructura de directorios de static/.
	 * Pero dentro del directorio html se pueden crear sub directorios.
	 * ej. del caso $this->getHtml("web/index");
	 *
	 * @access protected
	 * @param string
	 * @return string (el contenido del fichero html convertido en string)
	 */
    public function getHtml($html){
    	$html = $this->buildHtmlPath($html);
    	return (file_exists($html)) ? file_get_contents($html) : false;
    }

    /**
     * Get Template
     *
     * Devuelve el template requerido para usarlo en 
     * Show In Template. 
     * En si se llama al método getHtml pero se conservo 
     * este nombre para mantener consistencia.
     *
     * @access protected
     * @param string
     * @return string (el contenido del fichero template convertido en string)
     */
    protected function getTemplate($template){
    	return $this->getHtml($template);
    }

    /**
     * Build Template Path
     *
     * Devuelve la ruta del template pasado, no verifica que exista.
     * En si se llama al método buildHtmlPath pero se conservo el 
     * nombre para mantaner la consistencia.
     *
     * @access protected
     * @param string
     * @return string
     */
    protected function buildTemplatePath($template){
    	return $this->buildHtmlPath($template);
    }

    /**
     * Build Html Path
     *
     * Devuelve la ruta del html pasado, no verifica que exista.
     *
     * @access protected
     * @param string
     * @return string
     */
    protected function buildHtmlPath($html){
    	return SpanArt::$STATIC_PATH."html/{$html}.html";
    }
}
// END View Class

/* End of file View.php */
/* Location: ./core/mvc/View.php */