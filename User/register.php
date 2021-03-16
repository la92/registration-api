<?php
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$_POST = json_decode(file_get_contents('php://input'), true);

$user->full_name = $_POST['full_name'];
$user->email = $_POST['email'];
$user->password = base64_encode($_POST['password']);

if($user->signup()){
	$user_arr= array(
		"status" => true, 
		"message" => "Successfully Signup!",
		"user_id" => $user->user_id, 
		"full_name" => $user->full_name, 
		"email" => $user->email,
		"password" => $user->password,
	);
}
else{
	$user_arr = array(
		"status" => false, 
		"message" => "User already exists!"
	);
}

echo json_encode($user_arr);

?>
