<?php

namespace App\Routes;

use App\Routes\Route;
use App\Routes\ControllerExec;
use App\Routes\Uri;
use App\Routes\Wildcards;

class Router
{
  private array $routes = [];
  private array $routeOptions = [];
  private Route $route;

  public function add(
    string $uri,
    string $request,
    string $controller,
    array $wildcardAliases = []
  ) {
    $this->route = new Route($request, $controller, $wildcardAliases);
    $this->route->addUri(new Uri($uri));
    $this->route->addWildcard(new Wildcard);
    $this->route->addRouteGroupOptions(new RouteOptions($this->routeOptions));
    $this->routes[] = $this->route;

    return $this;
  }

  public function group(array $routeOptions, \Closure $callback){
    $this->routeOptions = $routeOptions;
    $callback->call($this);
    $this->routeOptions = [];
  }

  public function middlewares(array $middlewares)
  {
    $options = (!empty($this->routeOptions)) ?
      array_merge($this->routeOptions, ['middlewares' => $middlewares]) : 
      ['middlewares' => $middlewares];
      
    $this->route->addRouteGroupOptions(new RouteOptions($options));
  }

  public function options(array $options){
    if(!empty($this->routeOptions)){
      $options = array_merge($this->routeOptions, $options);
    }
    $this->route->addRouteGroupOptions(new RouteOptions($options));
  }

  public function init()
  {
    // var_dump($this->routes);
    // die();
    foreach ($this->routes as $route) {
        if ($route->match())
        {
            Redirect::register($route); 
            return (new ControllerExec)->call($route);
        }
    }

    return (new ControllerExec)->call(new Route('GET', 'NotFoundController:index', []));
  }
} 
