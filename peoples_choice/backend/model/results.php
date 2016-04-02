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
				seriesBarDistance: 5,
			  	stackBars: true,
			  	horizontalBars: true,
			  	onlyInteger: true,
			  	axisY: {
			  		offset: 150
			  	},
			  	axisX: {
			  		offset: 0,
      				labelInterpolationFnc: function (value, index) {
      					return index % 5 === 0 ? value : null;
      				}
    			},
			}).on('draw', function(data) {
			  	if(data.type === 'bar') {
			    	data.element.attr({
			      		style: 'stroke-width: 20px'
				    });
				  }
			}";

		return array('json' => $jsonData, 'students' => $students);
	}
}
?>
