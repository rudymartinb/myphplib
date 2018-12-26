<?php
use header_adaptador\header_adaptador_interface;
use header_adaptador\HeaderAdaptadorFake; 
/**
 * myheaders_fake test case.
 */
class myheaders_fakeTest extends myheaders_tester {
    function mysetup() : header_adaptador_interface {
        return new HeaderAdaptadorFake();
    }
    //     function test_new(){
//         $webserver = new HeaderAdaptadorFake();
//         $webserver->enviar( "Location:/" );
//         $this->assertTrue( $webserver->enviados() );
//     }

}

