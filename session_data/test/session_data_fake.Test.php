<?php
use session_data\session_data_fake;

class session_data_fake_test extends PHPUnit\Framework\TestCase {
	
	function test_set_get(){
		$session = new session_data_fake();
		$session->set( 'sarasa', 'palomon' );
		$this->assertEquals( "palomon", $session->get("sarasa") );
	}

	function test_fail(){
		$session = new session_data_fake();
		$this->assertEquals( "", $session->get("sarasa") );
	}

}

?>