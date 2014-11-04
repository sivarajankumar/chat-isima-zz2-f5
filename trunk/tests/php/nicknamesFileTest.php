<?php

require_once '/../../php/nicknamesFile.php';


class NicknamesFileTest extends PHPUnit_Framework_TestCase
{
	function testAddNickname()
	{
		$nickname = "test1";
		addNickname($nickname);
		$this->assertTrue( nicknameExists($nickname) );
	}
	
	function testRemoveNickname()
	{
		$nickname = "test2";
		addNickname($nickname);
		removeNickname($nickname);
		$this->assertFalse( nicknameExists($nickname) );
	}
}

?>