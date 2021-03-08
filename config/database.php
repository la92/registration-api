<?php
class Database{
	private $host = "sql2.njit.edu";
	private $db_name = "la92";
	private $username = "la92";
	private $password = "La607824!!";
	public $conn;


	public function getConnection(){
		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		}
		catch(PDOEXception $e){
			echo "Connection error: ".$e->getMessage();
		}
		return $this->conn;
	}
}
?>