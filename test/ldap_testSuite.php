<?php


require_once 'ldap/ldap_interface.php';
require_once 'ldap/ldap.php';

require_once 'ldap/test/ldap.Test.php';

class ldap_testSuite extends PHPUnit\Framework\TestSuite {

    public function __construct(){
        $this->setName('ldap_testSuite');
        
        $this->addTestSuite('ldap_test');
    }

    public static function suite(){
        return new self();
    }
}

?>