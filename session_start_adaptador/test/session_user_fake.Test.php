<?php

use session_start_adaptador\session_start_adaptador_fake; 

class session_user_fakeTest extends PHPUnit\Framework\TestCase {
    
    /* dice setup pero en realidad 
     * hace una prueba y devuelve el resultado.
     */
    function mysetup( $evaluar )  {
        $session_user = new session_start_adaptador_fake();
        $session_user->inicio();
        $actual = $evaluar( $session_user );
        $session_user->unset();
        $session_user->destroy();
        return $actual;
    }
    
    function test_session_start(){
        $actual = $this->mysetup( 
            function( $session ) {
                return $session->estado();
        }   );
            
        $this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
    }
    
    function test_session_name_fail(){
        $actual = $this->mysetup( function( $session_user ) {
            return $session_user->esta_registrada( "sarasaxyz" ) ;
        }   );
            
        $this->assertEquals( false, $actual , "is_registered" );
    }

    function test_set_get(){
        $actual = $this->mysetup( 
            function( $session_user ) {
                $session_user->data_set( "sarasa", "palomon" );
                return $session_user->data_get( "sarasa" ) ;
        }   );
            
        $this->assertEquals( "palomon", $actual , "get" );
    }

    function test_unset(){
        $actual = $this->mysetup( 
            function( $session_user ) {
                $session_user->data_set( "sarasa", "palomon" );
                $session_user->unset();
                return $session_user->data_get( "sarasa" );
        }   );
        $this->assertEquals( "", $actual, "get" );
            
    }

    function test_unset_destroy(){
        
        $session_user = new session_start_adaptador_fake();
        $session_user->inicio();
        $session_user->data_set( "sarasa", "palomon" );
        $session_user->unset();
        $session_user->destroy(); 
        $this->assertEquals( "", $session_user->data_get( "sarasa" ), "get" );
    }
    
    function test_data_unset(){
        
        $session_user = new session_start_adaptador_fake();
        $session_user->inicio();
        $session_user->data_set( "sarasa", "palomon" );
        $session_user->data_unset("sarasa");
        $this->assertEquals( "", $session_user->data_get( "sarasa" ), "get" );
    }
    
    
}


?>