<?php
namespace App\Routes;
use App\Routes\Router;

class RegisteredRoutes extends Router
{
    public function __invoke()
    {
        try {
            $router = new Router;

            $router->group(['prefix' => 'admin', 'controller' => 'Admin', 'middlewares' =>['auth','teste']], function(){
                $this->add('/', 'GET', 'AdminController:index');
                $this->add('/user/(:numeric)/name/(:alpha)', 'GET', 'UserController:index',['userId','username']);
            });
            $router->add('/', 'GET', 'HomeController:index')->middlewares(['teste']);
            $router->add('/cart', 'GET', 'TesteController:index')->options(['prefix' => 'user', 'controller' => 'Pages', 'middlewares' =>[]]);
            $router->add('/product/(:numeric)', 'GET', 'ProductController:index');
            $router->add('/cart', 'POST', 'CartController:index');
            $router->add('/historico', 'GET', 'HistoricoController:index')->options([ 'controller' => 'Pages', 'middlewares' =>[]]);
            $router->add('/relogio', 'GET', 'RelogioController:index')->options([ 'controller' => 'Pages', 'middlewares' =>[]]);
            $router->add('/operacao', 'GET', 'OperacaoController:index')->options([ 'controller' => 'Pages', 'middlewares' =>[]]);
            $router->add('/programas', 'GET', 'ProgramasController:index');
            $router->init();
        }catch(\Exception $e){
            var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }
}