<?php

namespace App\Http;

class Response
{
    private $httpCode=200;
    private $headers=[];
    private $contentType='text/html';
    private $content;
    
    
    public function __construct($httpCode, $content, $contentType='text/html')
    {
        $this->httpCode =   $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    public function setContentType($contentType)
    {
        $this->ContentType = $contentType;
        $this->addHeader('Content-Type', $contentType);            
     
    }

    public function addHeader($key, $value)
    {
        
        //print_r($key); Content-Type       
        //print_r($value);text/html     
        $this->headers[$key]= $value;
    }

    private function sendHeaders()
    {
         http_response_code($this->httpCode);     
    

        foreach ($this->headers as $key=>$value) {
            header($key. ': ' .$value);
        }
    }

    public function sendResponse()
    {
        //Envia os header
        $this->sendHeaders();      
        //imprime conteudo      
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}