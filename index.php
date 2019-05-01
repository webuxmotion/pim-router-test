<?php

require 'Router.php';

$r = new Router();

$r->add('home', '/', 'HomeController:index');
$r->add('news', '/news', 'NewsController:showList');
$r->add('news-one', '/news/(id:int)', 'NewsController:showOne');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$controller = $r->dispatch($requestMethod, $requestUri);

if ($controller == null) {
  $controller = ['ErrorController:page404'];
}

list($class, $action) = explode(":", $controller[0]);
$parameters = $controller[1];

require $class . '.php';

call_user_func_array(
  array(
    new $class('class constructor'),
    $action
  ),
  [$parameters]
);
