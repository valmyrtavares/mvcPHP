<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page
{
    public static function getHome()
    {
        $content =  View::render('pages/home', [
            'name' => 'Valmyr Tavares',
            'description' => "Canal do youtube: http://youtube.com.br/oficial",
            'site' => "www.valmyrtavares.com.br"
        ]);

        return parent::getPage('WDEV', $content);
    }
}