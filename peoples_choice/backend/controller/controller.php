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
		$complete = true;
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
					$am = new AdminModel();
					switch ($_POST['action']) {
						case "CREATE_STUDENT":
							$success = $am->createStudent($_POST['username'], $_POST['realName'], $_POST['pwHash'], json_decode($_POST['admin']));
							echo(json_encode(array("CREATE_STUDENT"=>$success)));
							break;
						case 'DESTROY_STUDENT':
							$success = $am->destroyStudent($_POST['username']);
							echo(json_encode(array("DESTROY_STUDENT"=>$success)));
							break;
						case 'UPDATE_STUDENT':
							$success = $am->updateStudent($_POST['username'], $_POST['realName'], $_POST['admin'], $_POST['primarykey'])?'true':'false';
							echo(json_encode(array("UPDATE_STUDENT"=>$success)));
							break;
						case 'RESET_PASSWORD':
							$success = $am->resetPassword($_POST['username'], $_POST['pwHash']);
							echo(json_encode(array("RESET_PASSWORD"=>$success)));
							break;
						case 'CREATE_PROJECT':
							$success = $am->createProject($_POST['project'], 'closed');
							echo(json_encode(array("CREATE_PROJECT"=>$success)));
							break;
						case 'OPEN_PROJECT':
							$success = $am->updateProject($_POST['project'], 'open');
							echo(json_encode(array("OPEN_PROJECT"=>$success)));
							break;
						case 'CLOSE_PROJECT':
							$success  = $am->updateProject($_POST['project'], 'closed');
							echo(json_encode(array("CLOSE_PROJECT"=>$success)));
							break;
						case 'DESTROY_PROJECT':
							$success = $am->destroyProject($_POST['project']);
							echo(json_encode(array("DESTROY_PROJECT"=>$success)));
							break;
						case 'CREATE_TEAM':
							echo($_POST['team']);
							print_r(json_decode($_POST['team']));

							$members = json_decode($_POST['team']);
							echo($members->project);
							$success = $am->createTeam($members);
							break;
						case 'DESTROY_TEAM':
							$success = $am->clearTeamsForProject($_GET['project']);
							echo(json_encode(array("DESTROY_TEAM"=>$success)));
							break;
						case 'VOTE':
							$vote = json_decode($_POST['vote']);
							$success = $am->castBallot($vote);
							echo(json_encode(array("VOTE"=>$success)));
							print_r($vote);
							break;

						default:
							$complete = false;
						break;
					}
				}else{
					$complete = false;
				}
				if(!$complete){
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
							$_SESSION['isAdmin'] = false;
							$_SESSION['logged-in'] = false;
							session_unset();
							session_destroy();
							break;
						
						default:
							echo(json_encode(array($_POST['action']=>false)));
							break;
					}
				}
				break;

			case 'GET':
				switch ($_GET['action']) {
					case 'data':
						switch ($_GET['data']) {
							case 'TEAM':
								# code...
								break;
							
							default:
								# code...
								break;
						}
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