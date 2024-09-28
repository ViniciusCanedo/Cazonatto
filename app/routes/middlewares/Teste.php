<?php

namespace App\Routes\Middlewares;
use App\Interfaces\MiddlewaresInterface;

class Teste implements MiddlewaresInterface
{
    public function execute(){
        var_dump('execute Teste');
    }
}
