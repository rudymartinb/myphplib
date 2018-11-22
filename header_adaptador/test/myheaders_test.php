<?php
use header_adaptador\HeaderAdaptador; 
class myheaders_test extends PHPUnit\Framework\TestCase {
    
    function test_new(){
        $webserver = new HeaderAdaptador();
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
        $webserver = new HeaderAdaptador();
        $this->assertTrue( $webserver->enviados() );
    }
    
}

