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
		$instance = new Car();
		$cars = $instance->all();
		require_once APP_ROOT . '/views/components/app-templete.php';
	}

	public function search($pattern, RouteCollection $routes)
	{
		echo $pattern;
		if (isset($_COOKIE['login-user'])) {
			$good = new Good();
			$result = $good->search($pattern);
			echo $result;
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}
	
	public function save($data, RouteCollection $routes)
	{
		if (isset($_COOKIE['login-user'])) {
			$cars = new Car();
			echo $data;
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}
}
