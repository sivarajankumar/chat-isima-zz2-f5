<?php
	require 'nicknamesFile.php';
	
	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		removeNickname($_SESSION['nickname']);
		unset($_SESSION['nickname']);
	}
?>