<?php

use Cake\Routing\Router;

Router::defaultRouteClass('Route');

Router::plugin('Crawler', ['_namePrefix' => 'crawler:'], function ($routes) {
    $routes->connect('/', ['controller' => 'Services', 'action' => 'index']);

    $routes->fallbacks('DashedRoute');
});
