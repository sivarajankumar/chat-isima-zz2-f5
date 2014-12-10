<?php

require_once '/../../php/usersManager.php';


class NicknamesFileTest extends PHPUnit_Framework_TestCase
{	
	protected $usersManager;
	
	protected function setUp()
	{
		$this->usersManager = new UsersManager("tests/php/datas/users.json");
	}
	
	protected function tearDown()
	{
		unlink("tests/php/datas/users.json");
	}
	
	function testAddUser()
	{
		$nickname = "test1";
		$this->usersManager->addUsers($nickname, false);
		$this->assertTrue( $this->usersManager->usersExists($nickname) );
	}
	
	function testRemoveUser()
	{
		$nickname = "test2";
		$this->usersManager->addUsers($nickname, false);
		$this->usersManager->removeUsers($nickname);
		$this->assertFalse( $this->usersManager->usersExists($nickname) );
	}
	
	function testVerifyPassword()
	{ 
		$nickname = "testPassword";
		$password = "testPassword";
		$this->usersManager->addUsers($nickname, $password);
		$return = $this->usersManager->verifyPassword($nickname, $password);
		$this->assertTrue( $return );
	}
	
	function testGetAllUsers()
	{		
		for( $i=0; $i < 10; ++$i )
		{
			$this->usersManager->addUsers($i, false);
		}
		
		$array = $this->usersManager->getAllUsers();
		
		$this->assertCount(10, $array);
	}
}

?>