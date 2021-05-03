<?php
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$nameErr="";

$_POST = json_decode(file_get_contents('php://input'), true);


$user->fullname = $_POST["fullname"];
$user->email = $_POST["email"];
$user->password = base64_encode($_POST["password"]);
 if(!preg_match("/^[a-zA-Z'-]+$/", $user->fullname)){
    echo 'Name is not valid! It must not contain numbers or special characters';
    exit;
  }

 if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
  $emailErr = "Invalid email format";
  echo "Email is not valid format";
  exit;
}


if($user->signup()){
	$user_arr = array(
		"status"=> true, 
		"message" => "Successfully Signup!",
		"user_id" => $user->user_id,
		"fullname"=> $user->fullname,
		"email"=> $user->email,
		"password" => $user->password	


	);

}

else{
	$user_arr = array(
		"status" => false, 
		"message" => "Invalid information!"
	);
	
}
print_r(json_encode($user_arr,JSON_PRETTY_PRINT));

?>
