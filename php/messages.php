<?php

	require 'messagesManager.php';

	session_start();
	
	$data	= array();	// array to pass back data
	
	if( isset($_SESSION['nickname']) )
	{
		//echo json_encode(getMessages($_SESSION['nickname']));
	}
	
	if( ! isset($_POST['message']) || empty($_POST['message']) )
	{
		$data['success'] = false;
	}
	else $data['message'] = $_POST['message'];
	
	$data['success'] = true;
	
	addMessage($_SESSION['nickname'], null, $data['message']);
	
	echo json_encode($data);

?>