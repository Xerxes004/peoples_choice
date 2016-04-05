<?php

class ResultsPage extends Model
{
	public function getVoteData($proj)
    {
        $tm = new TeamModel();
        $teams = $tm->getTeamsForProject($proj);
        $vm = new VoteModel();
        $votes = $vm->getAllVotesForProject($proj);

        $first = [];
        $second = [];
        $third = [];
        foreach ($teams as $team) {
            $id = $team->id;
            $vote = $votes[$id];
            array_push($first, $vote->first*3);
            array_push($second, $vote->second*2);
            array_push($third, $vote->third*1);
        }
        return array($first, $second, $third);
    }

    public function studentHasVoted($username, $project){
        $this->beginTransaction();
        $result = mysqli_fetch_assoc($this->queryInTransaction("select count(*) cast from wkjs_vote where projectName='$project' and username='$username'"));
        return $result['cast'] > 0;
    }

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
				$tmp .= $member . '<br />';
			}
			$tmp = trim($tmp);
			array_push($names, $tmp);
			unset($tmp);
			$vote = $votes[$id];
			array_push($first, $vote->first*3);
			array_push($second, $vote->second*2);
			array_push($third, $vote->third);
		}


		$mymembers = json_encode($names);

		$myfirst = '['.implode(',', $first).']';
		$mysecond = '['.implode(',',$second).']';
		$mythird = '['.implode(',',$third).']';

		$chartData = "
        chart : {
            type: 'bar',
            animation: false,
            events : {
                load : function(){
                    var s1 = this.series[0];
                    var s2 = this.series[1];
                    var s3 = this.series[2];
                setInterval(function(){
                    $.get('./', {action:'data', data:'GET_VOTES', project:'$proj'}, function(data){
                            var results = JSON.parse(data);
                            s3.setData(results[0], true);
                            s2.setData(results[1], true);
                            s1.setData(results[2], true);
                    });
                }, 3000);}
            }
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
            name: 'Third',
            data: $mythird,
            color: '#cd7f32'
        
        }, {
            name: 'Second',
            data: $mysecond,
            color: '#c0c0c0'
        }, {
            name: 'First',
            data: $myfirst,
            color: '#ffd700'
        }]";

		return array('json' => $jsonData, 'students' => $students, 'teams'=> $teams, 'highcharts'=>$chartData);
	}
}
?>
