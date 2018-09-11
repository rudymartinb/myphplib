<?php

/*
 * esta prueba *no* incluida en el test Suite
 */
error_reporting(E_ALL);

class nose {
	private function  __construct() {
	}
}

class construct_Test extends PHPUnit\Framework\TestCase {
	function test1(){
	    // al habilitar esta prueba 
	    // y al estar el construct en private deberia fallar
		$nose = new nose();
		
		$this->assertNull( $nose );
	}
}
?>