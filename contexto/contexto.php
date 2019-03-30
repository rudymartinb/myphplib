<?php
namespace contexto;

use session_variable_adaptador\session_variable_adaptador_interface;
use session_variable_adaptador\session_variable_adaptador;

/*
 * creo que Contexto deberia ser un Facade 
 * que implemente varias de las clases que tiene esta liberia
 * base de datos
 * derivador?
 *  
 */
class Contexto implements session_variable_adaptador_interface {
    
    function __construct(){
        // estamos hablando de un atributo que funcione como $_SESSIONS
        $this->variables = new session_variable_adaptador();
    }
     
    
    private $variables; // TODO: que nombre mejor hay?
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