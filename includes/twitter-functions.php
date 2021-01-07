<?php
class Users {
	public $tableName = 'ss_users';
	
	function __construct(){
		//Database configuration
		$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'shapijo8_stomdem'; //Define database username
		$dbPassword = 'iHE@XwN=E%C;'; //Define database password
		$dbName = 'shapijo8_customdemo'; //Define database name
		
		//Connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$username,$fname,$lname,$email,$locale,$oauth_token,$oauth_secret,$profile_image_url){
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE email = '".$email."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0){
			
			$row = mysqli_fetch_assoc($prevQuery);
			$userid = $row["user_id"];
			
			if($row["user_type"]==$_SESSION["GTDemoUserType"])
			{
				$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', last_login = '".date("Y-m-d H:i:s")."', email = '".$email."', validate = '1', status = '1'  WHERE user_id = '".$userid."'") or die(mysqli_error($this->connect));
			}
			else
			{			
				$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', last_login = '".date("Y-m-d H:i:s")."', email = '".$email."', user_type = 'B', validate = '1', status = '1'  WHERE user_id = '".$userid."'") or die(mysqli_error($this->connect));
			}			
			
			$_SESSION['GTUserID'] = $row['user_id'];
			$_SESSION['GTUserFirstName']=$row["firstname"];
			$_SESSION['GTUserLastName']=$row["lastname"];			
			$_SESSION['GTUserEmail']=$row["email"];
			$_SESSION['GTUserMobile']=$row["mobile"];
			$_SESSION['GTUserType']=$row["user_type"];
			$_SESSION['GTUserProfilepic']=$row["photograph"];
			$_SESSION['GTUserProfileID']=$oauth_uid;
			$_SESSION['GTUserLoginFrom']=$oauth_provider;
			$_SESSION['GTFrentorEditP']=togetusereditprofile($_SESSION['GTUserID']);
		
		
		}
		else
		{
			
			$insert = mysqli_query($this->connect,"INSERT INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', email = '".$email."', firstname = '".$fname."', lastname = '".$lname."', locale = '".$locale."', oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', photograph = '".$profile_image_url."', user_type = '".$_SESSION["GTDemoUserType"]."', validate = '1', status = '1', add_date = '".date("Y-m-d H:i:s")."', last_login = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
			
			$_SESSION['GTUserID'] = mysqli_insert_id($this->connect);			
			$_SESSION['GTUserFirstName']=$fname;
			$_SESSION['GTUserLastName']=$lname;			
			$_SESSION['GTUserEmail']=$username;
			$_SESSION['GTUserMobile']="";
			$_SESSION['GTUserType']=$_SESSION["GTDemoUserType"];
			$_SESSION['GTUserProfilepic']=$profile_image_url;
			$_SESSION['GTUserProfileID']=$oauth_uid;
			$_SESSION['GTUserLoginFrom']=$oauth_provider;
			$_SESSION['GTFrentorEditP']=togetusereditprofile($_SESSION['GTUserID']);
			
			
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}
}
?>