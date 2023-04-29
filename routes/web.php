<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add(
    'login',
    new Route(
        constant('URL_SUBFOLDER') . '/',
        array(
            'controller' => 'LoginController',
            'method' => 'login'
        ),
        array()
    )
);

$routes->add(
    'logout',
    new Route(
        constant('URL_SUBFOLDER') . '/logout',
        array(
            'controller' => 'LoginController',
            'method' => 'logout'
        ),
        array()
    )
);

$routes->add(
    'relation',
    new Route(
        constant('URL_SUBFOLDER') . '/relation',
        array(
            'controller' => 'RelationController',
            'method' => 'index'
        ),
        array()
    )
);

