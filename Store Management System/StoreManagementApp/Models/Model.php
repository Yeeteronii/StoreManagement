<?php

class Model{
	
	public static function connect(){
		$server = "localhost";
		$user = "root";
		$pass = "";
		$db = "store_management";

		$conn = new mysqli($server, $user, $pass, $db);

		if($conn->connect_error){
			die("Connection error! I can't deal with this anymore<br>" . $conn->connect_error);
		}

		return $conn;
	}

	// public static function connect_users(){
	// 	$server = "localhost";
	// 	$user = "root";
	// 	$pass = "";
	// 	$db = "storerights";

	// 	$conn = new mysqli($server, $user, $pass, $db);

	// 	if($conn->connect_error){
	// 		die("Connection error! I can't deal with this anymore<br>" . $conn->connect_error);
	// 	}

	// 	return $conn;
	// }
}

?>