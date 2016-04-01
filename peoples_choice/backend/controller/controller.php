<?php

require('backend/view/view.php');

class Controller
{
	public function renderPage()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
				if ($_POST['username'] && $_POST['password'])
				{
					echo 'connect to db';
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