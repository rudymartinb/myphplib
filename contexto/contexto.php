<?php
namespace contexto;

use \session_variable_adaptador\session_variable_adaptador_interface;
use \session_variable_adaptador\session_variable_adaptador;

class Contexto implements session_variable_adaptador_interface {
    
    function __construct(){
        $this->variables = new session_variable_adaptador();
    }
    
    
    private $variable; // TODO: que nombre mejor hay?
    public function set(string $clave, $valor) {
        $this->variables->set( $clave, $valor );
    }
    
    public function get(string $clave) {
        return $this->variables->get( $clave );
    }
    
    public function unset(string $clave) {
        $this->variables->unset( $clave );
        
    }
    
    public function setVariable( session_variable_adaptador_interface $session ){
        $this->variable = $session;
    }
    
}
?>