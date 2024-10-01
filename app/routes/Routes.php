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
            $router->group(['prefix' => '/api', 'controller' => 'Api'], function () {
                $this->add('/v1/(:any)/add', 'POST', 'ApiController:add', ['table']);
                $this->add('/v1/(:any)/get/(:numeric)', 'GET', 'ApiController:getOne', ['table', 'id']);
                $this->add('/v1/(:any)/list', 'GET', 'ApiController:listAll', ['table']);
                $this->add('/v1/(:any)/modify/(:numeric)', 'PUT', 'ApiController:modify', ['table', 'id']);
                $this->add('/v1/(:any)/delete/(:numeric)', 'DELETE', 'ApiController:remove', ['table', 'id']);
            });

            $router->init();
        } catch (\Exception $e) {
            var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }
}