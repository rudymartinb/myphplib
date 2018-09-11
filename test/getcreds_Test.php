<?php

require_once( "credencialessql.php" );

class credenciales_OK_Test extends PHPUnit\Framework\TestCase {
	 
	public function test_gethostname(){
		// print_r($_SERVER);
		
		// si no existe el archivo $_SERVER["HOME"]."/.creds/local.mysql.cred"
		// esta prueba falla
		$list = leercreds();
		
		$this->assertEquals( "root" , $list["user"] );
		// no se la pwd !
		// $this->assertEquals( "" , $list["pwd"] );
	}
}
?>