<?php

use session_start_adaptador\session_start_adaptador_fake; 

class session_start_adaptador_fakeTest extends PHPUnit\Framework\TestCase {
    
    /* dice setup pero en realidad 
     * hace una prueba y devuelve el resultado 
     * para se evaluado por la "prueba" 
     */
    function mysetup( callable $evaluar )  {
        $session_user = new session_start_adaptador_fake();
        $session_user->iniciar();
        $actual = $evaluar( $session_user );
        $session_user->terminar();
        return $actual;
    }
    
    function test_session_start(){
        $actual = $this->mysetup( 
            function( $session ) {
                return $session->estado();
        }   );
            
        $this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
    }
    
    function test_unset_destroy(){
        
        $session_user = new session_start_adaptador_fake();
        $session_user->iniciar();
        $session_user->terminar();
        
        $this->assertEquals( PHP_SESSION_NONE, $session_user->estado() );
        
    }
    
    
}


?>