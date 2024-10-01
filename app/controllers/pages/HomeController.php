<?php
namespace App\Controllers\Pages;

use App\Utils\View;

class HomeController{
    public function index(): void{
        echo View::render('index', [
            'name' => 'Vinicius Gabriel'
        ]);
    }
}