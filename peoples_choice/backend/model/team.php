<?php 
	class TeamModel extends Model{

		public function createTeam($team)
		{		
			$this->beginTransaction();

			# get the next id
			$result = $this->queryInTransaction('select coalesce(max(implementationID), 0) miplid from wkjs_implementation');

			# create the next implementation
			$miplid = mysqli_fetch_assoc($result)['miplid'] + 1;
			$this->queryInTransaction("insert into wkjs_implementation values($miplid)");

			$project = $team->project;
			# Add the users to the implementation
			$query = 'insert into wkjs_team values';
			foreach ($team->members as $member) {
				$query .= "('$member', '$project', $miplid),";
			}
			$query = rtrim($query, ",");
			echo($query);
			$this->queryInTransaction($query);

			# End the transaction
			return $this->endTransaction();
		}

		public function destroy($id)
		{
			$this->beginTransaction();
			$this->queryInTransaction("delete from wkjs_team where implementationID=$id");
			$this->queryInTransaction("delete from wkjs_implementation where implementationID=$id");
			$this->queryInTransaction("set foreign_key_checks=0");
			$this->queryInTransaction("update wkjs_implementation set implementationID = implementationID-1 where implementationID > $id");
			$this->queryInTransaction("update wkjs_team set implementationID=implementationID-1 where implementationID > $id");
			$this->queryInTransaction("set foreign_key_checks=1");
			$this->endTransaction();
		}

		public function getTeamsForProject($project)
		{
			$this->beginTransaction();
			$result = $this->queryInTransaction("select distinct implementationID from wkjs_team where projectName='$project'");
			
			$teams = [];
			while($row = mysqli_fetch_assoc($result)){
				$id = $row['implementationID'];
				$teamQuery = $this->queryInTransaction("select realName from wkjs_team t, wkjs_student s where t.username = s.username and implementationID=$id");
				$members = [];
				while($r = mysqli_fetch_assoc($teamQuery)){
					array_push($members, $r['realName']);
				}
				array_push($teams, Team::all($project, $id, $members));
				unset($members);
			}
			
			$this->endTransaction();

			return $teams;
		}

		public function printTeamMembers($names) {
			foreach ($names as $name) {
				echo "\"$name\"";
			}
		}
	}

	/**
	* 
	*/
	class Team
	{
		public $project;
		public $id;
		public $members;

		public static function membersProject($project, $members)
		{
			$r = new Team();
			$r->project = $project;
			$r->members = $members;
			return $r;	
		}

		public static function all($project, $id, $members)
		{
			$r = new Team();
			$r->project = $project;
			$r->id = $id;
			$r->members = $members;
			return $r;
		}
	}
 ?>
