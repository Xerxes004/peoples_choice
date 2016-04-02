<?php 
	class TeamModel extends Model{

		public function create($team)
		{		
			$this->beginTransaction();

			# get the next id
			$result = $this->queryInTransaction('select coalesce(max(implementationID), 0) miplid from implementation');
			
			# create the next implementation
			$miplid = mysqli_fetch_assoc($result)['miplid'] + 1;
			$this->queryInTransaction("insert into implementation values($miplid)");

			$project = $team->project;
			# Add the users to the implementation
			$query = 'insert into team values';
			foreach ($team->members as $member) {
				$query .= "('$member', '$project', $miplid),";
			}
			$query = rtrim($query, ",");

			$this->queryInTransaction($query);

			# End the transaction
			return $this->endTransaction();
		}

		public function destroy($id)
		{
			$this->beginTransaction();
			$this->queryInTransaction("delete from team where implementationID=$id");
			$this->queryInTransaction("delete from implementation where implementationID=$id");
			$this->queryInTransaction("set foreign_key_checks=0");
			$this->queryInTransaction("update implementation set implementationID = implementationID-1 where implementationID > $id");
			$this->queryInTransaction("update team set implementationID=implementationID-1 where implementationID > $id");
			$this->queryInTransaction("set foreign_key_checks=1");
			$this->endTransaction();
		}

		public function getTeamsForProject($project)
		{
			$this->beginTransaction();
			$result = $this->queryInTransaction("select distinct implementationID from team where projectName='$project'");
			
			$teams = [];
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['implementationID'];
				$teamQuery = $this->queryInTransaction("select realName from team t, student s where t.username = s.username and implementationID=$id");
				$members = [];
				while($r = mysqli_fetch_assoc($teamQuery)){
					array_push($members, $r['realName']);
				}
				array_push($teams, Team::fullTeam($id, $members, $project));
				unset($members);
			}
			
			$this->endTransaction();

			return $teams;
		}

		public function queryDB()
		{
			# code...
		}
	}

	/**
	* 
	*/
	class Team
	{
		public $project;
		public $teamid;
		public $members;

		public static function membersProject($project, $members)
		{
			$r = new Team();
			$r->project = $project;
			$r->members = $members;
			return $r;	
		}

		public function fullTeam($teamid, $project, $members)
		{
			$t = new Team();
			$t->$teamid = $teamid;
			$t->project = $project;
			$t->members = $members;
			return $t;
		}
		
	}
 ?>