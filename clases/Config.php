<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author Juan
 */
class Config {
    
    var $parameters = array();
    
    public function __construct() {
        include ('parameters.php');
        $this->parameters =$parameters;
    }
    
    public function getParameter($parameter) {
        if (key_exists($parameter, $this->parameters)) {
            return $this->parameters[$parameter];
        } else {
            return false;
        }
    }
    
    public function addParameter($key, $value) {
        $this->parameters[$key] = $value;
        return $this;
    }
    
    public function exist($key) {
        return key_exists($parameter, $this->parameters);
    }

}
