<?php
// Request support
class Request{
    
    public $url; // URL appellé par l'utilisateur
    public $page = 1; 
    public $prefix = false;
    public $data = false;
    
    // Ajout des propriétés utilisées dynamiquement ailleurs :
    public $controller;
    public $action;
    public $params = [];
    
    function __construct(){
        $this->url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        if ($this->url === '/' && isset($_SERVER['REQUEST_URI'])) {
            $base = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $this->url = '/' . trim(str_replace($base, '', $uri), '/');
        }

        if (isset($_GET['page'])) {
            if (is_numeric($_GET['page'])) {
                if ($_GET['page']>0) {
                    $this->page = round($_GET['page']);
                }
            }
        }
        if (!empty($_POST)) {
            $this->data = new stdClass();
            foreach($_POST as $k=>$v) {
                $this->data->$k=$v;
            }
        }
    }
}