<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author Juan
 */
class Router
{

    private $controller;
    private $app;
    private $request;
    
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->app = $controller->getApp();
        
        // por seguridad falta filtrar $_GET, $_POST & $_SERVER
        $this->request = array(
            'get'       => $_GET, 
            'post'      => $_POST,
            'server'    => $_SERVER
        );
    }
    
    // analiza la url y llama al metodo pertinente del controlador 
    // pasandole los parametros de la url
    public function dispatch()
    {
        if (isset($this->request['server']['PATH_INFO'])) {
            $url = $this->request['server']['PATH_INFO'];
        } else {
            $url = ''; 
        }
        $strParameters = $this->request['server']['QUERY_STRING'];
        
        
        
        $convert = $this->_convert2Method($url);
        $method = $convert['method'];
        
        $parameters = $this->_parameters($strParameters);
        $parameters['_id'] = $convert['id'];
//        var_dump($method);
//        var_dump($parameters); 
        $methods = get_class_methods($this->controller);
        if (in_array($method, $methods)) {
            $this->controller->$method($parameters);
        } else {
            $this->controller->byDefault();
        }
    }
    
    // convierte la url de la ruta en nombre de metodo del controlador
    private function _convert2Method($url) {
        $urlString = '';
        $id = null;
        $bits = explode('/', $url);
        foreach ($bits as $bit) {
            if ((int)$bit===0) {
                $urlString .= ucfirst($bit);
            } else {
                $id = (int)$bit;
            }
        }
        return array(
            'method'=>lcfirst($urlString), 
            'id' => $id
        );
    }
    
    // convierte los parametros de la url en un array para pasarlo al 
    // metodo del controlador 
    private function _parameters($param) {
        $parametros = array();
        $bits = explode('&', $param);
        foreach ($bits as $bit) {
            if ($bit !== '') {
                $p = explode("=", $bit);
                if (isset($p[1])) {
                    $parametros[$p[0]] = $p[1];
                } else {
                    $parametros[$p[0]] = null;
                }
            }
        }
        return $parametros;
    }
    
}

