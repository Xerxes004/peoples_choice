<?php

require('backend/view/view.php');
require('backend/model/login.php');
require('backend/model/peoples_choice.php');
//require('backend/model/model.php');
require('backend/model/team.php');
require('backend/model/student.php');
require('backend/model/project.php');
require('backend/model/results.php');
require('backend/model/vote.php');
require('backend/model/admin.php');

class Controller
{
	public function renderPage()
	{
		$_SESSION['db'] = mysqli_connect("163.11.162.204", 'joel', 'password', 'app') or die("DB Connection Error");

		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				switch ($_POST['action']) {
					case 'LOGIN':
						if ($_POST['username'] && $_POST['password']){
							$login = new Login();
							$login->validateUser($_POST['username'], $_POST['password']);	
						}
						break;
					case 'LOGOUT':
						session_unset();
						session_destroy();
						break;
					default:
						# code...
						break;
				}
				
				break;

			case 'GET':
				switch($_GET['page'])
				{
					case 'peoples_choice':
					default:
						$model = new PeoplesChoiceModel();
						$data = $model->getPeoplesChoiceData();
						$page = new View('peoples_choice.php');
						$page->display($data);
						break;

					case 'project_results':
						$model = new ResultsPage();
						$data = $model->getResultsData($_GET['proj']);
						$page = new View('results.php');
						$page->display($data);
						break;

					case 'admin':
						#$model = new AdminPage();
						#$data = $model->getAdminData();
						$page = new View('admin.php');
						$page->display('no data for admin yet');
						break;
				}
				break;

			default:
				break;			
		}
		mysqli_close($_SESSION['db']);
		unset($_SESSION['db']);
	}
}

?>