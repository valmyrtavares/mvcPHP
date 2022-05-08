<?php

namespace App\Http;

class Request
{
    
    private $httpMethod;
     
    private $uri;
    
    private $queryParams = [];
    
    private $postVars = [];
    
    private $headers = [];
    

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    //Nesse caso http://localhost/mvcphp/ retorna get
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    //Retonra /mvcphp/
    public function getUri() 
    {          
        return $this->uri;
    }

    //Ela não é disparada mas traz o headers um monte de informações que eu nao sei bem como se usa e nem da para printar
//     Array
// (
//     [Host] => localhost
//     [Connection] => keep-alive
//     [Cache-Control] => max-age=0
//     [sec-ch-ua] => " Not A;Brand";v="99", "Chromium";v="101", "Google Chrome";v="101"
//     [sec-ch-ua-mobile] => ?0
//     [sec-ch-ua-platform] => "Windows"
//     [Upgrade-Insecure-Requests] => 1
//     [User-Agent] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36
//     [Accept] => text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
//     [Sec-Fetch-Site] => same-origin
//     [Sec-Fetch-Mode] => navigate
//     [Sec-Fetch-User] => ?1
//     [Sec-Fetch-Dest] => document
//     [Referer] => http://localhost/mvcPHP/sobre
//     [Accept-Encoding] => gzip, deflate, br
//     [Accept-Language] => pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7
// )
    public function getHeaders()
    {
        return $this->headers;
    }

    //Esse só retorna se tiver ? nome=nome na url ou seja parametros
    public function getQueryParams()
    {      
        return $this->queryParams;
    }
    //Retorna um array vazio, não sei o que tem que fazer para que ele tenha retorno
    public function getPostVars()
    {      
        return $this->PostVars;
    }
    //importante é entender que nenhuma variável aqui traz o que vem depois da barra
}