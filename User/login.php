<?php

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = isset($_GET['email']) ? $_GET['email'] : die();

$user->full_name = isset($_GET['full_name']) ? $_GET['full_name'] : die();
//$user->username = isset($_GET['username']) ? $_GET['username'] : die();
$user->password = base64_encode(isset($_GET['password']) ? $_GET['password'] : die());

$stmt = $user->login();
if($stmt->rowCount() > 0){
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$user_arr = array(
		"status"=>true,
		"message" => "Successfully login!", 
		"user_id" => $row['user_id'],
		"full_name" => $row['full_name'],
		"email" => $row['email']

	);

}
else{
	$user_arr = array(
		"status" => false,
		"message" => "Invalid Username or Password!",
	);
}

print_r(json_encode($user_arr));

?>