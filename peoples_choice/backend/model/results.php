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

		$first = [];
		$second = [];
		$third = [];
		$names = [];
		foreach ($teams as $team) {
			$id = $team->id;
			$tmp = '';
			foreach ($team->members as $member) {
				$tmp .= $member . ' ';
			}
			$tmp = trim($tmp);
			array_push($names, $tmp);
			unset($tmp);
			$vote = $votes[$id];
			array_push($first, $vote->first);
			array_push($second, $vote->second);
			array_push($third, $vote->third);
		}

		$mymembers = json_encode($names);
		$myfirst = '['.implode(',', $first).']';
		$mysecond = '['.implode(',',$second).']';
		$mythird = '['.implode(',',$third).']';
		$chartData = "chart: {
            type: 'bar'
        },
        title: {
            text: 'Peoples Choice Results'
        },
        xAxis: {
            categories: $mymembers
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Votes'
            }
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

		return array('json' => $jsonData, 'students' => $students, 'teams'=> $teams, 'highcharts'=>$chartData);
	}
}
?>
