<?php
	session_start();
	require('functions.php');	
	require('models.php');
	require('services.php');
	require('controllers.php');
	
	// Configure cassandra nodes
	AddressBookService::addNode('localhost', 9160);
	AddressBookService::connect();
?>