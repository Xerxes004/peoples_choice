<?php 
	/**
	* 
	*/
	class AdminModel extends Model
	{

		public function getAdminData()
		{
			$sm = new StudentModel();
			$students = $sm->getStudents();

			$pm = new ProjectModel();
			$projects = $pm->getProjects();

			$tm = new TeamModel();
			foreach ($projects as $project) {
				$projectName = $project->name;
				$teams["$projectName"] = $tm->getTeamsForProject($projectName);
			}

			return array("students"=>$students, "projects"=>$projects, "teams"=>$teams);
		}

		public function getStudent($username){

		}

		public function createStudent($username, $realName, $pwHash, $admin)
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into student values('$username', '$realName', '$pwHash')");
			if($admin){
				$this->queryInTransaction("insert into admin values('$username')");
			}
			return $this->endTransaction();
		}

		public function updateStudent($username, $realName, $admin, $primarykey){
			$this->beginTransaction();
			$this->queryInTransaction('set foreign_key_checks=0');
			$this->queryInTransaction("update team set username='$username' where username='$primarykey'");
			$this->queryInTransaction("update student set username='$username', realName='$realName' where username='$primarykey'");
			$this->queryInTransaction('set foreign_key_checks=1');

			if($admin == 'true'){
				$this->queryInTransaction("insert ignore into admin values('$username')");
			}else{
				$this->queryInTransaction("delete from admin where username='$primarykey'");
			}
			return $this->endTransaction();
		}

		public function destroyStudent($username)
		{
			$this->beginTransaction();
			$this->queryInTransaction('set foreign_key_checks=0');
			$this->queryInTransaction("delete from team where username='$username'");
			$this->queryInTransaction("delete from student where username='$username'");
			$this->queryInTransaction("delete from admin where username='$username'");
			$this->queryInTransaction('set foreign_key_checks=1');
			return $this->endTransaction();
		}

		public function resetPassword($username, $password)
		{
			$this->beginTransaction();
			$this->queryInTransaction("update student set password='$password' where username='$username'");
			return $this->endTransaction();
		}

		public function createProject($projectName)
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into project values('$projectName') on duplicate key update name='$projectName'");
			return $this->endTransaction();
		}

		public function destroyProject($projectName)
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into project values('$projectName') on duplicate key update name='$projectName'");
			return $this->endTransaction();
		}

		

		public function createTeam($team)	
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into team values");
		}

		public function destroyTeam($teamid)
		{
			
		}
	}
 ?>