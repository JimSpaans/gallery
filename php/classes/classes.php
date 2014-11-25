<?php

class Connection{

	protected $db;

	function __construct($host, $user, $password, $database){
		$this->db = new PDO("mysql:host=".$host.";dbname=".$database.";charset=utf8", $user, $password);
	}
}

class User extends Connection{

	private $conn;

	function __construct(){
		$this->conn = new Connection("localhost", "root", "", "gallery");
		$this->db = $this->conn->db;
	}


	public function Login($username, $password){
		$password = sha1($password);
		$login_query = 'SELECT * FROM user WHERE username=:username AND password=:password';
		$stmt = $this->db->prepare($login_query);

		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				$result = $stmt->fetch();
				return $result['id'];
			}else{
				return false;
			}
		}else{
			echo "No execute happened.";
		}
	}

	public function returnUsername(){
		return $this->username;
	}

	public function returnID(){
		$getid_query = 'SELECT id FROM user WHERE username = "'. $this->username . '"';
		$stmt = $this->pdo->prepare($getid_query);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		if($stmt->execute()){
			$userid = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->id = $userid['id'];
		}

		return $this->id;
	}

	public function Register ($displayname, $username, $email, $password, $passwordconfirm){

		$username = $this->sanitize($username);
		$password = sha1($password);
		$passwordconfirm = sha1($passwordconfirm);


		// Check for already existing username..
		$usernameCheck = 'SELECT * FROM user WHERE username =:username';
		$stmt = $this->db->prepare($usernameCheck);
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				array_push($errors, "Username is already taken.");
			}
		}

		// Check for already used email adress.
		$emailCheck = 'SELECT * FROM user WHERE email = :email';
		$stmt = $this->db->prepare($emailCheck);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->rowCount();
		if($stmt->execute()){
			$count = $stmt->rowCount();
			if($count != 0){
				array_push($errors, "Email-adress is already been used.");
			}
		}

		// Check for password fields, if they match.
		if($password != $passwordconfirm){
			array_push($errors, "Your passwords don't match.");
		}

		// Counting the errors, and returning them when they exist.
		if(count($errors) == 0){
			$register_query = 'INSERT INTO user(id, username, displayname, password, email)VALUES(null, :username, :displayname, :password, :email)';
			$stmt = $this->db->prepare($register_query);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':displayname', $displayname, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();

			if($stmt->execute()){
				return true;
			}
		}
		return $errors;
	}




	private function sanitize($input){
		$input = htmlspecialchars($input);
		$input = nl2br($input);
		return $input;
	}
}