<?php 

include_once '../config/database.php';
include_once '../ratings/rating.php';

$database = new Database();
$db = $database->getDatabase();

$rating = new Rating($db);

$_POST = json_decode(file_get_contents('php://input'), true);

$rating->imdb_id = $_POST["imdb_id"];
$rating->user_id = $_POST["user_id"];
$rating->rating = $_POST["rating"];
$rating->movie_title = $_POST["movie_title"];

if($rating->addRating()){
	$rating_arr = array(
		"status"=>true,
		"message"=>"Successfully added rating",
		"imdb_id"=> $rating->imdb_id, 
		"user_id"=>$rating->user_id,
		"rating" =>$rating->rating,
		"movie_title"=>$rating->movie_title
	);
}
else{
	$rating_arr = array(
		"status" =>false,
		"message":"Rating already exists!";

	);
}
print_r(json_encode($rating_arr));

?>