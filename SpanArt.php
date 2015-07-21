<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/03/15
 * Time: 07:33
 */

namespace SpanArt;

use SpanArt\Core\MVC\FrontController;
use SpanArt\Core\MVC\View;

class SpanArt {

    private static $VERSION = "v2.4.3-alpha";

    public static
        $SPANART_PATH,
        $CORE_PATH,
        $APP_PATH,
        $STATIC_PATH,
        $CONF_PATH,
        $WEB_PATH,
        $THIRD_PARTY_PATH,
        $SPANART_ENV,
        $INIT_MODULE,
        $INIT_CONTROLLER,
        $INIT_METHOD,
        $NF_MODULE,
        $NF_CONTROLLER,
        $NF_METHOD,
        $AUTOVIEW,
        $PROJECT_NAMESPACE,
        $NAMESPACES,
        $URL_STYLE,
        $CONTENT_TAG;

    /**
     * Constructor
     */
    public function __construct(){
        $this->setDefaultValues();
        $this->setSpanArtPath();
        $this->setWebPath();
        $this->setEnv();
        $this->setContentTag();
        $this->registerSpanArtAutoload();
    }

    /**
     * Run
     *
     * Ejecuta SpanArt.
     *
     */
    public function run(){
        $this->requireSpanArtFiles();
        $this->setViewContentTag();
        FrontController::start();
    }

    /**
     * Set Content Tag
     *
     * Define el nombre de la etiqueta para que la vista reemplaze
     * en el template el contenido principal.
     *
     * @param string $contentTag
     */
    public function setContentTag($contentTag = "CONTENIDO"){
        self::$CONTENT_TAG = "{".$contentTag."}";
    }

    /**
     * Set View Content Tag
     *
     * Define el nombre de la etiqueta para que la vista reemplaze
     * en el template el contenido principal, es un metodo separado de
     * Set Content Tag por el tema de la importacion de clases y sus
     * conflictos con las funciones de autoload.
     *
     */
    private function setViewContentTag(){
        View::$CONTENT_TAG = self::$CONTENT_TAG;
    }

    /**
     * Set Writing Style
     *
     * Setea el estilo de escritura utilizado para las rutas,
     * de este modo luego se puede convertir a camelCase de una
     * manera mas sencilla y obliga a usar buenas prácticas.
     *
     * @param string $writingStyle
     */
    public function setUrlStyle($writingStyle = 'snake_case'){
        switch($writingStyle){
            case 'spinal-case':
                self::$URL_STYLE = '-';
                break;
            case 'camelCase':
                self::$URL_STYLE = '';
                break;
            default: # por default snake_case
                self::$URL_STYLE = '_';
        }
    }

    /**
     * Set Default Values
     *
     * Inicializa los valores por defecto para arrancar SpanArt,
     * se ejecuta cuando se crea una nueva instancia de SpanArt.
     *
     */
    public function setDefaultValues(){
        self::$CORE_PATH = "core/";
        self::$APP_PATH = "app/";
        self::$STATIC_PATH = "static/";
        self::$CONF_PATH = "conf/";
        self::$SPANART_ENV = "development";
        self::$INIT_MODULE = "index";
        self::$INIT_CONTROLLER = "Index";
        self::$INIT_METHOD = "index";
        self::$NF_MODULE = "index";
        self::$NF_CONTROLLER = "Index";
        self::$NF_METHOD = "index";
        self::$AUTOVIEW = true;
        self::$PROJECT_NAMESPACE = "SpanArt\\";
        self::$NAMESPACES = array();
        self::$URL_STYLE = "_";
        self::$THIRD_PARTY_PATH = "";
    }

    /**
     * Set Project Namespace
     *
     * Setea el namespace a utilizar por el projecto,
     * si no se define nada el mismo es SpanArt, por lo que
     * los namespace de los controllers, y views se tienen que
     * declarar usando SpanArt como root namespace
     * (SpanArt\App\Module\Controller), si se define uno propio,
     * ejemplo MiProyecto el namespace debe ser
     * (MiProyecto\App\Module\Controller).
     *
     * @param string $projectNamespace
     */
    public function setProjectNamespace($projectNamespace = "SpanArt\\"){
        self::$PROJECT_NAMESPACE = $projectNamespace;
    }

    /**
     * Set Static Path
     *
     * Setea el path en donde se encuentra el contenido estatico,
     * imgagenes, html, css, js, etc..
     *
     * @param string $staticPath
     */
    public function setStaticPath($staticPath = "static/"){
        self::$STATIC_PATH = $staticPath;
    }

    /**
     * Set Core Path
     *
     * Setea el path en donde se encuentra el core de SpanArt.
     *
     * @param string $corePath
     */
    public function setCorePath($corePath = "core/"){
        self::$CORE_PATH = $corePath;
    }

    /**
     * Set App Path
     *
     * Setea el path en donde se encuentra la app,
     * modulos, controllers, etc..
     *
     * @param string $appPath
     */
    public function setAppPath($appPath = "app/"){
        self::$APP_PATH = $appPath;
    }

    /**
     * Set Conf Path
     *
     * Setea el path en donde se encuentra los ficheros de configuracion
     * de la app.
     *
     * @param string $confPath
     */
    public function setConfPath($confPath = "conf/"){
        self::$CONF_PATH = $confPath;
    }

    /**
     * Set Span Art Path
     *
     * Setea el path en donde se encuentra SpanArt.
     * Si no se sabe bien que poner dejar vacio,
     * SpanArt intentara, y posiblemente lo logre,
     * averiguar la configuracion necesaria.
     *
     * @param string $spanArtPath
     */
    public function setSpanArtPath($spanArtPath = ""){
        if($spanArtPath == ""){
            $spanArtPath = dirname(__FILE__)."/";
        }
        self::$SPANART_PATH = $spanArtPath;
        ini_set('include_path', self::$SPANART_PATH);
    }

    /**
     * Set Web Path
     *
     * Setea el path donde se encuentra SpanArt desde el dominio.
     * Si SpanArt esta en el directorio raiz del dominio dejar vacio.
     * Si no se sabe bien que poner tambien dejar vacio,
     * SpanArt intentara, y posiblemente logre,
     * averiguar la configuracion necesaria.
     *
     * @param string $webPath
     */
    public function setWebPath($webPath = ""){
        if($webPath == ""){
            $pathScript = $_SERVER['SCRIPT_NAME'];
            $fileScriptName = ltrim(substr($pathScript, strrpos($pathScript, '/')), '/');
            $webPath = str_replace($fileScriptName, '', $pathScript);
            $webPath = ltrim($webPath, '/');
        }
        self::$WEB_PATH = $webPath;
    }

    /**
     * Set Third Party Path
     *
     * Setea en donde se guardan las librerias de terceros,
     * de esta manera el framework puede realizar la carga
     * automatica de las clases siguiendo los namespaces definidos
     * en estas de acuerdo, mas o menos a PSR 4.
     *
     * @param string $thirdPartyPath
     */
    public function setThirdPartyPath($thirdPartyPath = ""){
        self::$THIRD_PARTY_PATH = $thirdPartyPath;
    }

    /**
     * Set Env
     *
     * Setea el entorno sobre el cual corre la app.
     *
     * @param string $env
     */
    public function setEnv($env = "development"){
        self::$SPANART_ENV = $env;
        switch (self::$SPANART_ENV) {
            case 'development':
                ini_set('error_reporting', E_ALL | E_STRICT | E_NOTICE);
                ini_set('display_errors', 'On');
                ini_set('track_errors', 'On');
                break;
            case 'production':
                ini_set('display_errors', 'Off');
                break;
        }
    }

    /**
     * Set Init
     *
     * Setea quien y que method tiene que ejecutar al
     * ingresar a la app, web page.
     *
     * @param string $module
     * @param string $controller
     * @param string $method
     */
    public function setInit($module = "index", $controller = "Index", $method = "index"){
        self::$INIT_MODULE = $module;
        self::$INIT_CONTROLLER = $controller;
        self::$INIT_METHOD = $method;
    }

    /**
     * Set Not Found
     *
     * Setea quien se encargara de las peticiones no validas.
     *
     * @param string $module
     * @param string $controller
     * @param string $method
     */
    public function setNotFound($module = "index", $controller = "Index", $method = "index"){
        self::$NF_MODULE = $module;
        self::$NF_CONTROLLER = $controller;
        self::$NF_METHOD = $method;
    }

    /**
     * Enable Auto View
     *
     * @param bool $enable
     */
    public function enableAutoView($enable = true){
        self::$AUTOVIEW = $enable;
    }

    /**
     * Register SpanArt Autoload
     *
     * Registra el autoload para las clases
     * del Framework.
     *
     */
    private function registerSpanArtAutoload(){
        spl_autoload_register(function($class){
            self::$NAMESPACES[] = 'SpanArt\\';
            self::$NAMESPACES[] = self::$PROJECT_NAMESPACE;

            $baseDir = self::$SPANART_PATH;

            $len = 0;
            $encontrado = false;

            foreach(self::$NAMESPACES as $p){
                $len = strlen($p);
                if(strncmp($p, $class, $len) === 0) {
                    $encontrado = true;
                    break;
                }
            }

            if(!$encontrado){
                $file = self::$APP_PATH.self::$THIRD_PARTY_PATH.str_replace('\\', '/', $class).'.php';
                if(file_exists($file)){
                    require	$file;
                }
            return;}

            //	get	the	relative	class	name
            $relativeClass = substr($class, $len);

            # Esta parte hay que armmarla mejor para soportar directorios camelcase
            $directorios = strtolower(substr($relativeClass, 0, strrpos($relativeClass, '\\')));
            $clase = substr($relativeClass, strrpos($relativeClass, '\\'));
            $relativeClass = $directorios.$clase;

            $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

            if(file_exists($file)){
                require	$file;
            }
        });
    }

    /**
     * Add Project Namespace
     *
     * @param string $namespace
     */
    public function addProjectNamespace($namespace = ""){
        if($namespace != ""){
            self::$NAMESPACES[] = $namespace;
        }
    }

    /**
     * Require SpanArt Files
     *
     * Importa todos los ficheros necesarios para
     * correr el framework.
     *
     */
    private function requireSpanArtFiles(){
        require self::$CORE_PATH."interfaces/ISingleton.php";
        require self::$CORE_PATH."traits/Singleton.php";
        require self::$CORE_PATH."traits/MVCNames.php";
        require self::$CORE_PATH."traits/U.php";
        require self::$CORE_PATH."traits/Uri.php";
        require self::$CORE_PATH."libs/NamespaceManager.php";
        require self::$CORE_PATH."mvc/FrontController.php";
        require self::$CORE_PATH."mvc/Controller.php";
        require self::$CORE_PATH."mvc/View.php";
        require self::$CORE_PATH."mvc/Request.php";
        require self::$CORE_PATH."mvc/Armador.php";
        require self::$CORE_PATH."mvc/Dispatcher.php";
    }

    /**
     * Load
     *
     * Para cargar algunos ficheros por defecto, y desde donde sea
     * ya que cierta flexibilidad se pierde si se usa la funcion
     * de autoload registrada para este proposito.
     *
     * @param $files
     */
    public static function load($files){
        if(is_array($files)){
            foreach($files as $file){
                require "{$file}.php";
            }
        }else{
            require "{$files}.php";
        }
    }

    /**
     * Span Art Info
     *
     * Imprime por pantalla la configuración de
     * SpanArt.
     *
     */
    public function spanArtInfo(){
        echo "SpanArt ".SpanArt::$VERSION."<br>";
        echo "Environment: ".SpanArt::$SPANART_ENV."<br>";
        echo "SpanArt Path: ".SpanArt::$SPANART_PATH."<br>";
        echo "Web Path: ".SpanArt::$WEB_PATH."<br>";
        echo "Static Path: ".SpanArt::$STATIC_PATH."<br>";
        echo "Core Path: ".SpanArt::$CORE_PATH."<br>";
        echo "App Path: ".SpanArt::$APP_PATH."<br>";
        echo "Conf Path: ".SpanArt::$CONF_PATH."<br>";
        echo "Third Party Path: ".SpanArt::$THIRD_PARTY_PATH."<br>";
        $autoview = SpanArt::$AUTOVIEW ? "true" : "false";
        echo "Enable Autoview: ".$autoview."<br>";
        echo "Init Module: ".SpanArt::$INIT_MODULE."<br>";
        echo "Init Controller: ".SpanArt::$INIT_CONTROLLER."<br>";
        echo "Init Method: ".SpanArt::$INIT_METHOD."<br>";
        echo "Not Found Module: ".SpanArt::$NF_MODULE."<br>";
        echo "Not Found Controller: ".SpanArt::$NF_CONTROLLER."<br>";
        echo "Not Found Method: ".SpanArt::$NF_METHOD."<br>";
        echo "Project Namespace: ".SpanArt::$PROJECT_NAMESPACE."<br>";
        echo "Namespaces: ";
        foreach (SpanArt::$NAMESPACES as $namespace) {
            echo " {$namespace} ";
        }
    }
}