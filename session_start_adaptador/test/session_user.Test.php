<?php
use session_start_adaptador\session_start_adaptador;
/*
 * la idea de esta clase: encapsular session_start()
 * por eso cada prueba debe correrse en un proceso aparte
 * para no pisarse entre ellas
 * 
 */
class session_user_test extends PHPUnit\Framework\TestCase {
	
    function mysetup( $evaluar )  {
        $session_user = new session_start_adaptador();
        $session_user->inicio();
        $actual = $evaluar( $session_user );
        $session_user->unset();
        $session_user->destroy();
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
	function test_session_name_fail(){
	    $actual = $this->mysetup( function( $session_user ) {
	        return $session_user->esta_registrada( "sarasaxyz" ) ;
	    }   );
		
		$this->assertEquals( false, $actual , "is_registered" );
	}
	

	
	/**
	 * @runInSeparateProcess
	 */
	function test_unset(){
	    $actual = $this->mysetup( function( $session_user ) {
	        $data = $session_user->get_data();
	        $data->set( "sarasa", "palomon" );
	        $session_user->unset();
	        return $data->get( "sarasa" );
	    }   );
		$this->assertEquals( "", $actual, "get" );

	}
	
	/**
	 * @runInSeparateProcess
	 */
	function test_unset_destroy(){
	        
	    $session_user = new session_start_adaptador();
	    $session_user->inicio();
	    $data = $session_user->get_data();
	    $data->set( "sarasa", "palomon" );
	    
		$session_user->unset();
		$session_user->destroy();
		$this->assertEquals( "", $data->get( "sarasa" ), "get" );
	}
	
	/**
	 * @runInSeparateProcess
	 */
	function test_data_unset(){
	    
	    $session_user = new session_start_adaptador();
	    $session_user->inicio();
	    $data = $session_user->get_data();
	    $data->set( "sarasa", "palomon" );
	    
	    $data->unset("sarasa");
	    
	    $this->assertEquals( "", $data->get( "sarasa" ), "get" );
	}
	
	
}

?>