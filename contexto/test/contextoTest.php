<?php
use contexto\Contexto;
use session_variable_adaptador\session_variable_adaptador_fake;

/*
 * la idea de esta clase de objeto 
 * es encapsular los diferentes estados 
 * que puede tener el sistema a travez de diferentes variables y funciones
 * y que pueda ser pasada a diferntes casos de uso usando poliformismo
 * 
 */

class contextoTest extends PHPUnit\Framework\TestCase {
    
    /* por ahora solo session_variable_*_interface
     * despues veo que agrego
     */    
    function testNew(){ 
        $contexto = new Contexto();
        $contexto->setVariable( new session_variable_adaptador_fake() );
        
        $contexto->set("sarasa", "palomon");
        $this->assertEquals( "palomon", $contexto->get("sarasa") );
        
    }
}

?>