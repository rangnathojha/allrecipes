<?php
class User {
	$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'shapijo8_stomdem'; //Define database username
		$dbPassword = 'iHE@XwN=E%C;'; //Define database password
		$dbName = 'shapijo8_customdemo'; //Define database name
	private $userTbl    = 'ss_users';
	
	function __construct(){
		if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
	}
	
	function checkUser($userData = array()){
		if(!empty($userData)){
			//Check whether user data already exists in database
			$prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
			$prevResult = $this->db->query($prevQuery);
			if($prevResult->num_rows > 0){
				//Update user data if already exists
				$query = "UPDATE ".$this->userTbl." SET firstname = '".$userData['first_name']."', lastname = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', photograph = '".$userData['picture']."', gpluslink = '".$userData['link']."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
				$update = $this->db->query($query);
			}else{
				//Insert user data
				$query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', firstname = '".$userData['first_name']."', lastname = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', photograph = '".$userData['picture']."', gpluslink = '".$userData['link']."', add_date = '".date("Y-m-d H:i:s")."'";
				$insert = $this->db->query($query);
			}
			
			//Get user data from the database
			$result = $this->db->query($prevQuery);
			$userData = $result->fetch_assoc();
		}
		
		//Return user data
		return $userData;
	}
}
?>