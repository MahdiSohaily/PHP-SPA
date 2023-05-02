<?php 

namespace App\Controllers;

use App\Models\Good;
use App\Models\Car;
use Symfony\Component\Routing\RouteCollection;

class RelationController
{
	
    // Homepage action
	public function index(RouteCollection $routes)
	{
		$car = new Car();
		$cars = $car->all();
		require_once APP_ROOT . '/views/components/app-templete.php';
		
	}
	
	public function search($pattern ,RouteCollection $routes)
	{
		if(isset($_COOKIE['login-user'])) {
			$good = new Good();
			$result = $good->search($pattern);
			echo $result;
		} else {
			header('Location: /yadak');
			exit;
		}
	}
	
	public function getCars($pattern ,RouteCollection $routes)
	{
		if(isset($_COOKIE['login-user'])) {
			$cars = new Car();
			$result = $cars->search($pattern);
			echo $result;
		} else {
			header('Location: /yadak');
			exit;
		}
	}
}