<?php

class View
{
	public $page_view = "";

	public function __construct($view_path)
	{
		$this->page_view = $view_path;
	}

	public function display($data)
	{
		require('head.php');
		require('header.php');

		include($this->page_view);

		require('footer.php');
	}
}

?>