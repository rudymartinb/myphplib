<?php

// ---------------
require_once 'derivador/derivadorLista.php';
require_once 'derivador/test/derivadorListaTest.php';

require_once 'derivador/derivador.php';
require_once 'derivador/test/derivadorTest.php';


// session_data
require_once "session_data/session_data_interface.php" ;
require_once "session_data/session_data.php" ;
require_once "session_data/session_data_fake.php" ;
require_once "session_data/test/session_data_Test.php" ;
require_once "session_data/test/session_data_fake.Test.php" ;

// ---------------
require_once( "session_user/session_user_interface.php" );
require_once( "session_user/session_user.php" );
require_once( "session_user/session_user_fake.php" );

require_once 'session_user/test/session_user.Test.php';
require_once 'session_user/test/session_user_fake.Test.php';

class mymphplibSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('mymphplibSuite');

        // $this->addTestSuite( 'credenciales_OK_Test' );
        
//         $this->addTestSuite( 'mysql_wrapper_OK_Test' );
//         $this->addTestSuite( 'mysql_wrapper_fail_Test' );
        
//         $this->addTestSuite( 'mysql_mock_OK_Test' ); 
        
        $this->addTestSuite( 'session_user_test' );
        $this->addTestSuite( 'session_user_faketest' );
        
        $this->addTestSuite( 'derivadorTest' );
        $this->addTestSuite( 'derivadorListaTest' );
        
        
        // $this->addTestSuite( 'ldap_test' );
        
        $this->addTestSuite( 'session_data_Test' );
        $this->addTestSuite( 'session_data_fake_Test' );
        
    }

    public static function suite() {
        return new self();
    }
}

?>