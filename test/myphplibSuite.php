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
require_once "session_data/session_data_interface.php" ;
require_once "session_data/session_data.php" ;
require_once "session_data/session_data_fake.php" ;

require_once "session_data/test/session_data_Test.php" ;
require_once "session_data/test/session_data_fake.Test.php" ;

// encapsula session_start()
require_once( "session_user/session_user_interface.php" );
require_once( "session_user/session_user.php" );
require_once( "session_user/session_user_fake.php" );

require_once 'session_user/test/session_user.Test.php';
require_once 'session_user/test/session_user_fake.Test.php';

require_once 'seguridad_usuarios/test/seguridad_usuarios.Test.php';

// encapsula headers()
require_once 'myheaders/myheaders_interface.php';
require_once 'myheaders/myheaders.php';
require_once 'myheaders/myheaders_fake.php';

require_once 'myheaders/test/myheaders_test.php';
require_once 'myheaders/test/myheaders_fakeTest.php';

class mymphplibSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('mymphplibSuite');

        $this->addTestSuite( 'session_user_test' );
        $this->addTestSuite( 'session_user_faketest' );
        
        $this->addTestSuite( 'derivadorTest' );
        
        $this->addTestSuite( 'session_data_Test' );
        $this->addTestSuite( 'session_data_fake_Test' );
        
        $this->addTestSuite( 'MyHeaders_Test' );
        $this->addTestSuite( 'myheaders_fakeTest' );
        
        // $this->addTestSuite( 'seguridad_usuariosTest' );
        
    }

    public static function suite() {
        return new self();
    }
}

?>