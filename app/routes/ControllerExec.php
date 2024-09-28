<?php

namespace App\Routes;

use Exception;
use App\Routes\Middleware;

class ControllerExec
{
  private function controllerPath($route, $controller){
    return ($route->getRouteOptionsInstance() && $route->getRouteOptionsInstance()->optionExist('controller')) ?
    "App\\Controllers\\" . $route->getRouteOptionsInstance()->execute('controller') . "\\" . $controller :
    "App\\Controllers\\" . $controller;
  }

  public function call(Route $route)
  {
    $controller = $route->controller;

    if (!str_contains($controller, ':')) {
      throw new Exception("Colon need to controller {$controller} in route");
    }

    [$controller, $action] = explode(':', $controller);

    $controllerInstance = $this->controllerPath($route, $controller);

    if (!class_exists($controllerInstance)) {
      throw new Exception("Controller {$controller} does not exist");
    }

    $controller = new $controllerInstance;

    if (!method_exists($controller, $action)) {
      throw new Exception("Action {$action} does not exist");
    }

    //middlewares
    if($route->getRouteOptionsInstance()?->optionExist('middlewares')){
      (new Middleware($route->getRouteOptionsInstance()->execute('middlewares')))->execute(); 
    }

    // var_dump($route->getWildcardInstance());
    // die();

    // if($route->getWildcardInstance()){
      call_user_func_array([$controller, $action], $route->getWildcardInstance()?->getParams() ?? []);
    // }else{
    //   call_user_func_array([$controller, $action], []);
    // }
    
  }
}
