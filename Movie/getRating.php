<?php 

include_once '../config/database.php';
include_once '../ratings/rating.php';

$database = new Database();
$db = $database->getConnection();

$_GET = json_decode(file_get_contents('php://input'),true);

$rating = new Rating($db);

$rating->imdb_id = $_GET["imdb_id"];
$rating->user_id = $_GET["user_id"];
$rating->rating = $_GET["rating"];
$rating->movie_title = $_GET["movie_title"];


$stmt = $rating->getRating();

if($stmt->rowCount() > 0){

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	//$stmt->fetchAll();
	
	//print_r($stmt->fetchAll());

	$rating_arr = array(
		"status" =>true,
		"message" => "Success",
		array(
		"imdb_id" =>$row["imdb_id"],
		"user_id"=>$row["user_id"],
		"rating"=>$row["rating"],
		"movie_title"=>$row["movie_title"])
		//"imdb_id" =>$rating->imdb_id,
		//"user_id"=>$rating->user_id,
		//"rating"=>$rating->rating,
		//"movie_title"=>$rating->movie_title
	);
}
else{

	$rating_arr = array(
		"status"=>false,
		"message"=>"Enable to get the ratings"

	);
}

print_r(json_encode($rating_arr));

?>
