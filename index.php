<?php

require  __DIR__. '/vendor/autoload.php';

use App\Http\Router;
use \App\Utils\View;
use \App\Http\Request;



define('URL', 'http://localhost/mvcPHP');

//DEFINE VALOR PADRÃO DAS VARIÁVIS
View::init([
    'URL' => URL
]);



//inicia o roteador
$obRouter = new Router(URL);


include __DIR__. '\routes\pages.php';

$obRouter->run()->sendResponse();



// Isso é tudo que o obRouter traz

// App\Http\Router Object
// (
//     [url:App\Http\Router:private] => http://localhost/mvcPHP
//     [prefix:App\Http\Router:private] => /mvcPHP
//     [routes:App\Http\Router:private] => Array
//         (
//         )

//     [request:App\Http\Router:private] => App\Http\Request Object
//         (
//             [httpMethod:App\Http\Request:private] => GET
//             [uri:App\Http\Request:private] => /mvcPHP/sobre
//             [queryParams:App\Http\Request:private] => Array
//                 (
//                 )

//             [postVars:App\Http\Request:private] => Array
//                 (
//                 )

//             [headers:App\Http\Request:private] => Array
//                 (
//                     [Host] => localhost
//                     [Connection] => keep-alive
//                     [sec-ch-ua] => " Not A;Brand";v="99", "Chromium";v="101", "Google Chrome";v="101"
//                     [sec-ch-ua-mobile] => ?0
//                     [sec-ch-ua-platform] => "Windows"
//                     [Upgrade-Insecure-Requests] => 1
//                     [User-Agent] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36
//                     [Accept] => text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
//                     [Sec-Fetch-Site] => same-origin
//                     [Sec-Fetch-Mode] => navigate
//                     [Sec-Fetch-User] => ?1
//                     [Sec-Fetch-Dest] => document
//                     [Referer] => http://localhost/mvcPHP/sobre
//                     [Accept-Encoding] => gzip, deflate, br
//                     [Accept-Language] => pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7
//                 )

//         )

// )