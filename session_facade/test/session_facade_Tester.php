<?php

/* 
 * estas pruebas validan tanto la version normal del facade como la fake
 * 
 * eliminar el @runInSeparateProcess
 * causa que las pruebas fallen
 * 
 * funciona con phpunit 7 
 */
use session_facade\session_facade_interface;
abstract class session_facade_Tester extends PHPUnit\Framework\TestCase {
    abstract function mysetup() : session_facade_interface ;
    
    /** @runInSeparateProcess
     */
    function test_inicio(){
        $session = $this->mysetup() ;
        
        $actual = $session->estado();
        
        $this->assertEquals( PHP_SESSION_ACTIVE, $actual, "PHP_SESSION_ACTIVE" );
        
    }
    
    /** @runInSeparateProcess
     */
    function test_destroy(){
        $session = $this->mysetup() ;
        
        $session->terminar();
        
        $this->assertEquals( PHP_SESSION_NONE, $session->estado() );
    }
    
    /** @runInSeparateProcess
     */
    function test_set_get(){
        $session = $this->mysetup() ;
        
        $session->set("algo", "sarasa");
        
        $this->assertEquals( "sarasa", $session->get("algo"), "set/get" );
    }
    
    /** @runInSeparateProcess
     */
    function test_set_unset(){
        $session = $this->mysetup() ;
        
        $session->set("algo", "sarasa");
        
        $session->unset( "algo" );
        $this->assertEquals( "", $session->get("algo"), "set/unset" );
        
    }
    
}
?>