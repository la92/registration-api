<?php
class Rating{
	private $conn;
	private $table_name = "movie_rating";

	public $imdb_id;
	public $user_id;
	public $rating;
	public $movie_title;

	public function __construct($db){
		$this->conn = $db;
	}

	function addRating(){
		if($this->ratingAlreadyExists()){
			return false;
		}

		$query = "INSERT INTO " .$this->table_name. " SET imdb_id=:imdb_id, user_id=:user_id, rating=:rating, movie_title=:movie_title";

		$stmt = $this->conn->prepare($query);

		$this->imdb_id = htmlspecialchars(strip_tags($this->imdb_id));
		$this->user_id = htmlspecialchars(strip_tags($this->user_id));
 		$this->rating = htmlspecialchars(strip_tag($this->rating));
		$this->movie_title = htmlspecialchars(strip_tag($this->movie_title));

		$stmt->bindParam(":imdb_id", $this->imdb_id);
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":rating", $this->rating);
		$stmt->bindParam(":movie_title". $this->movie_title);

		if($stmt->execute()){
			$this->user_id = $this->conn->lastInsertId();
			return true;
		}
		return false;
	}


	function getRating(){

		$query = "SELECT `imdb_id` FROM ".$this->table_name." WHERE `user_id`='".$this->user_id."';";

		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		//print_r($stmt);

		//$result = $stmt->fetchAll();
		//print_r($result);
		//return $result;
		return $stmt;
	}

	function ratingAlreadyExists(){
		$query  = "SELECT * FROM ".$this->table_name." WHERE imdb_id='".$this->imdb_id."'";

		$stmt->execute();
		if($stmt->rowCount() > 0){
			return true;
		}
		else{
			return false;
		}
	}
}
?>