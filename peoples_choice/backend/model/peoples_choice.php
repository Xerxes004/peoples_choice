<?php
	require('backend/model/model.php');

	class PeoplesChoiceModel extends Model{
		public function getPeoplesChoiceData(){
			$sm = new StudentModel();
			$students = $sm->getStudents();

			$p = new ProjectModel();
			$projects = $p->getProjects();

			return array("students" => $students, "projects"=>$projects);
		}
		
	}