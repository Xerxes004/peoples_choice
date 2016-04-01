<?php
	class Login{
		private $connection;
		public function __construct(){
			$this->connection =  $_SESSION['DB'];
		}

		public function validateUser($username, $password){
			$user = $_POST['username'];
			$password = $_POST['password'];

			$result = mysqli_query($this->connection, "select * from student where username='$user'");

			$loginStatus = array('login' => false);

			if($result->num_rows == 1){
				$row = mysqli_fetch_assoc($result);
				if($row['username'] == $user && $row['pwHash'] == $password){
					$loginStatus = array('login'=>true, 'user'=>$row['realName']);
				}
			}
			echo json_encode($loginStatus);
		}
	}
?>