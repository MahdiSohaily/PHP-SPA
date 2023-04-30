<?php 
namespace App\Models;

class User
{

    public function login($email, $password)
    {
        $user = $this->checkUser($email,$password);
        if($user) {
			return $user;
        } else {
            return false;
        }
    }
	
	public function checkUser($email, $pass)
	{
        // Create connection
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME);

        $sql = "SELECT * FROM users WHERE email='$email'";
		$user = $conn->query($sql)->fetch_assoc();
		$password = $user['password'];
		$conn -> close();

        if (count($user)> 0 && $password === $pass) {
			return $user;
          } else {
            return false;
          }
	}
}