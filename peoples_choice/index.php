<?php 
	if (!isset($_SESSION['logged_in']))
	{
		session_start();
		$_SESSION['logged_in'] = false;
		$_SESSION['state'] = 'peoples_choice';
	}

	require('backend/controller/controller.php');

	$controller = new Controller();
	$controller->renderPage();
?>