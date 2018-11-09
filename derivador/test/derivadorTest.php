<?php
use derivador\Derivador;

class derivadorTest extends PHPUnit\Framework\TestCase {

    function testCasoFeliz(){
        $url = "/sarasa"; 
        $funcion = function() {
            $this->assertTrue( true );  
        };
        
        $derivador = new Derivador();
        
        $derivador->agregar( $url, $funcion );
        $derivador->ejecutar( $url );
    }
    
    /*
     * no tiene sentido correr ejecutar() con un dato inexistente sin verificar nada
     * (la prueba es demasiado trivial y no demuestra nada por si misma)
     * tiene mas color hacer la prueba sobre existe() que devuelve algo  
     */
    function testFail(){
        $derivador = new Derivador();
        $derivador->ejecutar( "/estonohacenada" );

        $this->assertFalse( $derivador->existe( "/estotampoco" ) );
    }
    
}
?>