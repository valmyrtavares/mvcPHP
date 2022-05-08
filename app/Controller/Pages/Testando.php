<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Testando extends Page
{
    public static function getTestando()
    {
        //$obOrganization = new Organization;//É estranho mas tem que estanciar dentro da função


        
        $content =  View::render('pages/testando', [
            'name' => 'Valmyr Tavaes Malta de Lima',
            'description' => "Eu estou testando",
            'site' => "Eu sou o site"
        ]);

        return parent::getPage('SOBRE > WDEV', $content);
    }
}