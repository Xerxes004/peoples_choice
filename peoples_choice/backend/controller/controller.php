<?php

require('backend/view/view.php');
require('backend/model/login.php');

class Controller
{
	public function renderPage()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				if ($_POST['username'] && $_POST['password'])
				{
					$_SESSION['db'] = mysqli_connect("192.168.1.122", 'joel', 'password', 'app') or die("DB Connection Error");
					$login = new Login();
					$login->validateUser($_POST['username'], $_POST['password']);
					mysqli_close($_SESSION['db'])
					unset($_SESSION['db']);
				}
				break;

			case 'GET':
				switch($_GET['page'])
				{
					case 'peoples_choice':
					default:
						$page = new View('peoples_choice.php');
						$page->display();
						break;
				}
				break;

			default:
				break;			
		}
	}
}

?>