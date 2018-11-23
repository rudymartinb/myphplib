<?php


require_once 'ldap_adaptador/ldap_interface.php';
require_once 'ldap_adaptador/ldap.php';

require_once 'ldap_adaptador/test/ldap.Test.php';

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