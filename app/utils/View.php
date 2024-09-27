<?php 
namespace App\Utils;

class View{
    public static function render(string $view, array $bind =[]): string{
        $viewPath = "/var/www/html/app/views/$view.html";
        $viewContent = file_exists($viewPath) 
                       ? file_get_contents($viewPath) 
                       : '' ;

        $paramsName = array_keys($bind);
        $paramsName = array_map(function($item){
            return '{{' . $item . '}}';
        }, $paramsName);

        return str_replace($paramsName, array_values($bind), $viewContent);
    }
}