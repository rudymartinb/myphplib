<?php
use header_adaptador\HeaderAdaptadorFake; 
/**
 * myheaders_fake test case.
 */
class myheaders_fakeTest extends PHPUnit\Framework\TestCase {
    function test_new(){
        $webserver = new HeaderAdaptadorFake();
        $webserver->enviar( "Location:/" );
        $this->assertTrue( $webserver->enviados() );
    }

}

