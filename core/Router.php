<?php
class Router{

    static $routes = array();
    static $prefixes = array();

    static function prefix($url,$prefix) {
        self::$prefixes[$url] = $prefix;
    }

/**
 * Permet de parser une url
 * @param $url à parser
 * @return tableau contenant les paramètres
 */
    static function parse($url,$request){
        $url = trim($url, '/');
        $url = urldecode($url);

        if (empty($url)) {
            $url = Router::$routes[0]['url'];
        }else {
            foreach (Router::$routes as $v) {
                if(preg_match($v['catcher'],$url,$match)) {
                        $request->controller = $v['controller'];
                        $request->action = isset($match['action']) ? $match['action'] : $v['action'];
                        $request->params = array();
                    foreach($v['params'] as $k=>$v) {
                        $request->params[$k] = $match[$k];
                    }
                    if (!empty($match['args'])) {
                        $request->params += explode('/',trim($match['args'],'/'));
                    }
                    return $request;
                }
            }
            }

        $params = explode('/',$url);
        if (in_array($params[0],array_keys(self::$prefixes))) {
            $request->prefix = self::$prefixes[$params[0]];
            array_shift($params);
        }

        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : 'index';
        foreach (self::$prefixes as $k => $v) {
            if (strpos($request->action,$v.'_')===0) {
                $request->prefix = $v;
                $request->action = str_replace($v.'_','',$request->action);
            }
        }
        $request->params = array_slice($params,2);
        return true;
        }

/**
 * connect
 */
    static function connect($redir,$url) {
        $r = array();

        $r['params'] = array();
        $r['url'] = $url;
        $r['redir'] = $redir;
        
        $r['origin'] = str_replace(':action','(?P<action>([a-z0-9]+))',$url); 

        $r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/','${1}:(?P<${1}>${2})',$r['origin']);
        $r['origin'] ='/^'.str_replace('/', '\/',$r['origin']).'(?P<args>:\/?.*)$/';

        $params = explode('/', $url);
        foreach ($params as $k => $v) {
            if (strpos($v,':')) {
                $p = explode(':',$v);
                $r['params'][$p[0]] = $p[1];
            }else {
                if ($k==0) {
                    $r['controller'] = $v;
                }elseif ($k==1) {
                    $r['action'] = $v;
                }
            }
        }

        $r['catcher'] = $redir;
        $r['catcher'] = str_replace(':action','(?P<action>([a-z0-9]+))',$r['catcher']); 

        foreach ($r['params'] as $k=>$v) {
            $r['catcher'] = str_replace(":$k","(?P<$k>$v)",$r['catcher']);
        }
        $r['catcher'] ='/^'.str_replace('/', '\/',$r['catcher']).'(?P<args>:\/?.*)$/';
      
        self::$routes[] = $r;
    }
/**
 * routage url
 */
    static function url($url) {
    foreach (self::$routes as $v) {
        if (preg_match($v['origin'], $url, $match)) {
            foreach ($match as $k => $w) {
                if (!is_numeric($k)) {
                    $v['redir'] = str_replace(":$k", $w, $v['redir']);
                }
            }
            $finalUrl = rtrim(BASE_URL, '/') . '/' . ltrim($v['redir'], '/') . ltrim($match['args'], '/');
            return preg_replace('#/+#','/',$finalUrl); // Nettoyage double slash
        }
    }

    foreach (self::$prefixes as $k => $v) {
        if (strpos($url, $v) === 0) {
            $url = str_replace($v, $k, $url);
        }
    }

    $finalUrl = rtrim(BASE_URL, '/') . '/' . ltrim($url, '/');
    return preg_replace('#/+#','/',$finalUrl);
}

}