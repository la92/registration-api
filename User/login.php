<?php

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
if(isset($_POST["email"]) && isset($_POST["password"])){
$user->email = $_POST["email"];
$user->password = base64_encode($_POST["password"]);

$stmt = $user->login();
if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_arr = array(
        "status"=>true,
        "message" => "Successfully login!", 
        "user_id" => $row['user_id'],
        "full_name" => $row['full_name'],
        "email" => $row['email'],
        "password" => $row['password']
    );

}}
else{
    $user_arr = array(
        "status" => false,
        "message" => "Invalid Email or Password!",
    );
}

echo json_encode($user_arr);

?>