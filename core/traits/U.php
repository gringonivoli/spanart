<?php

namespace SpanArt\Core\Traits;
use SpanArt\SpanArt;

/**
 *
 *
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package Traits
 */

trait U{

    /**
     * Whatever to Camel Case
     *
     * Convierte un string snake_case, spinal-case, o
     * whatever-case a camelCase, toma como referencia
     * el separador de palabras que se define en el objeto
     * SpanArt, antes de la ejecución, da la posibilidad de
     * convertir el primer caracter de la cadena a mayus.
     *
     * @param $string
     * @param bool $firstCharCaps
     * @return mixed
     */
    public function whateverToCamelcase($string, $firstCharCaps = false){
        if($firstCharCaps){
            $string[0] = strtoupper($string[0]);
        }
        return preg_replace_callback(
            '/'.SpanArt::$URL_STYLE.'([a-z])/',
            function($c){
                return strtoupper($c[1]);
            },
            $string
        );
    }
}
// END U Trait

/* End of file U.php */
/* Location: ./core/traits/U.php */