<?php

use session_facade\SessionFacade;
use session_facade\session_facade_interface;

/*
 * no hay version fake de la clase de objeto
 * solo cambia el constructor
 */
class session_facade_fake_Test extends session_facade_Tester  {
    
    function mysetup() : session_facade_interface {
        $session = SessionFacade::BuilderFake();
        $session->iniciar();
        return $session;
    }

    
}

