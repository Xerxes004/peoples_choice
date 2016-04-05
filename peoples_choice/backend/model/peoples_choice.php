<?php
	require('backend/model/model.php');

	class PeoplesChoiceModel extends Model{
		public function getPeoplesChoiceData(){
			$sm = new StudentModel();
			$students = $sm->getStudents();

			$p = new ProjectModel();
			$projects = $p->getProjects();

			$v = new VoteModel();
			$t = new TeamModel();
			$studentVotes = [];
			$grades = array(array(array()));

			// for every project, get a number of votes for every team
			foreach ($projects as $project) {
				$first_place_votes = 0;
				$first_place_users = array();
				$second_place_votes = 0;
				$second_place_users = array();
				$third_place_votes = 0;
				$third_place_users = array();

				$votesForProject = $v->getAllVotesForProject($project->name);
				$teams = $t->getTeamsForProject($project->name);
				
				// for every team, get a number of votes for every user
				foreach ($teams as $team) {
					$votesForTeam = $votesForProject[$team->id];
					
					// then associate project with votes with user
					foreach ($team->members as $student) {
						
						if ($votesForTeam->total != 0) {
							if ($votesForTeam->total > $first_place_votes) {

								$third_place_votes = $second_place_votes;
								$third_place_users = $second_place_users;

								$second_place_votes = $first_place_votes;
								$second_place_users = $first_place_users;

								$first_place_votes = $votesForTeam->total;
								$first_place_users = array();

								array_push($first_place_users, $student);

							} else if ($votesForTeam->total == $first_place_votes) {

								array_push($first_place_users, $student);

							} else if ($votesForTeam->total > $second_place_votes) {

								$third_place_votes = $second_place_votes;
								$third_place_users = $second_place_users;

								$second_place_votes = $votesForTeam->total;
								$second_place_users = array();

								array_push($second_place_users, $student);

							} else if ($votesForTeam->total == $second_place_votes) {

								array_push($second_place_users, $student);

							} else if ($votesForTeam->total > $third_place_votes) {

								$third_place_votes = $votesForTeam->total;
								$third_place_users = array();

								array_push($third_place_users, $student);

							} else if ($votesForTeam->total == $third_place_votes) {

								array_push($third_place_users, $student);

							}
						}
					}
				}

				$grades[$project->name]['first'] = $first_place_users;
				$grades[$project->name]['second'] = $second_place_users;
				$grades[$project->name]['third'] = $third_place_users;
			}

			// whichever user has the most votes for a project wins, etc.
			
			return array("students" => $students, "projects"=>$projects, "grades"=>$grades);
		}
		
	}