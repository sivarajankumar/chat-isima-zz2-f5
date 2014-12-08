<?php

	require 'messagesManager.php';

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		echo json_encode(getMessages($_SESSION['nickname']));
	}

?>