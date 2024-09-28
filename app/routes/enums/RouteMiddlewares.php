<?php
namespace App\Routes\Enums;

use App\Routes\Middlewares\Auth;
use App\Routes\Middlewares\Teste;

enum RouteMiddlewares:string
{
    case auth = Auth::class;
    case teste = Teste::class; 
}
