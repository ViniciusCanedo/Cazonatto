<?php

namespace App\Routes;

use App\Interfaces\MiddlewaresInterface;
use App\Routes\Enums\RouteMiddlewares;

class Middleware
{
    private string $middlewaresClass;

    public function __construct(protected array $middlewares){}

    private function middlewareExist(string $middleware){
        $casesMiddleware = RouteMiddlewares::cases();

        return array_filter($casesMiddleware,
        function(RouteMiddlewares $middlewareCase) use ($middleware){
            if($middlewareCase->name === $middleware){
                $this->middlewaresClass = $middlewareCase->value;
                return true;
            }
            return false;
        });
    }

    public function execute()
    {
        foreach($this->middlewares as $middleware){
            if(!$this->middlewareExist($middleware)){
                throw new \Exception("Middleware {$middleware} not exist");
            }

            $class = $this->middlewaresClass;

            if(!class_exists($class)){
                throw new \Exception("Class middleware {$middleware} not exist");
            }

            $middlewareClass = new $class;

            if(!$middlewareClass instanceof MiddlewaresInterface){
                throw new \Exception("Middleware {$class} must implement MiddlewaresInterface");
            }

            $middlewareClass->execute();

        }
    }
}
