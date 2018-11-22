<?php
use session_variable_adaptador\session_variable_adaptador_fake;

class session_data_fake_test extends PHPUnit\Framework\TestCase {
	
	function test_set_get(){
	    $session = new session_variable_adaptador_fake();
		$session->set( 'sarasa', 'palomon' );
		$this->assertEquals( "palomon", $session->get("sarasa") );
	}

	function test_fail(){
	    $session = new session_variable_adaptador_fake();
		$this->assertEquals( "", $session->get("sarasa") );
	}

}

?>