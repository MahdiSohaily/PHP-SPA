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

$routes->add('getdata',
    new Route(constant('URL_SUBFOLDER') .'/getdata/{pattern}',
    array('controller' => 'RelationController', 'method'=>'search'),
    array('pattern' => '[a-zA-Z0-9]+'))
);

