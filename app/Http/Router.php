<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router
{
    private $url = '';

    private $prefix = '';

    private $routes = [];

    private $request = [];

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute($method, $route, $params = [])
    {
        foreach ($params as $key=>$value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $patternRoute = '/' .str_replace('/', '\/', $route). '$';

        $this->routes[$patternRoute][$method] = $params;
    }


    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    private function getUri()
    {
        //URI da request
        $uri = $this->request->getUri();

        //Fatia a uri com o prefixo
        $xUri = strlen($this->prefix)? explode($this->prefix, $uri):[$uri];
        //Retorna a uri sem prefixo
        return end($xUri);
    }

    private function getRoute()
    {
        $uri = $this->getUri();
       
        $httpMethod = $this->request->getHttpMethod();
       
        foreach ($this->routes as $patternRoute=>$methods) {
            //VERIFICA SE A ROTA BATE COM O PADRÃO
            if (preg_match($patternRoute, $uri)) {
                //VERIFICA O METODO
                if ($methods[$httpMethod]) {
                    //Retorno dos parametros das rotas
                    return $methods[$httpMethod];
                }
                throw new Exception('Metodo não permitido', 405);
            }
        }
        throw new Exception('Url não encontrada', 404);
    }

    public function run()
    {
        try {

            //Obtem a rota atual
            $route = $this->getRoute();

            echo "<pre>";
            print_r($route);
            //   throw new Exception("Página não encontrada", 1);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}