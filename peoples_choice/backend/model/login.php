<?php
	class Login{
		private $connection;
		public function __construct(){
			$this->connection =  $_SESSION['db'];
		}

		public function validateUser($username, $password){
			$user = $_POST['username'];
			$password = $_POST['password'];

			$result = mysqli_query($this->connection, "select s.username, realName, pwHash, coalesce(a.username, 'false') isAdmin from wkjs_student s left join wkjs_admin a on s.username=a.username where s.username='$user'");

			$loginStatus = array('login' => false);

			if($result->num_rows == 1){
				$row = mysqli_fetch_assoc($result);
				if($row['username'] == $user && $row['pwHash'] == $password){
					session_start();
					$_SESSION['logged-in'] = true;
					$_SESSION['username'] = $row['realName'];
					$_SESSION['linux-name'] = $user;
					$_SESSION['isAdmin'] = $row['isAdmin'] == 'false' ? false:true;
					$loginStatus = array('login'=>true, 'user'=>$row['realName'], 'isAdmin'=>$_SESSION['isAdmin']);
				}
			}
			echo json_encode($loginStatus);
		}
	}
?>