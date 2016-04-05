<?php

class ResultsPage extends Model
{
	public function getResultsData($proj)
	{
		$vm = new VoteModel();
		$votes = $vm->getAllVotesForProject($proj);
		$tm = new TeamModel();
		$teams = $tm->getTeamsForProject($proj);
		$sm = new StudentModel();
		$students = $sm->getStudents();

		$fi = [];
		$se = [];
		$th = [];
		$na = [];
		foreach ($teams as $team) {
			$id = $team->id;
			$tmp = '';
			foreach ($team->members as $member) {
				$tmp .= $member . '<br />';
			}
			array_push($na, $tmp);
			unset($tmp);
			$vote = $votes[$id];
			array_push($fi, $vote->first);
			array_push($se, $vote->second);
			array_push($th, $vote->third);
		}
		$data['series'] = array($th, $se, $fi);
		$data['labels'] = $na;

		$jsonData = json_encode($data);

		$jsonData .= ",{
			  	stackBars: true,
			  	horizontalBars: true,
			  	axisX: {
			  		onlyInteger: true
			  	},
			  	axisY: {
			  		offset: 150,
			  		onlyInteger: true
			  	},
			}).on('draw', function(data) {
			  	if(data.type === 'bar') {
			    	data.element.attr({
			      		style: 'stroke-width: 20px'
				    });
				  }
			}";

		return array('json' => $jsonData, 'students' => $students, 'teams' => $teams);
	}
}
?>
