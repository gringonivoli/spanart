<?php

namespace SpanArt\App\Modules\Index\Views;

use SpanArt\Core\MVC\View;

class IndexView extends View{

	public function prueba(){
		#seteo un diccionario choto
		$p['{COMENTARIO}'] = "esto es un comentario por marca.. no por MARACA... JA!";
		#llamo a crear la vista estatica
		#$render = $this->renderStatic($this->getHtml('web/index'), $p);
        $render = $this->render($this->getHtml('web/index'), $p);
		#seteo un diccionario para el template
		$dict['{APP_TITLE}'] = ".: SpanArt :.";
		#muestro la pantalla
		$this->show('templates/default', $render, $dict);
	}
}