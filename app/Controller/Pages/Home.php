<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home
{
    public static function getHome()
    {
        return View::render('pages/home', [
            'name' => 'Valmyr Tavares',
            'description' => "Canal do youtube: http://youtube.com.br/oficial"
        ]);
    }
}