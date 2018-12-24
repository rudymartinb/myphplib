<?php
use session_variable_adaptador\session_variable_adaptador;

class session_variable_adaptador_Test extends PHPUnit\Framework\TestCase {
    // estas pruebas trabajan sobre $_SESSION

    /**
     * @runInSeparateProcess
     */
	function test_set_get(){
	    $session = new session_variable_adaptador();
		$_SESSION['sarasa'] = 'palomon';
		$this->assertEquals( "palomon", $session->get("sarasa") );
	}

	/**
	 * @runInSeparateProcess
	 */
	 function test_set_unset(){
	    $session = new session_variable_adaptador();
		$session->set( 'sarasa', 'palomon' );
		$clave = 'sarasa';
		// $this->assertEquals( "palomon", $_SESSION['sarasa'] );
		$session->unset( 'sarasa' );
		
		$this->assertFalse( array_key_exists( $clave, $_SESSION ) );
	}

	/**
	 * @runInSeparateProcess
	 */
	function test_get_fail(){
	    $session = new session_variable_adaptador();
	    // variable nunca usada
		$this->assertEquals( "", $session->get( "sarasax" ) ); 
	}
	
	/**
	 * @runInSeparateProcess
	 */
	function test_get_fail2(){
	    $session = new session_variable_adaptador();
	    // variable usada en prueba anterior
	    // si eliminamos el @runInSeparateProcess 
	    // podria dar error 
		$this->assertEquals( "", $session->get( "sarasa" ) ); 
	}
	
}

?>