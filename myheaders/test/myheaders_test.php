<?php

use myheaders\MyHeaders;

/**
 * MyHeaders test case.
 */
class MyHeaders_Test extends PHPUnit\Framework\TestCase {
    
    function test_new(){
        $webserver = new MyHeaders();
        try {
            $webserver->enviar( "Location:/" );
            $this->assertTrue( false );
        } catch( Exception $e ) {
            $esperado = "Cannot modify header information - headers already sent by (output started at";
            $actual = $e->getMessage();
            $this->assertEquals( $esperado, substr( $actual, 0, strlen( $esperado )  ) );
        }
        
    }
    function test_sent(){
        $webserver = new MyHeaders();
        $this->assertTrue( $webserver->enviados() );
    }
    
}

