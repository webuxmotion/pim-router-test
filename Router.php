<?php

class Router {

  private $routes = [];

  private $patterns = [
    'int' => '[0-9]+',
    'str' => '[a-zA-Z\.\-_%]+',
    'any' => '[a-zA-Z0-9\.\-_%]+'
  ];

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

        $position = strpos($route['pattern'],"(");

        if($position) {
          $patternBase = substr($route['pattern'], 0, $position);

          $pos = strpos($path, $patternBase);
          if($pos || $pos === 0) {
            $parameter = substr($path, strlen($patternBase));

            if($parameter || $parameter == 0) {
              
              $positionEnd = strpos($route['pattern'],")");

              if($positionEnd) {
                $rool = substr($route['pattern'], $position, $positionEnd);
                $rool = substr($rool, 1, strlen($rool) - 2);
                list($paramName, $type) = explode(":", $rool);

                $regEx = $this->patterns[$type];

                if(preg_match('/^' . $regEx . '$/i',$parameter))
                {
                   return [$route['controller'], $parameter];
                }
              }
            }
          }
        } elseif ($route['pattern'] == $path) {
          return [$route['controller']];
        }
      }
    }

    return null;
  }
}
