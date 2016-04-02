<?php 
	class Team extends Model{
		private $project;
		private $members;
		
		public static function project($project){
			$team = new Team();
			$team->project = $project;
			return $team;
		}

		public static function members($members){
			$team = new Team();
			$team->members = $members;
			return $team;
		}

		public static function fullTeam($project, $members)
		{
			$team = new Team();
			$team->project = $project;
			$team->members = $members;
			return $team;
		}

		public function createInDB()
		{		
			$this->beginTransaction();

			# get the next id
			$result = $this->queryInTransaction('select coalesce(max(implementationID), 0) miplid from implementation');
			
			# create the next implementation
			$miplid = mysqli_fetch_assoc($result)['miplid'] + 1;
			$this->queryInTransaction("insert into implementation values($miplid)");

			# Add the users to the implementation
			$query = 'insert into team values';
			foreach ($this->members as $member) {
				$query .= "('$member', '$this->project', $miplid),";
			}
			$query = rtrim($query, ",");
			$this->queryInTransaction($query);

			# End the transaction
			return $this->endTransaction();
		}

		public function getTeamsForProject($project)
		{
			$this->beginTransaction();
			$result = $this->queryInTransaction("select distinct implementationID from team where projectName='$project'");
			
			$teams = [];
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['implementationID'];
				$teamQuery = $this->queryInTransaction("select realName from team t, student s where t.username = s.username and implementationID=$id");
				$team = [];
				while($r = mysqli_fetch_assoc($teamQuery)){
					array_push($team, $r['realName']);
				}
				array_push($teams, $team);
				unset($team);
			}
			
			$this->endTransaction();

			return $teams;
		}

		public function queryDB()
		{
			# code...
		}
	}
 ?>
