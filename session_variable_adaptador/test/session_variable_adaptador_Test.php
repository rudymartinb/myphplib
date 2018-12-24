<?php
use session_variable_adaptador\session_variable_adaptador;
use session_variable_adaptador\session_variable_adaptador_interface;

class session_variable_adaptador_Test extends session_variable_adaptador_Tester {
    function mysetup( ) : session_variable_adaptador_interface {
        $session = new session_variable_adaptador();
        return $session;
    }

	
}

?>