<?php
use session_start_adaptador\session_start_adaptador;
use session_variable_adaptador\session_variable_adaptador;

/*
 * la idea de esta clase: encapsular session_start()
 * por eso cada prueba debe correrse en un proceso aparte
 * para no pisarse entre ellas
 * 
 */
class session_start_adaptador_test extends PHPUnit\Framework\TestCase {
	
    function mysetup( $evaluar )  {
        $session_user = new session_start_adaptador();
        $session_user->iniciar();
        $actual = $evaluar( $session_user );
        $session_user->terminar();
        return $actual;
    }
    
    /**
     * @runInSeparateProcess
     */
	function test_session_start(){
	    $actual = $this->mysetup( function( $session ) {
	        return $session->estado();
	    }   );

		$this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
	}


	
	/**
	 * @runInSeparateProcess
	 */
	function test_unset_destroy(){
	        
	    $session_user = new session_start_adaptador();
	    
	    $session_user->iniciar();
	    
		// $session_user->unset();
		$session_user->terminar();
		
		$this->assertEquals( PHP_SESSION_NONE, $session_user->estado() );
	}
	

	
	
}

?>