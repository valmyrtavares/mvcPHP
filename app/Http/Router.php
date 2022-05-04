<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router
{
    //url completa do projeto
    private $url = '';
    // É o que é comum a todas as rotas. Nome do projeto
    private $prefix = '';
    //Rotas que serão adicionadas no projeto que tem que reponder
    private $routes = [];
    //é uma instancia do request. Que será instanciada
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

        $patternRoute = '/^' .str_replace('/', '\/', $route). '$/';

        $this->routes[$patternRoute][$method] = $params;
    }


    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri()
    {
        //URI da request
        $uri = $this->request->getUri();
      

        //Fatia a uri com o prefixo
        $xUri = strlen($this->prefix)? explode($this->prefix, $uri):[$uri];        //Retorna a uri sem prefixo
       
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

            if (!isset($route['controller'])) {
                throw  new Exception('A url não pode ser processada', 500);
            }
            $args = [];
            return call_user_func_array($route['controller'], $args);
          
            throw new Exception("Página não encontrada", 1);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}