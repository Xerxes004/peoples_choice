<?php

	function printme($tag, $data){
		echo "$tag: ";
		print_r($data);
		echo "<br>";
	}
	/**
	* 
	*/
	class VoteModel extends Model
	{
		public function getAllVotesForProject($project)
		{
			$this->beginTransaction();
			$teamModel = new TeamModel();
			$teams = $teamModel->getTeamsForProject($project);

			
			$q = '';
			foreach ($teams as $team) {
				$project = $team->project;
				$teamid = $team->id;
				$q .= "select * from
					(select count(value) third
					from vote
					where projectName='$project'
					and implementationID=$teamid
					and value=1) t1,
					(select count(value) second
					from vote
					where projectName='$project'
					and implementationID=$teamid
					and value=2)t2,
					(select count(value) first
					from vote
					where projectName='$project'
					and implementationID=$teamid
					and value=3)t3,
					(select coalesce(sum(value),0) total
					from vote
					where projectName='$project'
					and implementationID=$teamid)t4
					union ";
			}
			
			$q = rtrim($q, 'union ');

			$votes = [];
			$voteResult = $this->queryInTransaction($q);
			foreach ($teams as $team) {
				$vote = mysqli_fetch_assoc($voteResult);
				$votes[$team->id] = Vote::score($vote['first'], $vote['second'], $vote['third'], $vote['total']);
			}
			return $votes;
		}
	}

	/**
	* 
	*/
	class Vote
	{
		public $first;
		public $second;
		public $third;
		public $total;
		public $teamid;
		public $username;

		public static function score($first, $second, $third, $total)
		{
			$v = new Vote();
			$v->first = $first;
			$v->second = $second;
			$v->third = $third;
			$v->total = $total;
			return $v;
		}
	}
 ?>
