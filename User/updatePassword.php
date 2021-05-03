<?php

include_once "../config/database.php";
include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();

$_POST = json_decode(file_get_contents('php://input'), true);

$_GET = json_decode(file_get_contents('php://input'), true);

$user = new User($db);

$user->password = base64_encode($_POST["password"]);
$user->email = $_GET['email'];


if($user->changePassword()){
	$new_passArr = array(
		"status" => true,
		"message"=> "Password Successfully Changed.",
		"email"=>$user->email,
		"password"=>$user->password
	);

}
else{
	$new_passArr = array(

	"status"=>false,
	"message"=> "Password cannot be updated"

);
}

print_r(json_encode($new_passArr));

?>