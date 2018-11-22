<?php
use session_variable_adaptador\session_variable_adaptador;

class session_variable_adaptador_Test extends PHPUnit\Framework\TestCase {

    /* esta es una prueba de caja blanca que no tendria que existir.
     */
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
	
	/* esta prueba dejo de funcionar por cuanto phpunit 7.* ahora tiene sesiones
	 * */	
	function test_get_fail2(){
	    $session = new session_variable_adaptador();
		$this->assertEquals( "", $session->get( "sarasa" ) ); 
	}
	
}

?>