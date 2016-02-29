<?php
include ('clases/Config.php');
include ('clases/Controlador.php');
include ('clases/Router.php');

new app();

class app
{

    private $controlador;
    private $router;
    private $config;

    public function __construct()
    {
        $this->config = new Config();
        $this->controlador = new Controller($this, $this->config);
        $this->router = new Router($this->controlador);
        $this->router->dispatch();
    }
}

