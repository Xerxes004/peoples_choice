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
						}else{
							echo '{"login":"false"}';
						}
						break;
					case 'LOGOUT':
						session_unset();
						session_destroy();
						break;
					case "CREATE_STUDENT":
						$am = new AdminModel();
						$success = $am->createStudent($_POST['username'], $_POST['realName'], $_POST['pwHash'], $_POST['admin'])?'true':'false';
						echo(json_encode(array("CREATE_STUDENT"=>$success)));
						break;
					case 'DESTROY_STUDENT':
						$am = new AdminModel();
						$success = $am->destroyStudent($_POST['username']);
						echo(json_encode(array("DESTROY_STUDENT"=>$success)));
						break;

					case 'UPDATE_STUDENT':
						$am = new AdminModel();
						$success = $am->updateStudent($_POST['username'], $_POST['realName'], $_POST['admin'], $_POST['primarykey'])?'true':'false';
						//echo("'UPDATE_STUDENT':'$success'");
						echo(json_encode(array("UPDATE_STUDENT"=>$success)));
						break;
					case 'RESET_PASSWORD':
						$am = new AdminModel();
						$am->resetPassword($_POST['username'], $_POST['pwHash']);
						break;
					case 'CREATE_PROJECT':
					case 'DESTROY_PROJECT':
					case 'CREATE_TEAM':
					case 'DESTROY_TEAM':
					break;
					default:
						# code...
						break;
				}
				
				break;

			case 'GET':
				switch ($_GET['action']) {
					case 'data':
						# code...
						break;
					case 'page':
					default:
						switch($_GET['page'])
						{
							case 'project_results':
								$model = new ResultsPage();
								$data = $model->getResultsData($_GET['proj']);
								$page = new View('results.php');
								$page->display($data);
								break;

							case 'admin':
								if($_SESSION['logged-in'] && $_SESSION['isAdmin']){
									$model = new AdminModel();
									$data = $model->getAdminData();
									$page = new View('admin.php');
									$page->display($data);
									break;
								}
							case 'peoples_choice':
							default:
								$model = new PeoplesChoiceModel();
								$data = $model->getPeoplesChoiceData();
								$page = new View('peoples_choice.php');
								$page->display($data);
								break;
						}
						break;
				}
				
		}
		mysqli_close($_SESSION['db']);
		unset($_SESSION['db']);
	}
}

?>