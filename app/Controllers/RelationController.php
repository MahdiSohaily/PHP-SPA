<?php 

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;

class RelationController
{
    // Homepage action
	public function index(RouteCollection $routes)
	{
		require_once APP_ROOT . '/views/login.php';
		
	}
}