<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/03/15
 * Time: 13:41
 */

namespace SpanArt\Core\Libs;

use SpanArt\SpanArt;

class NamespaceManager{

    public static
        $CONTROLLER = "Controllers",
        $VIEW = "Views";

    /**
     * Get Namespace
     *
     * Devuelve de forma dinamica el namespace a
     * utilizar, para esto se deben declarar los
     * namespaces en base a la siguiente regla:
     * El namespace se debe definir copiando la
     * estructura de directorios de la siguiente
     * manera:
     *  \SpanArt o el namespace del proyecto definido
     *   por el objeto SpanArt\-Nombre del directorio de la app
     *   con la primera en mayuscula-\Modules\-Nombre
     *   del Modulo con la primera en mayuscula-\
     *   -Controllers/Views (segun corresponda)-
     * 
     * @param $module
     * @param $type
     * @return string
     */
    public static function getNamespace($module, $type){
        return "\\".SpanArt::$PROJECT_NAMESPACE.(ucfirst(rtrim(SpanArt::$APP_PATH, "/"))."\\Modules\\".$module."\\".$type."\\");
    }
}