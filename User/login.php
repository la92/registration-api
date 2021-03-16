<?php

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = isset($_POST["email"]) ? $_POST["email"] : echo "ERROR");
$user->user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : echo "ERROR");
$user->full_name = isset($_POST["full_name"]) ? $_POST["full_name"] : "ERROR");
//$user->username = isset($_GET['username']) ? $_GET['username'] : die();
$user->password = base64_encode(isset($_POST["password"]) ? $_POST["password"] : echo "ERROR");

$stmt = $user->login();
if($stmt->rowCount() > 0){
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$user_arr = array(
		//"status"=>true,
		//"message" => "Successfully login!", 
		//"user_id" => $row['user_id'],
		//"full_name" => $row['full_name'],
		"email" => $row['email'],
		"password" => $row['password']

	);

}
else{
	$user_arr = array(
		"status" => false,
		"message" => "Invalid Email or Password!",
	);
}

echo json_encode($user_arr);

?>
