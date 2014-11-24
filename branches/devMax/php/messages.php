<?php

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		echo 'coucou ' . $_SESSION['nickname'];
	}
	else if( isset($_COOKIE['nickname']) )
	{
		echo 'COOKIE coucou ' . $_COOKIE['nickname'];
	}

	$data[success] = true;
	$data[message] = utf8_encode("les temps ont changes");
	echo json_encode($data);
?>