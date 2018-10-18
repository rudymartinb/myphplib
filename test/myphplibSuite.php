<?php
require_once( "db/mysql_interface.php" );
require_once( "db/mysql_wrapper.php" );
require_once( "db/mysql_query_mock.php" );

require_once( "db/test/credencialessql.php" );


require_once 'db/test/mysql_mock.Test.php';
require_once 'db/test/mysql_wrapper_OK_Test.php';
require_once 'db/test/mysql_wrapper_fail_Test.php';

// ---------------
require_once( "session/session_user.php" );
require_once( "session/session_user_fake.php" );

require_once 'session/test/session_user.Test.php';
require_once 'session/test/session_user_fake.Test.php';

// ---------------
require_once 'derivador/derivadorLista.php';
require_once 'derivador/test/derivadorListaTest.php';

require_once 'derivador/derivador.php';
require_once 'derivador/test/derivadorTest.php';

// ---------------
require_once 'ldap/ldap_interface.php';
require_once 'ldap/ldap.php';

require_once 'ldap/test/ldap.Test.php';

// session_data
require_once "session_data/session_data.php" ;
require_once "session_data/session_data_fake.php" ;
require_once "session_data/test/session_data_Test.php" ;
require_once "session_data/test/session_data_fake.Test.php" ;




class mymphplibSuite extends PHPUnit\Framework\TestSuite {

    public function __construct() {
        $this->setName('mymphplibSuite');

        // $this->addTestSuite( 'credenciales_OK_Test' );
        
        $this->addTestSuite( 'mysql_wrapper_OK_Test' );
        $this->addTestSuite( 'mysql_wrapper_fail_Test' );
        
        $this->addTestSuite( 'mysql_mock_OK_Test' );
        
        $this->addTestSuite( 'session_user_test' );
        $this->addTestSuite( 'session_user_faketest' );
        
        $this->addTestSuite( 'derivadorTest' );
        $this->addTestSuite( 'derivadorListaTest' );
        
        $this->addTestSuite( 'ldap_test' );
        
        $this->addTestSuite( 'session_data_Test' );
        $this->addTestSuite( 'session_data_fake_Test' );
        
    }

    public static function suite() {
        return new self();
    }
}
?>