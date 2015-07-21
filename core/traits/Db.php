<?php

namespace SpanArt\Core\Traits;

use PDO;
use SpanArt\Core\Libs\DBConfig;

/**
 * Db
 *
 * Facilita la creación de objetos PDO usando los perfiles
 * definidos en db_conf.php.
 *
 */

trait Db{

    /**
     * Get PDO
     *
     * Crea y retorna un objeto PDO creado con los datos del perfil especificado
     * haciendo referencia a los perfiles definidos en el fichero de configuración
     * db_conf.php.
     *
     * @param string $profile
     * @return PDO
     */
    public function getPDO($profile = "default"){
        $dbConfig = DBConfig::getInstancia();
        return new PDO($dbConfig->get($profile, 'database').
            ":host=".$dbConfig->get($profile, 'hostname').
            ";dbname=".$dbConfig->get($profile,'dbname')
            ,$dbConfig->get($profile,'username')
            ,$dbConfig->get($profile,'password')
            ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
    }
}