<?php
use session_facade\SessionFacade;
use session_facade\session_facade_interface;


class session_facade_Test extends session_facade_Tester {
    
    function mysetup() : session_facade_interface {
        $session = SessionFacade::BuilderBasico();
        $session->iniciar();
        return $session;
    }
    
    
}

