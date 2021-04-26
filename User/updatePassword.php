<?php

include_once "../config/database.php";
include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();

$_PUT = json_decode(file_get_contents('php://input'), true);

$_GET = json_decode(file_get_contents('php://input'), true);

$user = new User($db);

$user->password = base64_encode($_PUT["password"]);
$user->user_id = $_GET['user_id'];


if($user->changePassword()){
	$new_passArr = array(
		"status" => true,
		"message"=> "Password Successfully Changed.",
		"user_id" =>$user->user_id,
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