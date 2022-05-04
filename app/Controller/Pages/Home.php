<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    public static function getHome()
    {
        $obOrganization = new Organization;//É estranho mas tem que estanciar dentro da função


        
        $content =  View::render('pages/home', [
            'name' => $obOrganization->name
        ]);

        return parent::getPage('HOME > WDEV', $content);
    }
}