<?php 
	/**
	* 
	*/
	class ProjectModel extends Model
	{

		public function getProjects()
		{
			$this->beginTransaction();

			$result = $this->queryInTransaction("select * from wkjs_project");

			$projects = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$projects[$row['name']] = Project::fullProject($row['name'], $row['status']);
			}

			$this->endTransaction();

			return $projects;
		}
	}

	/**
	* 
	*/
	class Project
	{
		public $name;
		public $status;

		static public function name($name){
			$p = new Project();
			$p->name = $name;
			return $p;
		}

		static public function status($status)
		{
			$p = new Project();
			$p->status = $status;
			return $p;
		}

		static public function fullProject($name, $status)
		{
			$p = new Project();
			$p->name = $name;
			$p->status = $status;
			return $p;
		}
	}
?>