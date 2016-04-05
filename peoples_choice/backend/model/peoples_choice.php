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
			$grades = array();

			$first_place_votes = 0;
			$first_place_users = array();
			$second_place_votes = 0;
			$second_place_users = array();
			$third_place_votes = 0;
			$third_place_users = array();

			// for every project, get a number of votes for every team
			foreach ($projects as $project) {
				$votesForProject = $v->getAllVotesForProject($project->name);
				$teams = $t->getTeamsForProject($project->name);
				// for every team, get a number of votes for every user
				#echo $project->name."<hr />";
				foreach ($teams as $team) {
					$votesForTeam = $votesForProject[$team->id];
					#echo $t->printTeamMembers($team->members);
					#echo "Total votes $votesForTeam->total<br />";

					// then associate project with votes with user
					foreach ($team->members as $student) {
						$studentVotes[$project->name][$student] = $votesForTeam->total;

						if ($votesForTeam->total > $first_place_votes) {
							#$third_place_votes = $second_place_votes;
							$third_place_users = $second_place_users;

							#$second_place_votes = $first_place_votes;
							$second_place_users = $first_place_users;

							#$first_place_votes = $votesForTeam->total;
							array_push($first_place_users, $student);
						}
					}
				}
				$grades[$project->name]['first'] = $first_place_users;
				echo '<br />first :';
				print_r($first_place_users);
				$grades[$project->name]['second'] = $second_place_users;
				echo '<br />second :';
				print_r($second_place_users);
				$grades[$project->name]['third'] = $third_place_users;
				echo '<br />third :';
				print_r($third_place_users);
				break;
			}

			// whichever user has the most votes for a project wins, etc.
			
			return array("students" => $students, "projects"=>$projects, "grades"=>$grades);
		}
		
	}