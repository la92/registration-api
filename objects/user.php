<?php
class User{
	private $conn;
	private $table_name = "user_login";

	public $user_id;
	public $full_name;
	public $password;
	public $email;

	public function __construct($db){
		$this->conn = $db;
	}

	function signup(){
		if($this->isAlreadyExist()){
			return false;
		}

		$query = "INSERT INTO ".$this->table_name."
		SET 
		full_name=:full_name, email = :email, password = :password";

		$stmt = $this->conn->prepare($query);

		$this->full_name = htmlspecialchars(strip_tags($this->full_name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));

		$stmt->bindParam(":full_name", $this->full_name);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":password", $this->password);

		if($stmt->execute()){
			$this->user_id = $this->conn->lastInsertId();
			return true;
		}
		return false;

	}


	function login(){
		$query = "SELECT `user_id`, `full_name`, `email`, `password` 
			FROM 
			".$this->table_name."
			WHERE email='".$this->email."' AND password='".$this->password."'";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	function isAlreadyExist(){
		$query = "SELECT * FROM ".$this->table_name." WHERE full_name='".$this->full_name."'";
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		if($stmt->rowCount() > 0){
			return true;
		}
		else{
			return false;
		}
	}
}