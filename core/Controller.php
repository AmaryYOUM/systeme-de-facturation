<?php
/**
 * Controller
 */

class Controller{

    public $request;                // objet Request
    private $vars = array();        // Variables à passer à la vue
    public $layout = 'default';     // Layout à utiliser pour rendre la vue
    private $rendered = false;      // Si le rendu a été fait ou pas
    
    // Ajout des propriétés utilisées dynamiquement ailleurs :
    public $Facture;
    public $User;
    public $Patient;
    public $Service;
    public $Prestation;
    public $Prescripteur;
    public $Session;
    public $Form;
/**
 * Constructeur
 * @param $request objet request d'application
 */
    function __construct($request = null){
        $this->Session = new Session();
        $this->Form = new Form($this);

        if ($request) {
            $this->request = $request; //on stock la request dans l'instance
            require ROOT.DS.'config'.DS.'specify.php';
        }
    }

    /**
 * permet de rendre une vue
 * @param $view fichier à rendre (chemin depuis view ou nom de la vue)
 */

    public function render($view){
    if ($this->rendered){ return false; }
    extract($this->vars);
    
    if (strpos($view,'/') === 0) {
        $view = ROOT.DS.'view'.$view.'.php';
    } else {
        $view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
    }

    ob_start();
    require($view);
    $content_for_layout = ob_get_clean();

    if ($this->layout !== false) {
        require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
    } else {
        echo $content_for_layout;
    }

    $this->rendered = true;
}


 /**
 * permet de passer une ou plusieurs variable à la vue
 * @param $key nom de la variable ou tableau de variable
 * @param $value valeur de la variable
 */
    public function set($key,$value=null){
        if (is_array($key)){
            $this->vars += $key;
        }else {
            $this->vars[$key] = $value;
        }
    }
/**
 * permet de charger un model
 */
    function loadModel($name){
        $file = ROOT.DS.'model'.DS.$name.'.php';
        require_once($file);
            $this->$name = new $name();
            if (isset($this->Form)) {
                $this->$name->Form = $this->Form;
            }
    }

    /**
     * Permet de gérer les erreurs 404
     */
    function e404($message){
        header("HTTP/1.0 404 Not Found");
        $this->set('message',$message);
        $this->render('/errors/404');
        die();
    }

    /**
     * Permet d'appeler un controller depuis une vue
     */
    function request($controller,$action){
        $controller .= 'Controller';
       $c = new $controller();
       return $c->$action();
    }   

    /**
     * Redirect
     */
    function redirect($url,$code = null) {
        if ($code==301) {
            header("HTTP/1.1 301 Moved Permanently");
        }
        header("Location: ".Router::url($url));
    }
}
?>