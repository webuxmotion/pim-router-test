<?php

class Router {

  private $routes = [];

  public function add($key, $pattern, $controller, $method = 'GET') {
    
    $this->routes[$key] = [
      "pattern" => $pattern,
      "controller" => $controller,
      "method" => $method
    ];
  } 

  public function dispatch($method, $path) {

    foreach ($this->routes as $route) {

      if ($route['method'] == $method) {
        if ($route['pattern'] == $path) {
          return [$route['controller']];
        } 
      } 
    }

    return null;
  }
}
