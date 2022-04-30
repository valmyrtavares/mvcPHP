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
        $this->header[$key]= $value;
    }
}