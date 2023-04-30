<?php 

namespace App\Controllers;

use App\Models\Good;
use Symfony\Component\Routing\RouteCollection;

class RelationController
{
	
    // Homepage action
	public function index(RouteCollection $routes)
	{
		require_once APP_ROOT . '/views/components/app-templete.php';
		
	}
	
	public function search($pattern ,RouteCollection $routes)
	{
		if(isset($_COOKIE['login-user'])) {
			$good = new Good();

			$result = $good->search($pattern);
		} else {
			header('Location: /yadak');
			exit;
		}
	}
}