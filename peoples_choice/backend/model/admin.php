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
			$this->queryInTransaction("insert into wkjs_student values('$username', '$realName', '$pwHash')");

			if($admin){
				$this->queryInTransaction("insert into wkjs_admin values('$username')");
			}
			return $this->endTransaction();
		}

		public function updateStudent($username, $realName, $admin, $primarykey){
			$this->beginTransaction();
			$this->queryInTransaction('set foreign_key_checks=0');
			$this->queryInTransaction("update wkjs_team set username='$username' where username='$primarykey'");
			$this->queryInTransaction("update wkjs_student set username='$username', realName='$realName' where username='$primarykey'");
			$this->queryInTransaction('set foreign_key_checks=1');

			if($admin == 'true'){
				$this->queryInTransaction("insert ignore into wkjs_admin values('$username')");
			}else{
				$this->queryInTransaction("delete from wkjs_admin where username='$primarykey'");
			}
			return $this->endTransaction();
		}

		public function destroyStudent($username)
		{
			$this->beginTransaction();
			$this->queryInTransaction('set foreign_key_checks=0');
			$this->queryInTransaction("delete from wkjs_team where username='$username'");
			$this->queryInTransaction("delete from wkjs_student where username='$username'");
			$this->queryInTransaction("delete from wkjs_admin where username='$username'");
			$this->queryInTransaction('set foreign_key_checks=1');
			return $this->endTransaction();
		}

		public function resetPassword($username, $password)
		{
			$this->beginTransaction();
			$this->queryInTransaction("update wkjs_student set pwHash='$password' where username='$username'");
			return $this->endTransaction();
		}

		public function createProject($projectName, $status)
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into wkjs_project values('$projectName', '$status') on duplicate key update name='$projectName'");
			return $this->endTransaction();
		}

		public function updateProject($projectName, $status)
		{
			$this->beginTransaction();
			$this->queryInTransaction("update wkjs_project set status='$status' where name='$projectName'");
			return $this->endTransaction();
		}

		public function destroyProject($projectName)
		{
			$this->beginTransaction();
			$this->queryInTransaction("delete from wkjs_team where projectName='$projectName'");
			$this->queryInTransaction("delete from wkjs_project where name='$projectName'");
			return $this->endTransaction();
		}

		public function createTeam($team)	
		{

			$tm = new TeamModel();
			$tm->createTeam($team);
		}

		public function clearTeamsForProject($project)
		{
			echo($project);
			$this->beginTransaction();
			$this->queryInTransaction('set foreign_key_checks=0');
			$this->queryInTransaction("delete from wkjs_implementation where implementationID in (select implementationID from wkjs_team where projectName='$project')");
			$this->queryInTransaction("delete from wkjs_team where projectName='$project'");
			$this->queryInTransaction("delete from wkjs_vote where projectName='$project'");
			$this->queryInTransaction("delete from wkjs_writeIn where projectName='$project'");
			$this->queryInTransaction('set foreign_key_checks=1');
			return $this->endTransaction();
		}

		public function castBallot($vote)
		{
			$this->beginTransaction();
			$query = 'insert into wkjs_vote values("'. $vote->voter . '","' . $vote->project . '",' . $vote->first . ', 3), ("'. $vote->voter . '","' . $vote->project . '",' . $vote->second . ', 2), ("'. $vote->voter . '","' . $vote->project . '",' . $vote->third . ', 1)';
			echo $query;
			$this->queryInTransaction($query);

			$this->endTransaction();
		}
	}
 ?>