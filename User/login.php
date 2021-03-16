<?php

include_once "../config/database.php";
include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();

//$_POST = json_decode(file_get_contents('php://input'), true);


$user = new User($db);
//if(isset($_POST["email"]) && isset($_POST["password"])){

//$user->fullname = $_GET["fullname"];
$user->email = $_GET["email"];
$user->password = base64_encode($_GET["password"]);
//$user->email = isset($_GET["email"]) ? $_GET["email"] : echo "ERROR";
//$user->password = base64_encode(isset($_GET["password"]) ? $_GET["password"] : echo "ERROR");

$stmt = $user->login();
if($stmt->rowCount() > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_arr = array(
        "status"=>true,
        "message" => "Successfully login!", 
        "user_id" => $row["user_id"],
      // "fullname" => $row["fullname"],
        "email" => $row["email"],
        "password"=> $row["password"]
    );

}
else{
    $user_arr = array(
        "status" => false,
        "message" => "Invalid Email or Password!",
    );

}

print_r(json_encode($user_arr));

?>