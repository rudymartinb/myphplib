<?php

error_reporting(E_ALL);

class nose {
	private function  __construct() {
	}
}

class construct_Test extends PHPUnit\Framework\TestCase {
	function test1(){
		$nose = new nose();
	}
}
?>