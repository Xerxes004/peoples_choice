<?php 
	/**
	* 
	*/
	class StudentModel extends Model
	{
		public function getStudentByUsername($username)
		{
			$this->beginTransaction();

			$result = $this->queryInTransaction("select * from student where username='$username'");

			$row = mysqli_fetch_assoc($result);
			$student = new Student($row['username'], $row['realName'], $row['pwHash']);

			$this->endTransaction;

			return $student;
		}

		public function getStudents(){
			$this->beginTransaction();

			$result = $this->queryInTransaction("select * from student");

			$students = [];
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($students, Student::fullStudent($row['username'], $row['realName'], $row['pwHash']));
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

		public static function fullStudent($username, $realName, $pwHash)
		{
			$student = new Student();
			$student->username = $username;
			$student->realName = $realName;
			$student->pwHash = $pwHash;
			return $student;
		}
	}
?>