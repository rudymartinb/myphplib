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
require_once( "session_start_adaptador/session_user_interface.php" );
require_once( "session_start_adaptador/session_start_adaptador.php" );
require_once( "session_start_adaptador/session_start_adaptador_fake.php" );

require_once 'session_start_adaptador/test/session_user.Test.php';
require_once 'session_start_adaptador/test/session_user_fake.Test.php';

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



class mymphplibSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('mymphplibSuite');

        $this->addTestSuite( 'session_user_test' );
        $this->addTestSuite( 'session_user_faketest' );
        
        $this->addTestSuite( 'derivadorTest' );
        
        $this->addTestSuite( 'session_variable_adaptador_Test' );
        $this->addTestSuite( 'session_variable_adaptador_fake_Test' );
        
        $this->addTestSuite( 'myheaders_test' );
        $this->addTestSuite( 'myheaders_fakeTest' );
        
        $this->addTestSuite( 'menutest' );
        
    }

    public static function suite() {
        return new self();
    }
}

?>