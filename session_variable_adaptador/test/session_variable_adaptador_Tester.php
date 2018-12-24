<?php

abstract class session_variable_adaptador_Tester extends PHPUnit\Framework\TestCase {
    /**
     * @runInSeparateProcess
     */
    function test_set_get(){
        $session = $this->mysetup();
        
        $session->set( 'sarasa', 'palomon' );
        $this->assertEquals( "palomon", $session->get("sarasa") );
    }
    
    /**
     * @runInSeparateProcess
     */
    function test_set_unset(){
        $session = $this->mysetup();
        $session->set( 'sarasa', 'palomon' );
        $session->unset( 'sarasa' );
        
        $this->assertEquals( "", $session->get( 'sarasa') );
    }
    
    /**
     * @runInSeparateProcess
     */
    function test_get_fail(){
        $session = $this->mysetup();
        $this->assertEquals( "", $session->get( "sarasax" ) );
    }
    
    /**
     * @runInSeparateProcess
     */
    function test_get_fail2(){
        $session = $this->mysetup();
        // variable usada en prueba anterior
        // si eliminamos el @runInSeparateProcess
        // podria dar error
        $this->assertEquals( "", $session->get( "sarasa" ) );
    }
    
}
?>