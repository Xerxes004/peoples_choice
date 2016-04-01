<?php
	class PeoplesChoice{
		private $connection;
		public function __construct(){
			$this->connection =  $_SESSION['db'];
		}

		public function getPeoplesChoiceData(){
			$usersQuery = mysqli_query($this->connection, 'select * from student');

			$users = [];
			while($row = mysqli_fetch_assoc($usersQuery)){
				array_push($users, $row['realName']);
			}

			$projQuery = mysqli_query($this->connection, 'select * from project');

			$projects = [];
			while($row = mysqli_fetch_assoc($projQuery)){
				array_push($projects, $row['name']);
			}

			$data = array("users" => $users, "projects"=>$projects);
			return $data;
		}
		
	}