<?php

require  __DIR__. '/vendor/autoload.php';

use \App\Controller\Pages\Home;

$obRequest = new \App\Http\Request;
$obResponse = new \App\http\Response(200, 'Ola Mundo');

echo '<pre>';
print_r($obResponse);
exit;


echo Home::getHome();