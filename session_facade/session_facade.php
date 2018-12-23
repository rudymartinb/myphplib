<?php
namespace session_facade;

use session_start_adaptador\session_start_adaptador_interface;
use session_start_adaptador\session_start_adaptador;
use session_start_adaptador\session_start_adaptador_fake;
use session_variable_adaptador\session_variable_adaptador_interface;
use session_variable_adaptador\session_variable_adaptador;
use session_variable_adaptador\session_variable_adaptador_fake;

interface session_facade_interface
    extends session_start_adaptador_interface, 
    session_variable_adaptador_interface {
    
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

    public static function BuilderFake() : session_facade_interface {
        $session = new SessionFacade();
        $session->user = new session_start_adaptador_fake();
        $session->session = new session_variable_adaptador_fake();
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
?>