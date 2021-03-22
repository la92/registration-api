<?php
class User{
	private $conn;
	private $table_name = "user_login";

	public $user_id;
	public $fullname;
	public $password;
	public $email;

	public function __construct($db){
		$this->conn = $db;
	}

	function signup(){
		if($this->isAlreadyExist()){
			return false;
		}


		$query = "INSERT INTO " .$this->table_name. "
			SET fullname=:fullname, email=:email, password=:password";

		$stmt = $this->conn->prepare($query);

		$this->fullname = htmlspecialchars(strip_tags($this->fullname));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));

		$stmt->bindParam(":fullname", $this->fullname);
		$stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":password", $this->password);

		if($stmt->execute()){
			$this->user_id = $this->conn->lastInsertId();
			return true;
		}
		return false;

	}


	function login(){


		$query = "SELECT * FROM " .$this->table_name. " WHERE fullname='" .$this->fullname. "' AND email='" .$this->email. "' AND password='" .$this->password."'";

		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		return $stmt;
	}




	function isAlreadyExist(){
		$query = "SELECT * FROM ".$this->table_name." WHERE email='".$this->email."'";
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

?>