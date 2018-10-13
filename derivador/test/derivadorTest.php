<?php

use derivador\Derivador;

/**
 * derivador test case.
 */
class derivadorTest extends PHPUnit\Framework\TestCase
{

    function testSarasa(){
        $este = $this;
        $url = "/sarasa"; 
        $funcion = function() use ($este){ $este->assertTrue( true );  };
        
        $derivador = new Derivador();
        
        $derivador->agregar( $url, $funcion );
        $derivador->ejecutar( $url );
    }
    
    function testFail(){
        $derivador = new Derivador();
        
        $derivador->ejecutar( "/nada" );
        $this->assertTrue( true );
    }
    
}
?>