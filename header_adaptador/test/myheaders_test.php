<?php
use header_adaptador\header_adaptador_interface; 
use header_adaptador\HeaderAdaptador; 
abstract class myheaders_tester extends PHPUnit\Framework\TestCase {
    abstract function mysetup() : header_adaptador_interface;

    function test_new(){
        $webserver = $this->mysetup();
        try {
            $webserver->enviar( "Location:/" );
            $this->assertTrue( false );
        } catch( Exception $e ) {
            $this->assertTrue( true );
//             $esperado = "Cannot modify header information - headers already sent by (output started at";
//             $actual = $e->getMessage();
//             $this->assertEquals( $esperado, substr( $actual, 0, strlen( $esperado )  ) );
        }
        
    }
    
}
class myheaders_test extends myheaders_tester {
    function mysetup() : header_adaptador_interface {
        return new HeaderAdaptador();
    }
    
    function test_sent(){
        $webserver = new HeaderAdaptador();
        $this->assertTrue( $webserver->enviados() );
    }
    
}

