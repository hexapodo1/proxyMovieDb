<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Juan
 */

class Controller
{

    private $app;
    private $config;

    public function __construct(app $app, Config $config)
    {
        $this->app = $app;
        $this->config = $config;
    }
    
    /**
     * 
     * @return index
     */
    public function getApp()
    {
        return $this->app;
    }

    public function configuration($parameters = array()) {
        $result = $this->_request('configuration');
        $this->_toBrowser($result);    
    }
    
    public function searchPerson($parameters = array()) {
        $result = $this->_request('search/person', $parameters);
        $this->_toBrowser($result);    
    }
    
    public function detailPerson($parameters = array()) {
        $result = $this->_request('person/' . $parameters['_id'], $parameters);
        $this->_toBrowser($result);    
    }
    
    public function movieCreditsPerson($parameters = array()) {
        $result = $this->_request('person/' . $parameters['_id'] . "/movie_credits", $parameters);
        $this->_toBrowser($result);    
    }
    
    public function detailMovie($parameters = array()) {
        $result = $this->_request('movie/' . $parameters['_id'], $parameters);
        $this->_toBrowser($result);    
    }
    
    public function imagesMovie($parameters = array()) {
        $result = $this->_request('movie/' . $parameters['_id'] . '/images', $parameters);
        $this->_toBrowser($result);    
    }
    
    public function creditsMovie($parameters = array()) {
        $result = $this->_request('movie/' . $parameters['_id'] . '/credits', $parameters);
        $this->_toBrowser($result);    
    }
    
    public function byDefault() {
        echo "view by default";
        
    }
    
    private function _toBrowser($str) {
        header('Content-type: application/json');
        echo $str;
    }
    
    private function _request($service, $parameters = array()) {
        $strParameters = '';
        foreach ($parameters as $k => $parameter) {
            $strParameters .= "&" . $k . "=" . $parameter;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->config->getParameter('baseUrl') 
                . $service . "?api_key=" . $this->config->getParameter('apiKey') 
                . $strParameters
            );
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

