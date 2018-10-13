<?php

use myphplib\session\session_user_fake;

/**
 * session_user_fake test case.
 */
class session_user_fakeTest extends PHPUnit\Framework\TestCase {
    
    /*
     * este metodo ejecuta las acciones que luego son evaluadas 
     * en los demas metodos. se le pasa una funcion anonima 
     * con el objeto sobre el cual se ejecuta lo que se busca evaluar
     */
    function mysetup( $evaluar )  {
        $session_user = new session_user_fake();
        $session_user->start();
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
            return $session->status();
        }   );
            
        $this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
    }
    
    
    /**
     * @runInSeparateProcess
     */
    function test_session_name_fail(){
        $actual = $this->mysetup( function( $session_user ) {
            return $session_user->is_registered( "sarasaxyz" ) ;
        }   );
            
        $this->assertEquals( false, $actual , "is_registered" );
    }
    /**
     * @runInSeparateProcess
     */
    function test_set_get(){
        $actual = $this->mysetup( function( $session_user ) {
            $session_user->set( "sarasa", "palomon" );
            return $session_user->get( "sarasa" ) ;
        }   );
            
        $this->assertEquals( "palomon", $actual , "get" );
    }
    /**
     * @runInSeparateProcess
     */
    function test_unset(){
        $actual = $this->mysetup( function( $session_user ) {
            $session_user->set( "sarasa", "palomon" );
            $session_user->unset();
            return $session_user->get( "sarasa" );
        }   );
        $this->assertEquals( "", $actual, "get" );
            
    }
    /**
     * @runInSeparateProcess
     */
    function test_unset_destroy(){
        
        $session_user = new session_user_fake();
        $session_user->start();
        $session_user->set( "sarasa", "palomon" );
        $session_user->unset();
        $session_user->destroy();
        $this->assertEquals( "", $session_user->get( "sarasa" ), "get" );
    }
    
}


?>