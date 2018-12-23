<?php
use session_start_adaptador\session_start_adaptador_interface;
use session_start_adaptador\session_start_adaptador;
use session_variable_adaptador\session_variable_adaptador_interface;
use session_variable_adaptador\session_variable_adaptador;

interface session_facade_interface 
extends session_start_adaptador_interface, session_variable_adaptador_interface {
    
}

class SessionFacade implements session_facade_interface {
    private $user; // session_start_adaptador();
    private $session; // session_variable_adaptador();
    
    private function __construct(){
    }
    public static function BuilderBasico() : session_facade_interface {
        $session = new SessionFacade();
        $session->user = new session_start_adaptador();
        $session->session = new session_variable_adaptador();
        return $session;
    }
        
    function iniciar(){
        $this->user->iniciar();
        
    }
    function estado(){
        return $this->user->estado();
    }
    function terminar(){
        $this->user->terminar();
    }
    function get( string $clave ){
        return $this->session->get($clave);
    }
    function set( string $clave, $valor ){
        $this->session->set($clave,$valor);
    }
    function unset( string $clave ){
        $this->session->unset($clave);
    }
}


class session_facade_Test extends PHPUnit\Framework\TestCase {
    /**
     * @runInSeparateProcess
     */
    function test_inicio(){
        $session = SessionFacade::BuilderBasico();

        $session->iniciar();
        $actual = $session->estado();
        
        $this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
        
    }

    /**
     * @runInSeparateProcess
     */
    function test_unset_destroy(){
        
        $session_user = SessionFacade::BuilderBasico();
        
        $session_user->iniciar();
        
        // $session_user->unset();
        $session_user->terminar();
        
        $this->assertEquals( PHP_SESSION_NONE, $session_user->estado() );
    }
    
    /**
     * @runInSeparateProcess
     */
    function test_set_get(){
        $session = SessionFacade::BuilderBasico();
        
        $session->iniciar();
        $session->set("algo", "sarasa");
        
        $this->assertEquals( "sarasa", $session->get("algo"), "set/get" );
        
    }
    
    
}

