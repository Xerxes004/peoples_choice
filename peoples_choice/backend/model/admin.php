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
			$this->queryInTransaction("update student set pwHash='$password' where username='$username'");
			return $this->endTransaction();
		}

		public function createProject($projectName, $status)
		{
			$this->beginTransaction();
			$this->queryInTransaction("insert into project values('$projectName', '$status') on duplicate key update name='$projectName'");
			return $this->endTransaction();
		}

		public function updateProject($projectName, $status)
		{
			$this->beginTransaction();
			$this->queryInTransaction("update project set status='$status' where name='$projectName'");
			return $this->endTransaction();
		}

		public function destroyProject($projectName)
		{
			$this->beginTransaction();
			$this->queryInTransaction("delete from team where projectName='$projectName'");
			$this->queryInTransaction("delete from project where name='$projectName'");
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
			$this->queryInTransaction("delete from implementation where implementationID in (select implementationID from team where projectName='$project')");
			$this->queryInTransaction("delete from team where projectName='$project'");
			$this->queryInTransaction("delete from vote where project='$project'");
			$this->queryInTransaction("delete from writeIn where project=$project");
			return $this->endTransaction();
		}

		public function castBallot($vote)
		{
			$this->beginTransaction();
			$query = 'insert into vote values("'. $vote->voter . '","' . $vote->project . '",' . $vote->first . ', 3), ("'. $vote->voter . '","' . $vote->project . '",' . $vote->second . ', 2), ("'. $vote->voter . '","' . $vote->project . '",' . $vote->third . ', 1)';
			echo $query;
			$this->queryInTransaction($query);

			$this->endTransaction();
		}
	}
 ?>