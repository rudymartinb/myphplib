<?php
use derivador\Derivador;

class derivadorTest extends PHPUnit\Framework\TestCase {

    function testCasoFeliz_1funcion(){
        $url = "/sarasa"; 
        $funcion = function() {
            $this->assertTrue( true );  
        };
        
        $derivador = new Derivador();
        
        $derivador->agregar( $url, $funcion );
        $derivador->ejecutar( $url );
    }
    
    /* no tiene sentido correr ejecutar() con un dato inexistente sin verificar nada
     * (la prueba es demasiado trivial y no demuestra nada por si misma)
     * tiene mas color hacer la prueba sobre existe() que devuelve algo
     * 
     *   la idea de default() es determinar que hacer cuando no hay una funcion valida
     *   probablemente cargaremos un 404
     */
    function testFail(){
        $derivador = new Derivador();
        
        $funcion = function() {
            $this->assertTrue( true );
        };
        
        $derivador->default( $funcion );
        
        $derivador->ejecutar( "/estonohacenada" );
        
    }
    
}
?>