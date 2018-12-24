<?php
use session_start_adaptador\session_start_adaptador;


class session_start_adaptador_test extends session_start_adaptador_tester  {
	
    function mysetup( callable $evaluar )  {
        $session_user = new session_start_adaptador();
        $session_user->iniciar();
        $actual = $evaluar( $session_user );
        $session_user->terminar();
        return $actual;
    }
	
}

?>