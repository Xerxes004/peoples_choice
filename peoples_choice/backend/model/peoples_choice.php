<?php
	require('backend/model/model.php');

	class PeoplesChoiceModel extends Model{
		public function getPeoplesChoiceData(){
			$sm = new StudentModel();
			$students = $sm->getStudents();

			$p = new ProjectModel();
			$projects = $p->getProjects();

			// for every project, get a number of votes for every team
			// for every team, get a number of votes for every user
			// then associate project with votes with user
			// whichever user has the most votes for a project wins, etc.

			return array("students" => $students, "projects"=>$projects);
		}
		
	}