<?php
namespace App\Routes;
use App\Routes\Router;

class Routes extends Router
{
    public function __invoke()
    {
        try {
            $router = new Router;
            
            $router->add('/', 'GET', 'HomeController:index')->options(['controller' => 'Pages']);
            

            $router->init();
        }catch(\Exception $e){
            var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }
}