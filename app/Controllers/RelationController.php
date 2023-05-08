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
		$message = 'You have an error!';
		if (isset($_COOKIE['login-user'])) {

			// check if the form is submitted
			if (isset($_POST['submit'])) {
				$mode = $_POST['mode'];
				$serialNumber = $_POST['serialNumber'];
				$name = $_POST['name'];
				$car = $_POST['car_id'];
				$status = $_POST['status'];
				$value = $_POST['value'];

				if ($mode === 'create') {
					echo 'create mode';
					print_r($_POST);
				} else {
					echo 'update mode';
					print_r($_POST);
				}
			}

			$instance = new Car();
			$cars = $instance->all();
			require_once APP_ROOT . '/views/components/relation.php';
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}

	public function search($pattern, RouteCollection $routes)
	{
		if (isset($_COOKIE['login-user'])) {
			$good = new Good();

			$result = $good->search($pattern);
			echo $result;
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}

	public function save(RouteCollection $routes)
	{
		echo 'ff';
		if (isset($_COOKIE['login-user'])) {
			$cars = new Car();
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}

	public function load($pattern, RouteCollection $routes)
	{
		if (isset($_COOKIE['login-user'])) {
			$good = new Good();

			$result = $good->load($pattern);
			echo json_encode($result);
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}

	public function description($pattern, RouteCollection $routes)
	{
		if (isset($_COOKIE['login-user'])) {
			$good = new Good();

			$result = $good->description($pattern);
			echo json_encode($result);
		} else {
			header('Location: /' . URL_SUBFOLDER);
			exit;
		}
	}
}
