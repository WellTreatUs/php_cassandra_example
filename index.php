<?php
	error_reporting(E_ALL);
	
	require 'config.php';
	$controller = new Controller();
	$controller->dispatch($_GET['perform']);
?>