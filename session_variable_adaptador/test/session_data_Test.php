<?php
use session_variable_adaptador\session_variable_adaptador;



class session_data_Test extends PHPUnit\Framework\TestCase {

	function test_get(){
	    $session = new session_variable_adaptador();
		$_SESSION['sarasa'] = 'palomon';
		$this->assertEquals( "palomon", $session->get("sarasa") );
	}

	function test_set(){
	    $session = new session_variable_adaptador();
		$session->set( 'sarasa', 'palomon' );
		$this->assertEquals( "palomon", $_SESSION['sarasa'] );
		$session->unset( 'sarasa' );
	}

	function test_get_fail(){
	    $session = new session_variable_adaptador();
		$this->assertEquals( "", $session->get( "sarasax" ) ); 
	}
	/*
	 * esta prueba dejo de funcionar por cuanto phpunit ahora tiene sesiones
	 * */	
	function test_get_fail2(){
	    $session = new session_variable_adaptador();
		$this->assertEquals( "", $session->get( "sarasa" ) ); 
	}
	
	
}

?>