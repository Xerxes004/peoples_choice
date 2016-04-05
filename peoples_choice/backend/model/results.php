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

		print_r($teams);

		$fi = [];
		$se = [];
		$th = [];
		$na = [];
		foreach ($teams as $team) {
			$id = $team->id;
			$tmp = '';
			foreach ($team->members as $member) {
				$tmp .= $member . ' ';
			}
			array_push($na, $tmp);
			unset($tmp);
			$vote = $votes[$id];
			array_push($fi, $vote->first);
			array_push($se, $vote->second);
			array_push($th, $vote->third);
		}

		$mymembers = json_encode($na);
		$myfirst = '['.implode(',', $fi).']';
		$mysecond = '['.implode(',',$se).']';
		$mythird = '['.implode(',',$th).']';
		$chartData = "chart: {
            type: 'bar'
        },
        title: {
            text: 'Peoples Choice Results'
        },
        xAxis: {
            categories: $mymembers,
        	allowDecimals: false
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Votes'
            },
        	allowDecimals: false
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'First',
            data: $myfirst
        }, {
            name: 'Second',
            data: $mysecond
        }, {
            name: 'Third',
            data: $mythird
        }]";

		return array('json' => $jsonData, 'students' => $students, 'highcharts'=>$chartData);
	}
}
?>
