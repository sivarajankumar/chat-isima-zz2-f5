﻿<?php
	require 'usersManager.php';

	session_start();
	
	// Set the HTTP header to UTF-8 and Json data
	header('Content-type: application/json; charset=UTF-8');
	
	$errors	= array();	// array to hold validation errors
	$data	= array();	// array to pass back data
	
	$usersManager = new UsersManager( getUsersFilePath() );
	
	// If no data are send, we return an error
	if( ! isset($_POST['nickname']) || empty($_POST['nickname']) )
	{
		$data['success'] = false;
		$errors['nickname'] = 1;	
	}
	else
	{
		$nickname = $_POST['nickname'];
		
		// add new user
		if( ! $usersManager->usersExists($nickname) )
		{
			if( ! isset($_POST['rememberMe']) || empty($_POST['rememberMe']) )
			{
				$rememberMe = false;
			}
			else
			{
				$password = password_hash($nickname, PASSWORD_DEFAULT);
				$rememberMe = $password;
				$data['password'] = $password;
			}
		
			$_SESSION['nickname'] = $nickname;
			
			$usersManager->addUsers($nickname, $rememberMe);
			
			$data['success'] = true;
		}
		// reconnection
		else
		{
			if( isset($_POST['password']) && ! empty($_POST['password']) )
			{
				
				if( $usersManager->verifyPassword($nickname, $_POST['password']) )
				{
					$data['success'] = true;
					$data['password'] = $_POST['password'];
					
					$_SESSION['nickname'] = $nickname;
				}
				else 
				{
					$data['success'] = false;
				}
			}
			else
			{
				$data['success'] = false;
				$data['errors'] = array('nickname' => 2);
			}
		}
	}

	// return all our data to an AJAX call
	echo json_encode($data);
?>
