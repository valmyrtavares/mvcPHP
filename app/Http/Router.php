<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction; 

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
        //Pega a url que é http://localhost/mvcPHP
        $parseUrl = parse_url($this->url);
        //E transforma em 
            // Array
            // (
            //     [scheme] => http
            //     [host] => localhost
            //     [path] => /mvcPHP
            // ) através do parse_url       

        $this->prefix = $parseUrl['path'] ?? '';
        //E transforma em /mvcPHP pois ele é o path
      
    }

    private function addRoute($method, $route, $params = [])
    {
        // echo '<pre>';
        // print_r($method);
        // echo '<br>';
        // print_r($route);
        // echo '<br>';
        // print_r($params);
        // echo '<br>';
        // exit;
       
        foreach ($params as $key=>$value) {           
            
       
            if ($value instanceof Closure) {
                $params['controller'] = $value;             
                unset($params[$key]);
                continue;
            }
        }
        //Esse foreach subtitui a key númerica por um controller      
        

        //VARIAVEIS DA ROTA
        $params['variables'] = [];

        //PADRÃO DE VALIDAÇÃO DAS VARIAVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';
       
        if (preg_match_all($patternVariable, $route, $matches)) {
            // echo '<pre>';
            // print_r($patternVariable);
            // echo '<br>';
            // print_r($route);
            // echo '<br>';
            // print_r($matches);
            // echo 'FIM DA PRIMEIRA PARTE';
            // echo '<br>';
           $route = preg_replace($patternVariable, '(.*?)', $route);
        //    echo '<pre>';
        //    print_r($patternVariable);
        //    echo '<br>';
        //    print_r($route);       
        //    echo '<br>';  
           
           $params['variables'] = $matches[1];
        //    echo 'FIM DA SEGUNDA PARTE';
        //    echo '<br>';
        //    print_r( $params['variables']);          
        //    echo '<br>';
        //    exit;
        }

        $patternRoute = '/^' .str_replace('/', '\/', $route). '$/';    
        
        // echo 'FIM DA TERCEIRA PARTE';
        // echo '<br>';
        // print_r($patternRoute); 
                  
     
            

        $this->routes[$patternRoute][$method] = $params;

        // echo 'FIM DA QUARTA PARTE';
        // echo '<br>';
        // print_r($this->routes[$patternRoute][$method]); 
        //      exit; 
       
        
    }


    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
        // echo  'Até aqui';
        // print_r($this->addRoute('GET', $route, $params)); 
        // exit; 
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
        //retorna /mvcPHP/   

        
        //print_r($uri);  /mvcPHP
        
        //print_r($this->prefix); /mvcPHP/
        
        
        //Fatia a uri com o prefixo
        $xUri = strlen($this->prefix)? explode($this->prefix, $uri):[$uri];        //Retorna a uri sem prefixo
        
        // print_r($xUri); Array
        // (
        //     [0] => 
        //     [1] => /
        // )        
        
        return end($xUri);
        //print_r(end($xUri));  return  /  ou /sobre
    }

    private function getRoute()
    { 
        $uri = $this->getUri();
        //retonrna  o que vem na rota pode ser /   ou /about
          
     
       
        $httpMethod = $this->request->getHttpMethod();       
        //print_r($httpMethod); get     
       
     
       
        foreach ($this->routes as $patternRoute=>$methods) {
            //VERIFICA SE A ROTA BATE COM O PADRÃO

           
        //print_r($this->routes);
      

       
            if (preg_match($patternRoute, $uri, $matches)) {
                
                //VERIFICA O METODO
                if (isset($methods[$httpMethod])) {
                  
                    unset($matches[0]);

                    //VARIÁVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables']= array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;                   

                    //CHAVES
                    $keys = $methods[$httpMethod]['variables'];

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
            
            $reflection = new ReflectionFunction($route['controller']);
          
            foreach($reflection->getParameters() as $parameter){               
                $name = $parameter->getName();
              $args[$name] = $route['variables'][$name] ?? '';

            }

          return  call_user_func_array($route['controller'], $args);
          
          
            throw new Exception("Página não encontrada", 1);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}