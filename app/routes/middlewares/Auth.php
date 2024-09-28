<?php

namespace App\Routes\Middlewares;
use App\Interfaces\MiddlewaresInterface;

class Auth implements MiddlewaresInterface
{
    public function execute(){
        var_dump('execute Auth');
    }
}
