<?php
use derivador\derivadorLista;

/**
 * derivadorItem test case.
 */
class derivadorListaTest extends PHPUnit\Framework\TestCase {
    function testNew(){
        $url = "/sarasa";
        $funcion = function(){
          return true;  
        };
        
        $lista = new derivadorLista();
        $lista->agregar( $url, $funcion  );
        
        $this->assertTrue( $lista->existe( $url ) );
        
    }
    
    function testFuncion(){
        $url = "/sarasa";
        $funcion = function(){
            return true;
        };
        
        $lista = new derivadorLista();
        $lista->agregar( $url, $funcion  );
        
        $ret = $lista->funcion( $url );
        $this->assertTrue( is_callable( $ret ) );
        
        
    }
    
}
?>