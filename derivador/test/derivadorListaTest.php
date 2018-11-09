<?php
use derivador\derivadorLista;

/**
 * derivadorItem test case.
 */
class derivadorListaTest extends PHPUnit\Framework\TestCase {
    private $lista;
    private $url;
    function mysetup(){
        $this->url = "/sarasa";
        $funcion = function() {
            return true;
        };
        $this->lista = new derivadorLista();
        $this->lista->agregar( $this->url, $funcion  );
    }
    
    function __contruct(){
        $this->mysetup();
    }
    
    function testFuncion_CasoFeliz(){
        $this->mysetup();
        
        // no tengo manera de distingir una funcion anonima de otra
        // entonces tengo que valerme del resultado de la misma para saber si se ejecuto o no
        $ret = $this->lista->funcion( $this->url );
        
        $actual = $ret();
        $this->assertTrue( $actual );
        
    }

    function testExiste_CasoFeliz(){
        $this->mysetup();
        $this->assertTrue( $this->lista->existe( $this->url ) );
    }

    function testExiste_CasoInfeliz(){
        $this->mysetup();
        $this->assertFalse( $this->lista->existe( "/nadaquever" ) );
    }
    
}
?>