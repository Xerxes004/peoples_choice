<?php 
	/**
	* 
	*/
	class StudentModel extends Model
	{
		public function getStudentByUsername($username)
		{
			$this->beginTransaction();

			$result = $this->queryInTransaction("select * from wkjs_student where username='$username'");

			$row = mysqli_fetch_assoc($result);
			$student = new Student($row['username'], $row['realName'], $row['pwHash']);

			$this->endTransaction;

			return $student;
		}

		public function getStudents(){
			$this->beginTransaction();
			$q = "select s.username, realName, pwHash, coalesce(a.username, 'false') isAdmin
			 from wkjs_student s left join wkjs_admin a on s.username=a.username order by realName asc";

			$result = $this->queryInTransaction($q);

			$students = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$isAdmin = false;
				if($row['isAdmin'] != 'false'){
					$isAdmin = true;
				}
				$students[$row['realName']] = Student::fullWAdmin($row['username'], $row['realName'], $row['pwHash'], $isAdmin);
			}
			$this->endTransaction;

			return $students;
		}
	}

	/**
	* 
	*/
	class Student
	{
		public $username;
		public $realName;
		public $pwHash;
		public $isAdmin;
		public static function fullStudent($username, $realName, $pwHash)
		{
			$student = new Student();
			$student->username = $username;
			$student->realName = $realName;
			$student->pwHash = $pwHash;
			return $student;
		}

		public static function fullWAdmin($username, $realName, $pwHash, $isAdmin)
		{
			$student = new Student();
			$student->username = $username;
			$student->realName = $realName;
			$student->pwHash = $pwHash;
			$student->isAdmin = $isAdmin;
			return $student;
		}

		public function setAdmin($isAdmin)
		{
			$this->isAdmin = $isAdmin;
		}
	}
?>