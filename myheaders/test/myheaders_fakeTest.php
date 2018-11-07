<?php
use myheaders\MyHeaders_fake;
/**
 * myheaders_fake test case.
 */
class myheaders_fakeTest extends PHPUnit\Framework\TestCase {
    function test_new(){
        $webserver = new MyHeaders_fake();
        $webserver->enviar( "Location:/" );
        $this->assertTrue( $webserver->enviados() );
    }

}

