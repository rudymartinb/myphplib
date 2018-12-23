<?php

/* aqui van todas las pruebas de clases de objeto 
 * que no dependen de servicios externos como MySQL o LDAP
 */

/* la idea del derivador esta afanda de nodejs
 * y se supone que tengo que engancharlo con seguridad de usuarios 
 */
require_once 'derivador/derivador.php';
require_once 'derivador/test/derivadorTest.php';


// session_data (encapsulsa la variable $SESSION y una clase que la simula )
require_once "session_variable_adaptador/session_variable_adaptador_interface.php" ;
require_once "session_variable_adaptador/session_variable_adaptador.php" ;
require_once "session_variable_adaptador/session_variable_adaptador_fake.php" ;

require_once "session_variable_adaptador/test/session_variable_adaptador_Test.php" ;
require_once "session_variable_adaptador/test/session_variable_adaptador_fake.Test.php" ;

// encapsula session_start()
require_once "session_start_adaptador/session_start_adaptador_interface.php" ;
require_once "session_start_adaptador/session_start_adaptador.php" ;
require_once "session_start_adaptador/session_start_adaptador_fake.php" ;

require_once 'session_start_adaptador/test/session_start_adaptador.Test.php';
require_once 'session_start_adaptador/test/session_start_adaptador_fake.Test.php';

// session_facade (agrupa los dos anteriores)
require_once 'session_facade/session_facade.php';
require_once 'session_facade/test/session_facade.Test.php';

// encapsula headers() 
require_once 'header_adaptador/header_adaptador_interface.php';
require_once 'header_adaptador/header_adaptador.php';
require_once 'header_adaptador/header_adaptador_fake.php';

require_once 'header_adaptador/test/myheaders_test.php';
require_once 'header_adaptador/test/myheaders_fakeTest.php';

// seguridad_usuarios
require_once 'menu/menu.php';
require_once 'menu/menu_primario.php';
require_once 'menu/test/menu.Test.php';

// usecase
require_once 'usecase/UseCase.php';
require_once 'usecase/test/UseCaseTest.php';

require_once 'contexto/contexto.php';
require_once 'contexto/test/contextoTest.php';


class mymphplibSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('mymphplibSuite');

        $this->addTestSuite( 'session_start_adaptador_test' );
        $this->addTestSuite( 'session_start_adaptador_faketest' );
        
        $this->addTestSuite( 'derivadorTest' );
        
        $this->addTestSuite( 'session_variable_adaptador_Test' );
        $this->addTestSuite( 'session_variable_adaptador_fake_Test' );
        
        $this->addTestSuite( 'myheaders_test' );
        $this->addTestSuite( 'myheaders_fakeTest' );
        
        $this->addTestSuite( 'menuTest' );
        
        $this->addTestSuite( 'UseCaseTest' );
        
        $this->addTestSuite( 'contextoTest' );
        
        $this->addTestSuite( 'session_facade_Test' );
        
    }

    public static function suite() {
        return new self();
    }
}

?>