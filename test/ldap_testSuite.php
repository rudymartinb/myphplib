<?php

// ---------------
require_once 'ldap/ldap_interface.php';
require_once 'ldap/ldap.php';

require_once 'ldap/test/ldap.Test.php';

/** 
 * Static test suite.
 */
class ldap_testSuite extends PHPUnit\Framework\TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('ldap_testSuite');

        $this->addTestSuite('ldap_test');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

?>