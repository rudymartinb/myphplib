<?php

require_once( "db/mysql_wrapper.php" );
require_once( "test/credencialessql.php" );

require_once 'test/mysql_wrapper_OK_Test.php';
require_once 'test/mysql_wrapper_fail_Test.php';


/**
 * Static test suite.
 */
class mymphplibSuite extends PHPUnit\Framework\TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('mymphplibSuite');

        $this->addTestSuite('mysql_wrapper_OK_Test');

        $this->addTestSuite('mysql_wrapper_fail_Test');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

