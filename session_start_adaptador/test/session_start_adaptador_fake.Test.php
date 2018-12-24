<?php

use session_start_adaptador\session_start_adaptador_fake; 

class session_start_adaptador_fakeTest extends session_start_adaptador_tester  {
    
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
    
    
}


?>