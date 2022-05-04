<?php

require  __DIR__. '/vendor/autoload.php';

use App\Http\Router;
use \App\Utils\View;

define('URL', 'http://localhost/mvcPHP');

//DEFINE VALOR PADRÃO DAS VARIÁVIS
View::init([
    'URL' => URL
]);

//inicia o roteador
$obRouter = new Router(URL);

include __DIR__. '\routes\pages.php';

$obRouter->run()->sendResponse();