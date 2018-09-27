<?php

class credenciales_OK_Test extends PHPUnit\Framework\TestCase {
	 
	public function test_gethostname(){
		// si no existe el archivo $_SERVER["HOME"]."/.creds/local.mysql.cred"
		// esta prueba falla
		$list = leercreds();
		
		$this->assertEquals( "root" , $list["user"] );
	}
}
?>