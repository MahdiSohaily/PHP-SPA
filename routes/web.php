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

$routes->add(
    'getData',
    new Route(
        constant('URL_SUBFOLDER') . '/getData/{pattern}',
        array('controller' => 'RelationController', 'method' => 'search'),
        array('pattern' => '[a-zA-Z0-9]+')
    )
);

$routes->add(
    'loadData',
    new Route(
        constant('URL_SUBFOLDER') . '/loadData/{pattern}',
        array('controller' => 'RelationController', 'method' => 'load'),
        array('pattern' => '[0-9]+')
    )
);

$routes->add(
    'loadDescription',
    new Route(
        constant('URL_SUBFOLDER') . '/loadDescription/{pattern}',
        array('controller' => 'RelationController', 'method' => 'description'),
        array('pattern' => '[0-9]+')
    )
);

$routes->add(
    'saveRelation',
    new Route(
        constant('URL_SUBFOLDER') . '/saveRelation',
        array('controller' => 'RelationController', 'method' => 'save')
    )
);
