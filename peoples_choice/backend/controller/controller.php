<?php

require('backend/view/view.php');
require('backend/model/login.php');
require('backend/model/peoples_choice.php');

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
						if ($_POST['username'] && $_POST['password'])
						{
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
						$model = new PeoplesChoice();
						$users = $model->getPeoplesChoiceData();
						$page = new View('peoples_choice.php');
						$page->display($users);
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