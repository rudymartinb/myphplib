<?php

require_once( "db/mysql_interface.php" );
require_once( "db/mysql_wrapper.php" );
require_once( "db/mysql_query_mock.php" );

require_once( "db/test/credencialessql.php" );


require_once 'db/test/mysql_mock.Test.php';
require_once 'db/test/mysql_wrapper_OK_Test.php';
require_once 'db/test/mysql_wrapper_fail_Test.php';

class db_testSuite extends PHPUnit\Framework\TestSuite {


    public function __construct() {
        $this->setName('db_testSuite');

        $this->addTestSuite('mysql_wrapper_fail_Test');
        $this->addTestSuite('mysql_mock_OK_Test');
        $this->addTestSuite('mysql_wrapper_OK_Test');
        
    }

    public static function suite() {
        return new self();
    }
}
?>
