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
        return new Response(200, Pages\About::getAbout());
    }
]);

//Rota de Sobre
$obRouter->get('/testando', [
    function () {
        return new Response(200, Pages\Testando::getTestando());
    }
]);

//Rota de Dinâmica
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao   ) {
        return new Response(200, 'Página ' .$idPagina. '-' .$acao);
    }
]); 