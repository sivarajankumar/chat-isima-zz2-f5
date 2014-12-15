<?php

require_once '/../../php/messagesManager.php';


class messagesManagerTests extends PHPUnit_Framework_TestCase
{	
	protected $messagesManager;
	
	protected function setUp()
	{
		$this->messagesManager = new MessagesManager(__DIR__ . "/datas/messages.json");
	}
	
	protected function tearDown()
	{
		unlink(__DIR__ . "/datas/messages.json");
	}
	
	function testAddMessage()
	{
		$owner		= "test1";
		$receiver	= "test2";
		$message	= "message";
		$this->messagesManager->addMessage($owner, $receiver, $message);
		$this->assertEquals( $this->messagesManager->getMessages($receiver)[0]->message, $message );
	}
	
	function testAddMessageMultiUsers()
	{
		$owner		= "test1";
		$receiver	= "test2";
		$message	= "message";
		$this->messagesManager->addMessage($owner, $receiver, $message);
		
		$owner2		= "test3";
		$receiver2	= "test4";
		$message2	= "message2";
		$this->messagesManager->addMessage($owner2, $receiver2, $message2);
		
		$msg1	= $this->messagesManager->getMessages($receiver);
		$msg2	= $this->messagesManager->getMessages($receiver2);
		
		if( ($msg1[0]->message == $message) && ($msg2[0]->message == $message2) )
		{
			$this->assertTrue(true);
		}
		else 
		{
			$this->assertTrue(false);
		}
	}
	
	function testAddMultiMessages()
	{
		$owner		= "test1";
		$receiver	= "test2";
		$message	= "message";
		$message2	= "message2";
		$this->messagesManager->addMessage($owner, $receiver, $message);
		$this->messagesManager->addMessage($owner, $receiver, $message2);
		$this->assertCount(2, $this->messagesManager->getMessages($receiver));
	}
	
	function testRemoveMessages()
	{
		$owner		= "test1";
		$receiver	= "test2";
		$message	= "message";
		$message2	= "message2";
		
		$this->messagesManager->addMessage($owner, $receiver, $message);
		$this->messagesManager->addMessage($owner, $receiver, $message2);
		
		$this->messagesManager->removeMessages($receiver);
		
		$this->assertCount(0, $this->messagesManager->getMessages($receiver));
	}
}

?>
