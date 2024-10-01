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
            $router->group(['prefix' => '/api', 'controller' => 'Api'], function(){
                $this->add('/v1/(:any)/add', 'POST', 'ApiController:add', ['table']);
                $this->add('/v1/(:any)/get/(:int)', 'GET', 'ApiController:add', ['table', 'id']);
                $this->add('/v1/(:any)/list', 'GET', 'ApiController:add', ['table']);
                $this->add('/v1/(:any)/modify/(:int)', 'PUT', 'ApiController:add', ['table', 'id']);
                $this->add('/v1/(:any)/delete/(:int)', 'DELETE', 'ApiController:add', ['table', 'id']);
            });

            $router->init();
        }catch(\Exception $e){
            var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }
}