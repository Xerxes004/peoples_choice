<?php

abstract class Model
{
	private $trnsFlag;
	private $conn;

	public function beginTransaction()
	{
		# get connection to db
		$this->conn = $_SESSION['db'];

		# begin the transaction
		$this->trnsFlag = true;
		mysqli_autocommit($this->conn, false);
	}

	public function endTransaction()
	{
		if($this->trnsFlag){
			mysqli_commit($this->conn);
		}else{
			mysqli_rollback($this->conn);
		}

		mysqli_autocommit($this->conn, true);
		return $this->trnsFlag;
	}

	public function queryInTransaction($query)
	{
		$result = mysqli_query($this->conn, $query);
		$this->trnsFlag = $this->trnsFlag && $result;
		//echo($query.' '. ($result?'true':'false'));
		return $result;
	}
}
?>