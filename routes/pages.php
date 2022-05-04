<?php

use \App\Http\Response;
use \App\Controller\Pages;

//Rota de Home
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

//Rota de Sobre
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getHome());
    }
]);